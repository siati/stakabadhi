<?php

namespace frontend\modules\institution\controllers;

use Yii;
use common\models\Sections;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Documents;
use yii\web\UploadedFile;
use common\models\StaticMethods;
use common\models\DocumentsPermissions;
use common\models\DocumentsMailings;
use common\models\DocumentsMailingsContacts;
use common\models\SlideImages;
use common\models\Logs;
use common\models\User;

/**
 * SectionsController implements the CRUD actions for Sections model.
 */
class SectionsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'upload-files', 'make-directory', 'load-directory', 'reload-navigation', 'document-properties', 'open-file', 'open-file-for-update', 'unlock-file', 'update-file', 'document-versions',
                    'download-document-version', 'drop-document-versions', 'revert-from-history', 'copy-or-move-file', 'zip-and-export', 'document-mailing-modal', 'mailing-contacts', 'mailing-contact',
                    'delete-contact', 'send-files', 'push-schemes-of-work', 'drop-exported-file', 'file-updatability', 'change-name-of-file', 'duplicate-file', 'archive-file', 'restore-archived-file', 'recycle-file', 'restore-recycled-file',
                    'drop-file', 'privileges-modal', 'load-content-folder', 'all-sections', 'users', 'details', 'expire-section', 'drop-section', 'user-section-right', 'section-document-right', 'update-doc-description',
                    'doc-description', 'opened-for-update', 'slide-images', 'slide-images-panes', 'update-slide-image', 'active-slide-image', 'delete-slide-image', 'documents-user-has-right-to', 'search-documents', 'repositories',
                    'index', 'create', 'delete'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'upload-files', 'make-directory', 'load-directory', 'reload-navigation', 'document-properties', 'open-file', 'open-file-for-update', 'unlock-file', 'update-file', 'document-versions',
                            'download-document-version', 'drop-document-versions', 'revert-from-history', 'copy-or-move-file', 'zip-and-export', 'document-mailing-modal', 'mailing-contacts', 'mailing-contact',
                            'delete-contact', 'send-files', 'push-schemes-of-work', 'drop-exported-file', 'file-updatability', 'change-name-of-file', 'duplicate-file', 'archive-file', 'restore-archived-file', 'recycle-file', 'restore-recycled-file',
                            'drop-file', 'privileges-modal', 'load-content-folder', 'all-sections', 'users', 'details', 'expire-section', 'drop-section', 'user-section-right', 'section-document-right', 'update-doc-description',
                            'doc-description', 'opened-for-update', 'slide-images', 'slide-images-panes', 'update-slide-image', 'active-slide-image', 'delete-slide-image', 'documents-user-has-right-to', 'search-documents', 'repositories'
                        ],
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['create', 'update', 'index', 'delete', 'view'],
                        'allow' => false,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                ],
            ],
        ];
    }

    /**
     * save uploaded files
     */
    public function actionUploadFiles() {

        $model = Documents::documentToLoad($_POST['Documents']['id'], $_POST['Documents']['directory'], $_POST['Documents']['name'], null, $_POST['Documents']['file_level'], Documents::FILE_IS_DOCUMENT, $_POST['Documents']['status'], true);

        if (is_object($parent = Documents::returnDocument($model->directory)) && $parent->documentCanBeUploadedFilesIntoByUser($parent->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN])))
            if ($model->load(Yii::$app->request->post()) && $instance = UploadedFile::getInstance($model, 'filename')) {

                StaticMethods::saveUploadedFile($model, 'filename', $instance, StaticMethods::dirSubRoot(Documents::subDirNameForStatus($model->status)), (empty($_POST['folder']) ? ('') : ($_POST['folder'])), StaticMethods::stripNonNumeric(StaticMethods::now()));

                empty($model->name) || $model->name == $instance->name ? $model->name = substr(str_replace('.' . $instance->extension, '', $instance->name), 0, 39) : '';

                echo!$model->hasErrors('filename') && $model->modelSave();

                $model->hasErrors() ? $model->modelDelete() : '';

                Yii::$app->end();
            }

        echo false;
    }

    /**
     * make directory - only if not exists
     */
    public function actionMakeDirectory() {
        $model = Documents::documentToLoad($_POST['Documents']['id'], $_POST['Documents']['directory'], $_POST['Documents']['name'], null, $_POST['Documents']['file_level'], Documents::FILE_IS_DIRECTORY, $_POST['Documents']['status'], true);

        if ((is_object($parent = Documents::returnDocument($model->directory)) && $parent->documentCanBeCreatedFolderIntoByUser($parent->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]))) || (!is_object($parent) && $model->file_level == Documents::min_client_document_level && Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN])))
            if ($model->load(Yii::$app->request->post())) {

                $location = StaticMethods::dirSubRoot(Documents::subDirNameForStatus($model->status)) . ($model->filename = (empty($_POST['folder']) ? ('') : ($_POST['folder'] . '/')) . StaticMethods::stripNonNumeric(StaticMethods::now()));

                if (!is_dir($location) && mkdir($location, 0777, true))
                    echo!$model->hasErrors('filename') && $model->modelSave();

                $model->hasErrors() ? $model->modelDelete() : '';

                Yii::$app->end();
            }

        echo false;
    }

    /**
     * load files and folders of a selected directory onto view
     * 
     * @return mixed
     */
    public function actionLoadDirectory() {
        $dir_contents = Documents::directoryContentList($name = Documents::fileNameFromTheClient($_POST['filename'], $_POST['status']), StaticMethods::dir_unrecursive, StaticMethods::files_and_folders, null);

        $dirContentsWithPrivileges = Documents::modelDocumentNavigationPrivileges($dir_contents, $_POST['level'], $_POST['status'], Yii::$app->user->identity->id);

        $addFolder = Documents::folderCanBeAddedFolder($name);

        $dirDropable = Documents::folderCanReceiveFilesFromClient($_POST['level'], $_POST['status']);

        $dirCustomMenu = Documents::hasCustomMenu($_POST['level']);

        $fileDropable = Documents::folderCanReceiveFilesFromClient($_POST['level'] - 1, $_POST['status']);

        $fileCustomMenu = Documents::hasCustomMenu($_POST['level'] - 1);

        return $this->renderPartial('directory-content-pane', [
                    'folders' => $this->renderPartial('directory-content-pane-folders', ['documents' => $dirContentsWithPrivileges[0], 'dir_contents' => $dirContentsWithPrivileges[3], 'status' => $_POST['status'], 'level' => $_POST['level'], 'dropable' => $dirDropable, 'customMenu' => $dirCustomMenu, 'rights' => $dirContentsWithPrivileges[2], 'preferredRights' => $dirContentsWithPrivileges[5], 'is_admin' => $dirContentsWithPrivileges[6]]),
                    'files' => $this->renderPartial('directory-content-pane-files', ['documents' => $dirContentsWithPrivileges[1], 'dir_contents' => $dirContentsWithPrivileges[4], 'status' => $_POST['status'], 'level' => $_POST['level'], 'dropable' => $fileDropable, 'addFolder' => $addFolder, 'customMenu' => $fileCustomMenu, 'rights' => $dirContentsWithPrivileges[2], 'preferredRights' => $dirContentsWithPrivileges[5], 'is_admin' => $dirContentsWithPrivileges[6]]),
                    'dropable' => $fileDropable,
                    'addFolder' => $addFolder,
                    'customMenu' => $fileCustomMenu
                        ]
        );
    }

    /**
     * reload the navigation pane onto view
     * 
     * @return mixed
     */
    public function actionReloadNavigation() {
        return $this->directoryNavigationTree(Documents::min_root_document_level, $status = $_POST['status'], Documents::fileNameFromTheClient($_POST['filename'], $status));
    }

    /**
     * load properties of a selected document
     */
    public function actionDocumentProperties() {
        return $this->documentProperties(Documents::fileNameFromTheClient($_POST['filename'], $status = $_POST['status']), $status, $_POST['level']);
    }

    /**
     * open a file for view
     */
    public function actionOpenFile() {
        echo is_object($document = Documents::returnDocument($_POST['id'])) ? $document->downloadFile($_POST['status']) : Documents::file_not_in_db;
    }

    /**
     * open a file for update
     */
    public function actionOpenFileForUpdate() {
        if (is_object($document = Documents::returnDocument($_POST['id'])))
            if (($url = $document->downloadFile($_POST['status'])) != Documents::file_not_exists)
                if ($document->load(Yii::$app->request->post()) && $document->lockForUpdate())
                    echo $url;
                else
                    echo Documents::is_opened_for_update;
            else
                echo $url;
        else
            echo Documents::file_not_in_db;
    }

    /**
     * unlock a locked / open for update file
     */
    public function actionUnlockFile() {
        if (is_object($document = Documents::returnDocument($_POST['Documents']['id'])))
            if ($document->status == $_POST['status'] && StaticMethods::fileExists($document->fileLocation()) != StaticMethods::file_not_found)
                echo $document->documentUpdateCanBeCanceledByUser($user = Yii::$app->user->identity->id, $document->userPreferredDocumentPrivilege($user, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->unlockFile($user) ? true : Documents::is_not_opened_for_update;
            else
                echo Documents::file_not_exists;
        else
            echo Documents::file_not_in_db;
    }

    /**
     * update a file to later version
     */
    public function actionUpdateFile() {
        if (is_object($document = Documents::returnDocument($_POST['Documents']['id'])))
            if ($document->status == $_POST['status'] && StaticMethods::fileExists($previousLocation = $document->fileLocation()) != StaticMethods::file_not_found)
                if ($document->load(Yii::$app->request->post()) && $instance = UploadedFile::getInstance($document, 'filename'))
                    echo $document->updateFile($instance, empty($_POST['folder']) ? '' : $_POST['folder']) ? true : Documents::is_not_opened_for_update;
                else
                    echo Documents::file_upload_not_reach_server;
            else
                echo Documents::file_not_exists;
        else
            echo Documents::file_not_in_db;
    }

    /**
     * @return mixed load document versions onto the view
     */
    public function actionDocumentVersions() {
        return $this->renderPartial('document-versions', ['versions' => is_object($document = Documents::returnDocument($_POST['id'])) ? $document->documentVersions(false) : [], 'filename' => empty($document->filename) ? '' : $document->filename]);
    }

    /**
     * download a document version from document history versions
     */
    public function actionDownloadDocumentVersion() {
        echo is_object($version = Logs::returnLog($_POST['id'])) ? $version->downloadDocumentVersion($_POST['status']) : '';
    }

    /**
     * drop document versions till a given time
     */
    public function actionDropDocumentVersions() {
        Logs::dropDocumentVersions($_POST['id'], $_POST['till']);
        return $this->actionDocumentVersions();
    }

    /**
     * revert to document version from history
     */
    public function actionRevertFromHistory() {
        is_object($document = Documents::returnDocument($_POST['id'])) ? $document->revertFromHistory($_POST['version'], $_POST['status']) : '';
        return $this->actionDocumentVersions();
    }

    /**
     * copy or move a document
     */
    public function actionCopyOrMoveFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? (
                $_POST['copy_or_move'] === Documents::file_copy ?
                        ($document->documentCanBeCopiedByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveCopy(Documents::returnDocument($_POST['to']), $_POST['status'])) :
                        ($document->documentCanBeMovedByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveMove(Documents::returnDocument($_POST['to']), $_POST['status']))
                ) : (Documents::file_not_in_db);
    }

    /**
     * download files in zipped folder
     */
    public function actionZipAndExport() {
        $zip = Documents::zipAndExport($_POST['ids'], $_POST['status'], Documents::zip_link_url);
        echo $zip[0];
        empty($zip[0]) ? '' : Logs::newLog(Logs::zip_and_export, "Zipped and downloaded documents from " . Documents::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, null, null, null, $zip[1], str_replace(StaticMethods::downloadsFolderUrl(), StaticMethods::downloads_folder . '/', $zip[0]), Logs::success);
    }

    /**
     * 
     * @return mixed interface for sending documents
     */
    public function actionDocumentMailingModal() {
        return $this->renderAjax('send-document-modal', [
                    'mailing_contacts' => $this->actionMailingContacts(),
                    'mailing_contact_form' => $this->actionMailingContact(),
                    'document_mailing_form' => $this->actionSendFiles()
                        ]
        );
    }

    /**
     * load mailing contacts on to view
     */
    public function actionMailingContacts() {
        return $this->renderPartial('mailing-contacts', ['contacts' => DocumentsMailingsContacts::allContacts()]);
    }

    /**
     * capture mailing contact detail
     */
    public function actionMailingContact() {
        $model = DocumentsMailingsContacts::contactToLoad(empty($_POST['DocumentsMailingsContacts']['id']) ? '' : $_POST['DocumentsMailingsContacts']['id'], empty($_POST['DocumentsMailingsContacts']['email']) ? '' : $_POST['DocumentsMailingsContacts']['email'], empty($_POST['DocumentsMailingsContacts']['names']) ? '' : $_POST['DocumentsMailingsContacts']['names']);

        $model->load(Yii::$app->request->post()) && $model->modelSave();

        return $this->renderAjax('mailing-contact-form', ['model' => $model]);
    }

    /**
     * delete mail contact
     */
    public function actionDeleteContact() {
        echo is_object($model = DocumentsMailingsContacts::returnContact($_POST['id'])) && $model->modelDelete();
    }

    /**
     * send files in zipped folder
     */
    public function actionSendFiles() {
        $model = DocumentsMailings::mailToLoad($id = empty($_POST['DocumentsMailings']['id']) ? '' : $_POST['DocumentsMailings']['id'], null, null, null, empty($_POST['ids']) ? '' : Documents::documentsForSending($_POST['ids'], $_POST['status']));

        if ($model->load(Yii::$app->request->post())) {

            if (!isset($_POST['sbmt']) && count($ajax = $this->ajaxValidate($model)) > 0)
                return $ajax;

            if (($sent = ($valid = $model->validate(['from', 'to', 'cc', 'bcc', 'documents', 'subject', 'body', 'footer'])) && ($done = $model->sendFiles($_POST['status'])) == DocumentsMailings::connection_failed)) {
                echo $id == $model->id ? '' : $model->id;
                Yii::$app->end();
            } else
            if ($valid) {
                echo $done;
                $model = DocumentsMailings::mailToLoad(null, null, null, null, empty($_POST['ids']) ? '' : Documents::documentsForSending($_POST['ids'], $_POST['status']));
                $model->load(Yii::$app->request->post());
            }
        }

        return $this->renderAjax('send-document-form', ['model' => $model, 'sent' => !empty($sent)]);
    }

    /**
     * push documents to services
     */
    public function actionPushSchemesOfWork() {
        echo Documents::returnDocument($_POST['SchemesOfWork']['submitted_as'])->sendDocumentAsSchemeOfWork($_POST);
    }

    /**
     * drop zip file from downloads folder
     */
    public function actionDropExportedFile() {
        echo StaticMethods::dropExportedFile($_POST['link']);
    }

    /**
     * set document as updatable, movable, deletable
     */
    public function actionFileUpdatability() {
        echo is_object($document = Documents::returnDocument($_POST['id'])) ? $document->fileUpdatability($_POST['status'], $_POST['attribute'], $_POST['value']) : false;
    }

    /**
     * change view name of document
     */
    public function actionChangeNameOfFile() {
        echo is_object($document = Documents::returnDocument($_POST['id'])) ? $document->changeNameOfFile($_POST['status'], $_POST['name']) : false;
    }

    /**
     * duplicate a document
     */
    public function actionDuplicateFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? $document->fileRecursiveCopy(Documents::returnDocument($document->directory), $_POST['status']) : Documents::file_not_in_db;
    }

    /**
     * archive a document
     */
    public function actionArchiveFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? ($document->documentCanBeArchivedByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveArchive()) : Documents::file_not_in_db;
    }

    /**
     * restore document from archive
     */
    public function actionRestoreArchivedFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? ($document->documentCanBeRestoredFromArchiveByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveRestoreFromArchive()) : Documents::file_not_in_db;
    }

    /**
     * recycle a document
     */
    public function actionRecycleFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? ($document->documentCanBeRecycledByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveRecycle()) : Documents::file_not_in_db;
    }

    /**
     * restore document from recycle
     */
    public function actionRestoreRecycledFile() {
        echo is_object($document = Documents::returnDocument($_POST['from'])) ? ($document->documentCanBeRestoredFromRecycleByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveRestoreFromRecycle($_POST['new_status'])) : Documents::file_not_in_db;
    }

    /**
     * drop document from recycle
     */
    public function actionDropFile() {
        echo is_object($document = Documents::returnDocument($_POST['id'])) ? ($document->documentCanBeDroppedByUser($document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $document->fileRecursiveDrop()) : Documents::file_not_in_db;
    }

    /**
     * 
     * @return mixed view for setting document access rules
     */
    public function actionPrivilegesModal() {
        return $this->renderAjax('privileges-modal', [
                    'directories' => $this->actionLoadContentFolder($documents = Documents::directoryListModels($_POST['filename'], $_POST['status'], $_POST['level'])),
                    'sections' => $this->actionAllSections($sections = Sections::allSections(null), $document = empty($documents[0]) || ((!empty($_POST['Documents']['id']) && $documents[0]->id != $_POST['Documents']['id']) || (empty($documents[0]) && empty($_POST['Documents']['id'])) ) ? Documents::documentToLoad(empty($_POST['Documents']['id']) ? '' : $_POST['Documents']['id'], null, null, $_POST['filename'], $_POST['level'], null, $_POST['status'], true) : $documents[0]),
                    'section' => $this->actionDetails(empty($sections[0]) ? '' : $sections[0]),
                    'users' => $this->actionUsers(empty($sections[0]) ? Sections::sectionToLoad(empty($_POST['Sections']['id']) ? '' : $_POST['Sections']['id'], '') : $sections[0]),
                    'desc' => $document->description
                        ]
        );
    }

    /**
     * 
     * @param string|Documents $documents selected document model
     * @param integer|Sections $section selected section model
     * @return mixed load selected folders onto a view
     */
    public function actionLoadContentFolder($documents) {
        return $this->renderPartial('dir-dirs', [
                    'documents' => is_array($documents) ? $documents : $documents = Documents::directoryListModels($_POST['filename'], $_POST['status'], $_POST['level']),
                    'selected' => empty($_POST['Documents']['id']) ? (empty($documents[0]) ? ('') : ($documents[0]->id)) : ($_POST['Documents']['id']),
                        ]
        );
    }

    /**
     * 
     * @param string|Sections $sections selected section model
     * @param integer|Documents $document selected document model
     * @return mixed display all sections as may be desired
     */
    public function actionAllSections($sections, $document) {
        return $this->renderPartial('all-sections', [
                    'sections' => $sections = is_array($sections) ? $sections : Sections::allSections(isset($_POST['Sections']['active']) ? $_POST['Sections']['active'] : ''),
                    'selected' => empty($_POST['Sections']['id']) ? (empty($sections[0]) ? '' : $sections[0]->id) : ($_POST['Sections']['id']),
                    'document' => is_object($document) ? $document : Documents::documentToLoad(empty($_POST['Documents']['id']) ? '' : $_POST['Documents']['id'], null, null, empty($_POST['filename']) ? '' : $_POST['filename'], empty($_POST['level']) ? '' : $_POST['level'], null, empty($_POST['status']) ? '' : $_POST['status'], true),
                    'user' => Yii::$app->user->identity->id
                        ]
        );
    }

    /**
     * 
     * @param integer|Sections $section section id or model
     * @return mixed display active users
     */
    public function actionUsers($section) {
        return $this->renderPartial('all-users', [
                    'users' => \common\models\User::activeUsers(),
                    'section' => is_object($section) ? $section : Sections::sectionToLoad(empty($section) ? (empty($_POST['Sections']['id']) ? '' : $_POST['Sections']['id']) : ($section), '')
                        ]
        );
    }

    /**
     * 
     * @param string|Sections $section selected section model
     * @return mixed view for updating section
     */
    public function actionDetails($section) {
        $model = is_object($section) ? $section : Sections::sectionToLoad(empty($_POST['Sections']['id']) ? '' : $_POST['Sections']['id'], empty($_POST['Sections']['name']) ? '' : $_POST['Sections']['name']);

        if (isset($_POST['Sections']['name']) && $model->load(Yii::$app->request->post())) {
            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $model->modelSave($model->isNewRecord ? Logs::create_group : Logs::update_group, null);
        }

        return $this->renderAjax('section-form', ['model' => $model]);
    }

    /**
     * activate or expire section
     */
    public function actionExpireSection() {
        if (is_object($model = Sections::returnSection($_POST['Sections']['id']))) {

            $model->load(Yii::$app->request->post());

            $model->modelSave(Logs::activate_group, null);

            echo $model->active == Sections::section_active;
        } else
            echo false;
    }

    /**
     * drop section conditionally
     */
    public function actionDropSection() {
        if (is_object($model = Sections::returnSection($_POST['Sections']['id']))) {

            $model->load(Yii::$app->request->post());

            echo $model->sectionDrop();
        } else
            echo true;
    }

    /**
     * assign user a right in the section
     */
    public function actionUserSectionRight() {
        if (is_object($model = Sections::returnSection($_POST['Sections']['id']))) {
            $model->manageUserPrivileges($user = $_POST['user'], $_POST['right']);
            echo $model->userSectionClientClass($user);
        } else
            echo Sections::remove_user;
    }

    /**
     * assign section a privilege to document
     */
    public function actionSectionDocumentRight() {
        $model = DocumentsPermissions::permissionToLoad($_POST['DocumentsPermissions']['document'], $_POST['DocumentsPermissions']['section']);

        $model->load(Yii::$app->request->post());

        $model->syncRights();

        $model->modelSave();

        echo $model->permission;

        $model->documentChildrenRights();
    }

    /**
     * 
     * @return string updated document description
     */
    public function actionUpdateDocDescription() {
        $model = Documents::returnDocument($id = $_POST['Documents']['id']);

        $previousDesc = $model->description;

        if (isset($_POST['Documents']['description']) && $model->load(Yii::$app->request->post())) {
            if (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0) {
                is_array($ajax) ? ('') : ($model->save(['description']) &&
                                (Logs::newLog(Logs::update_document_description, "Updated description for document $model->name in " . Documents::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, empty($id) ? '' : $id, $previousDesc, $model->id, $model->description, null, Logs::success) || true));
                return is_array($ajax) ? $ajax : [];
            }

            Yii::$app->end();
        }

        return $this->renderAjax('doc-description', ['model' => $model, 'user' => Yii::$app->user->identity->id]);
    }

    /**
     * load document description on to view
     */
    public function actionDocDescription() {
        echo is_object($document = Documents::returnDocument($_POST['Documents']['id'])) ? $document->description : '';
    }

    /**
     * 
     * @return mixed load documents opened for update by current user
     */
    public function actionOpenedForUpdate() {
        return $this->openedForUpdate(Yii::$app->user->identity->id);
    }

    /**
     * 
     * @return mixed load slide images on to view for updating
     */
    public function actionSlideImages() {
        return $this->renderPartial('slide-images', [
                    'slide_images_panes' => $this->actionSlideImagesPanes(),
                    'image_form' => $this->actionUpdateSlideImage()
                        ]
        );
    }

    /**
     * 
     * @return mixed load selected images on to view
     */
    public function actionSlideImagesPanes() {
        return $this->renderPartial('slide-images-panes', [
                    'images' => empty($_REQUEST['actv']) ? SlideImages::allActiveImages() : SlideImages::allInactiveImages(),
                    'inactive' => empty($_REQUEST['actv'])
                        ]
        );
    }

    /**
     * 
     * @return mixed render view for uploading slide images
     */
    public function actionUpdateSlideImage() {
        $model = SlideImages::imageToLoad(empty($_POST['SlideImages']['id']) ? '' : $_POST['SlideImages']['id']);

        if (isset($_POST['SlideImages']['name']) && $model->load(Yii::$app->request->post())) {

            $model->saveUploadedFile($instance = UploadedFile::getInstance($model, 'location'), false);

            if (!isset($_POST['sbmt']) && (($ajax = $this->ajaxValidate($model)) === self::IS_AJAX || count($ajax) > 0))
                return is_array($ajax) ? $ajax : [];

            $model->saveUploadedFile($instance, true);

            !$model->hasErrors('location') && $model->modelSave();

            $model->hasErrors() ? $model->modelDelete() : '';
        }

        return $this->renderAjax('slide-images-form', ['model' => $model]);
    }

    /**
     * mark image as active or not active
     */
    public function actionActiveSlideImage() {
        echo!is_object($model = SlideImages::returnImage($_POST['SlideImages']['id'])) ? (SlideImages::not_active) : ($model->load(Yii::$app->request->post()) && $model->modelSave() ? $model->active : $model->active);
    }

    /**
     * delete slide image
     */
    public function actionDeleteSlideImage() {
        echo!is_object($model = SlideImages::returnImage($_POST['SlideImages']['id'])) || $model->modelDelete();
    }

    /**
     * 
     * @return mixed documents current user has a admin rights to
     */
    public function actionDocumentsUserHasRightTo() {
        return $this->documentsUserHasRightTo(Yii::$app->user->identity->id, Documents::file_alter);
    }

    /**
     * 
     * @return mixed load sought documents on to view
     */
    public function actionSearchDocuments() {
        return $this->renderPartial('search-documents', ['documents' => Documents::searchDocuments($_POST['name'], Yii::$app->user->identity->id, $_POST['id'])]);
    }

    public function actionGraphs() {
        return $this->renderAjax('graphs');
    }

}
