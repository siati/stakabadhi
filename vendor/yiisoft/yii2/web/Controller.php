<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\web;

use Yii;
use yii\base\InlineAction;
use yii\helpers\Url;
use common\models\User;
use common\models\Documents;
use common\models\StaticMethods;
use common\models\Profiles;

/**
 * Controller is the base class of web controllers.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Controller extends \yii\base\Controller {

    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[\yii\web\Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = true;

    /**
     * @var array the parameters bound to the current action.
     */
    public $actionParams = [];

    /**
     * Renders a view in response to an AJAX request.
     *
     * This method is similar to [[renderPartial()]] except that it will inject into
     * the rendering result with JS/CSS scripts and files which are registered with the view.
     * For this reason, you should use this method instead of [[renderPartial()]] to render
     * a view to respond to an AJAX request.
     *
     * @param string $view the view name. Please refer to [[render()]] on how to specify a view name.
     * @param array $params the parameters (name-value pairs) that should be made available in the view.
     * @return string the rendering result.
     */
    public function renderAjax($view, $params = []) {
        return $this->getView()->renderAjax($view, $params, $this);
    }

    /**
     * Binds the parameters to the action.
     * This method is invoked by [[\yii\base\Action]] when it begins to run with the given parameters.
     * This method will check the parameter names that the action requires and return
     * the provided parameters according to the requirement. If there is any missing parameter,
     * an exception will be thrown.
     * @param \yii\base\Action $action the action to be bound with parameters
     * @param array $params the parameters to be bound to the action
     * @return array the valid parameters that the action can run with.
     * @throws BadRequestHttpException if there are missing or invalid parameters.
     */
    public function bindActionParams($action, $params) {
        if ($action instanceof InlineAction) {
            $method = new \ReflectionMethod($this, $action->actionMethod);
        } else {
            $method = new \ReflectionMethod($action, 'run');
        }

        $args = [];
        $missing = [];
        $actionParams = [];
        foreach ($method->getParameters() as $param) {
            $name = $param->getName();
            if (array_key_exists($name, $params)) {
                if ($param->isArray()) {
                    $args[] = $actionParams[$name] = (array) $params[$name];
                } elseif (!is_array($params[$name])) {
                    $args[] = $actionParams[$name] = $params[$name];
                } else {
                    throw new BadRequestHttpException(Yii::t('yii', 'Invalid data received for parameter "{param}".', [
                        'param' => $name,
                    ]));
                }
                unset($params[$name]);
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $actionParams[$name] = $param->getDefaultValue();
            } else {
                $missing[] = $name;
            }
        }

        if (!empty($missing)) {
            throw new BadRequestHttpException(Yii::t('yii', 'Missing required parameters: {params}', [
                'params' => implode(', ', $missing),
            ]));
        }

        $this->actionParams = $actionParams;

        return $args;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            if ($this->enableCsrfValidation && Yii::$app->getErrorHandler()->exception === null && !Yii::$app->getRequest()->validateCsrfToken()) {
                throw new BadRequestHttpException(Yii::t('yii', 'Unable to verify your data submission.'));
            }
            return true;
        }

        return false;
    }

    /**
     * Redirects the browser to the specified URL.
     * This method is a shortcut to [[Response::redirect()]].
     *
     * You can use it in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to login page
     * return $this->redirect(['login']);
     * ```
     *
     * @param string|array $url the URL to be redirected to. This can be in one of the following formats:
     *
     * - a string representing a URL (e.g. "http://example.com")
     * - a string representing a URL alias (e.g. "@example.com")
     * - an array in the format of `[$route, ...name-value pairs...]` (e.g. `['site/index', 'ref' => 1]`)
     *   [[Url::to()]] will be used to convert the array into a URL.
     *
     * Any relative URL will be converted into an absolute one by prepending it with the host info
     * of the current request.
     *
     * @param integer $statusCode the HTTP status code. Defaults to 302.
     * See <http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html>
     * for details about HTTP status code
     * @return Response the current response object
     */
    public function redirect($url, $statusCode = 302) {
        return Yii::$app->getResponse()->redirect(Url::to($url), $statusCode);
    }

    /**
     * Redirects the browser to the home page.
     *
     * You can use this method in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to home page
     * return $this->goHome();
     * ```
     *
     * @return Response the current response object
     */
    public function goHome() {
        return Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
    }

    /**
     * Redirects the browser to the last visited page.
     *
     * You can use this method in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to last visited page
     * return $this->goBack();
     * ```
     *
     * For this function to work you have to [[User::setReturnUrl()|set the return URL]] in appropriate places before.
     *
     * @param string|array $defaultUrl the default return URL in case it was not set previously.
     * If this is null and the return URL was not set previously, [[Application::homeUrl]] will be redirected to.
     * Please refer to [[User::setReturnUrl()]] on accepted format of the URL.
     * @return Response the current response object
     * @see User::getReturnUrl()
     */
    public function goBack($defaultUrl = null) {
        return Yii::$app->getResponse()->redirect(Yii::$app->getUser()->getReturnUrl($defaultUrl));
    }

    /**
     * Refreshes the current page.
     * This method is a shortcut to [[Response::refresh()]].
     *
     * You can use it in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and refresh the current page
     * return $this->refresh();
     * ```
     *
     * @param string $anchor the anchor that should be appended to the redirection URL.
     * Defaults to empty. Make sure the anchor starts with '#' if you want to specify it.
     * @return Response the response object itself
     */
    public function refresh($anchor = '') {
        return Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->getUrl() . $anchor);
    }

    /**
     * 
     * @param array $folders folders
     * @param integer $level parent folder under the folders are
     * @param string $navigation
     * @return type
     */
    public function recursiveNavigationPaneFolderPopulator($folders, $level, $status, $node, $selected, $navigation) {
        $level++;

        $subNode = 0;

        foreach ($folders as $name => $folder) {
            $status = Documents::subDirFileStatus($level, $name, $status);

            if ($document = Documents::fileLocationIsViewable($level, $name, $status)) {

                $is_admin = ($profile = Profiles::returnProfile(Yii::$app->user->identity->profile)->profile) == User::USER_SUPER_ADMIN || $profile == User::USER_ADMIN;

                $right = is_object($document) ? $document->desiredUserPrivilegeToDocument(Yii::$app->user->identity->id, null, false, true, false, Documents::file_deny, false) : 'adm';

                if ($is_admin || in_array($right, [Documents::file_read, Documents::file_write, Documents::file_alter, 'adm'])) {

                    $navigation .= $this->navigationPaneItem(
                            $level
                            , ($newTree = $level == Documents::min_sub_root_document_level) ? '' : $node
                            , $nextNode = ($newTree ? ++$node : $node) . ($newTree ? $subNode = null : ++$subNode) . '-'
                            , empty($document->id) ? '' : $document->id
                            , $open = StaticMethods::fileIsInDirectory($selected, $name)
                            , "$name\\" == $selected || $name == $selected
                            , Documents::FILE_IS_DIRECTORY
                            , $status
                            , Documents::fileShortFileName($level, $name)
                            , Documents::fileNameToDisplay($name, empty($document->name) ? '' : $document->name)
                            , Documents::hasCustomMenu($level)
                            , Documents::folderCanReceiveFilesFromClient($level, $status)
                            , Documents::folderCanBeAddedFolder($name)
                            , $right
                    );

                    if ($open && is_array($folder))
                        $navigation .= $this->recursiveNavigationPaneFolderPopulator($folder, $level, $status, $nextNode, $selected, null);
                }
            }
        }

        return $navigation;
    }

    public function navigationPaneItem($level, $parNode, $node, $id, $open, $terminal, $dir_or_file, $status, $folder, $folder_name, $customMenu, $dropable, $addFolder, $right) {
        return
                $this->renderPartial('../default/navigation-folder'
                        , [
                    'level' => $level,
                    'parNode' => $parNode,
                    'node' => $node,
                    'id' => $id,
                    'open' => $open,
                    'terminal' => $terminal,
                    'dir_or_file' => $dir_or_file,
                    'status' => $status,
                    'folder' => $folder,
                    'folder_name' => ucwords(strtolower($folder_name)),
                    'customMenu' => $customMenu,
                    'dropable' => $dropable,
                    'addFolder' => $addFolder,
                    'right' => $right
                        ]
        );
    }

    public function directoryNavigationTree($level, $status, $selected) {
        return $this->navigationPaneItem(
                        $level
                        , null
                        , null
                        , null
                        , true
                        , false
                        , Documents::FILE_IS_DIRECTORY
                        , null
                        , Documents::fileShortFileName($level, StaticMethods::rootFolderHardCode())
                        , Yii::$app->params['clientName']
                        , Documents::hasCustomMenu($level)
                        , false
                        , false
                        , Documents::file_read
                ) .
                $this->recursiveNavigationPaneFolderPopulator(Documents::rootFileDirectories($selected), $level, $status, null, $selected, null);
    }

    /**
     * 
     * @param string $location document location
     * @param integer $status document status
     * @param integer $level document level
     * @return mixed properties view of document
     */
    public function documentProperties($location, $status, $level) {

        if (is_object($document = Documents::fileLocationIsViewable($level, $location, $status))) {
            $authorModel = User::returnUser($document->created_by);
            $author = empty($authorModel->name) ? 'Unknown' : $authorModel->name;
            $uploadedOn = StaticMethods::dateString($document->created_at, StaticMethods::longest);

            $updaterModel = User::returnUser($document->updated_by);
            $updatedBy = empty($updaterModel->name) ? 'Unknown' : $updaterModel->name;
            $updatedOn = empty($document->updated_at) ? '' : StaticMethods::dateString($document->updated_at, StaticMethods::longest);

            $lockerModel = User::returnUser($document->opened_for_update_by);
            $lockedBy = empty($lockerModel->name) ? 'Unknown' : $lockerModel->name;
            $lockedOn = empty($document->opened_for_update_at) ? '' : StaticMethods::dateString($document->opened_for_update_at, StaticMethods::longest);

            $is_admin = ($profile = Profiles::returnProfile(Yii::$app->user->identity->profile)->profile) == User::USER_SUPER_ADMIN || $profile == User::USER_ADMIN;

            $right = $document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny);
            $description = StaticMethods::fileTypeDescription($document->fileExtesion());

            if (!empty($document->archived_in)) {
                $archived = true;
                $archiverModel = User::returnUser($document->archived_by);
                $archivedBy = empty($archiverModel->name) ? 'Unknown' : $archiverModel->name;
                $archivedOn = empty($document->archived_at) ? '' : StaticMethods::dateString($document->archived_at, StaticMethods::longest);
            }

            if (!empty($document->deleted_to)) {
                $deleted = true;
                $deleterModel = User::returnUser($document->deleted_by);
                $deletedBy = empty($deleterModel->name) ? 'Unknown' : $deleterModel->name;
                $deletedOn = empty($document->deleted_at) ? '' : StaticMethods::dateString($document->deleted_at, StaticMethods::longest);
            }

            if (!empty($document->restored_by) && !empty($document->restored_at)) {
                $restored = true;
                $restorerModel = User::returnUser($document->restored_by);
                $restoredBy = empty($restorerModel->name) ? 'Unknown' : $restorerModel->name;
                $restoredOn = empty($document->restored_at) ? '' : StaticMethods::dateString($document->restored_at, StaticMethods::longest);
            }
        }

        $is_dir = is_dir($location);

        return $this->renderPartial('../sections/document-properties-properties', [
                    'id' => empty($document->id) ? '' : $document->id,
                    'filename' => ucwords(Documents::fileNameToDisplay($location, empty($document->name) ? '' : $document->name)),
                    'location' => $level <= Documents::min_client_document_level ? (Yii::$app->params['clientName']) : (is_object($document) ? $document->fileLocationToClient($status) : Documents::fileLocationToClientByLocation($status, $location)),
                    'fileItems' => $is_dir ? count(Documents::directoryContentList($location, StaticMethods::dir_unrecursive, StaticMethods::files_and_folders, null)) : false,
                    'fileSize' => is_array($size = StaticMethods::fileSizeConverter(Documents::fileSize($location))) ? "$size[0] $size[1]" : $size,
                    'description' => empty($description[$nm = StaticMethods::ext_name]) ? '' : $description[$nm],
                    'versions' => is_object($document) && $document->status > Documents::FILE_STATUS_DELETED && is_file($location) && $document->hasVersions() && ($is_admin || $right == Documents::file_alter),
                    'status' => empty($document->status) ? '' : $document->status,
                    'updateMoveDrop' => $updateMoveDrop = is_object($document) && !empty($document->id) && $document->status == $status && $document->status == Documents::FILE_STATUS_AVAILABLE && ($is_admin || $right == Documents::file_alter),
                    'update' => $updateMoveDrop && !empty($document->can_be_updated),
                    'move' => $updateMoveDrop && !empty($document->can_be_moved),
                    'drop' => $updateMoveDrop && !empty($document->can_be_deleted),
                    'author' => isset($author) ? $author : '',
                    'uploadedOn' => isset($uploadedOn) ? $uploadedOn : '',
                    'updatedBy' => isset($updatedBy) ? $updatedBy : '',
                    'updatedOn' => isset($updatedOn) ? $updatedOn : '',
                    'lockedBy' => isset($lockedBy) ? $lockedBy : '',
                    'lockedOn' => isset($lockedOn) ? $lockedOn : '',
                    'archived' => isset($archived) ? $archived : '',
                    'archivedBy' => isset($archivedBy) ? $archivedBy : '',
                    'archivedOn' => isset($archivedOn) ? $archivedOn : '',
                    'deleted' => isset($deleted) ? $deleted : '',
                    'deletedBy' => isset($deletedBy) ? $deletedBy : '',
                    'deletedOn' => isset($deletedOn) ? $deletedOn : '',
                    'restored' => isset($restored) ? $restored : '',
                    'restoredBy' => isset($restoredBy) ? $restoredBy : '',
                    'restoredOn' => isset($restoredOn) ? $restoredOn : ''
                        ]
        );
    }

    /**
     * 
     * @param integer $user user id
     * @param string $right read, write, alter
     * @return mixed documents `$user` has a `$right` to
     */
    public function documentsUserHasRightTo($user, $right) {
        return $this->renderPartial('../sections/document-properties-privileges-write', ['writeDocuments' => Documents::documentsToWhichUserHasPrivilege($user, $right)]);
    }

    /**
     * 
     * @param integer $user user id
     * @return mixed documents opened for update by user
     */
    public function openedForUpdate($user) {
        return $this->renderPartial('../sections/document-properties-privileges-for-update', ['updateDocuments' => Documents::openedByUserForUpdate($user)]);
    }

    /**
     * 
     * @return array slide items
     */
    public function slideImages() {
        $items = [];

        foreach (\common\models\SlideImages::allActiveImages() as $image)
            array_push($items, [
                'content' => $this->renderPartial('../../../../modules/institution/views/sections/document-properties-branding-content', ['url' => $image->imageLocationUrl(), 'link' => $image->url_to, 'name' => $image->name]),
                'caption' => (!empty($image->name) && $image->name_visible == \common\models\SlideImages::name_visible ? "<p><b>$image->name</b></p>" : '') . (!empty($image->caption) && $image->caption_visible == \common\models\SlideImages::caption_visible ? "<p><small>$image->caption</small></p>" : '')
                    ]
            );
        
        return $items;
    }

}
