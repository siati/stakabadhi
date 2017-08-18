<?php

namespace common\models;

use Yii;
use common\models\DocumentsPermissions;
use common\models\Sections;

/**
 * This is the model class for table "{{%documents}}".
 *
 * @property integer $id
 * @property integer $directory
 * @property string $name
 * @property string $filename
 * @property integer $file_level
 * @property string $dir_or_file
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property string $status
 * @property integer $status_by
 * @property string $status_at
 * @property string $permissions
 * @property integer $forwarded_for_update_by
 * @property string $opened_for_update
 * @property integer $opened_for_update_by
 * @property string $opened_for_update_at
 * @property string $visible_to_others_during_update
 * @property integer $can_be_updated
 * @property integer $can_be_moved
 * @property integer $can_be_deleted
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $archived_in
 * @property integer $archived_by
 * @property string $archived_at
 * @property string $deleted_to
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property integer $restored_by
 * @property string $restored_at
 */
class Documents extends \yii\db\ActiveRecord {

    const firm_root_folder = StaticMethods::firm_root_folder;
    const regular_folder = StaticMethods::regular_folder;
    const archive_folder = StaticMethods::archive_folder;
    const recycle_folder = StaticMethods::recycle_folder;
    const regular_name = StaticMethods::regular_name;
    const archive_name = StaticMethods::archive_name;
    const recycle_name = StaticMethods::recycle_name;
    // document properties
    const NO_PARENT_FOLDER = null;
    const FILE_IS_DIRECTORY = 0;
    const FILE_IS_DOCUMENT = 1;
    const FILE_STATUS_ARCHIVED = 0;
    const FILE_STATUS_AVAILABLE = 1;
    const FILE_STATUS_DELETED = -1;
    const FILE_NOT_OPENED_FOR_UPDATE = 0;
    const FILE_OPENED_FOR_UPDATE = 1;
    const FILE_NOT_VISIBLE_DURING_UPDATE = 0;
    const FILE_VISIBLE_DURING_UPDATE = 1;
    const FILE_CAN_NOT_BE_UPDATED = 0;
    const FILE_CAN_BE_UPDATED = 1;
    const FILE_CAN_NOT_BE_MOVED = 0;
    const FILE_CAN_BE_MOVED = 1;
    const FILE_CAN_NOT_BE_DELETED = 0;
    const FILE_CAN_BE_DELETED = 1;
    //document actions
    const open = 'open';
    const open_for_update = 'open for update';
    const update = 'update';
    const copy = 'copy';
    const duplicate = 'duplicate';
    const paste = 'paste';
    const rename = 'rename';
    const move = 'move';
    const archive = 'archive';
    const delete = 'delete';
    const restore = 'restore';
    const drop = 'drop';
    const upload = 'upload';
    const download = 'download';
    const share = 'share with';
    const share_for_update = 'share for update with';
    const send = 'send to';
    const properties = 'properties';
    //document action categories
    const file_deny = DocumentsPermissions::file_deny;
    const file_read = DocumentsPermissions::file_read;
    const file_write = DocumentsPermissions::file_write;
    const file_alter = DocumentsPermissions::file_alter;
    //min document level
    const min_root_document_level = StaticMethods::min_root_document_level;
    const min_sub_root_document_level = StaticMethods::min_sub_root_document_level;
    const min_client_document_level = StaticMethods::min_client_document_level;
    //file existence
    const file_in_db = 'in_db';
    const file_not_in_db = 'not_in_db';
    const file_destination_not_in_db = 'dest_not_in_db';
    const file_exists = 'exists';
    const file_not_exists = 'not_exists';
    const file_destination_not_exists = 'dest_not_exists';
    //opened for update
    const is_opened_for_update = 'is opened for update';
    const is_not_opened_for_update = 'is not opened for update';
    const file_upload_not_reach_server = StaticMethods::file_upload_not_reach_server;
    const file_copy = 'cp';
    const file_move = 'mv';
    //more constants
    const action_not_allowed = 'action not allowed';
    //section statuses
    const section_active = Sections::section_active;
    const section_not_active = Sections::section_not_active;
    const make_admin = Sections::make_admin;
    const make_sub_admin = Sections::make_sub_admin;
    const make_other_user = Sections::make_other_user;
    const add_user = Sections::add_user;
    const remove_user = Sections::remove_user;
    //returnzip link or location
    const zip_location = 'zipFldr';
    const zip_link_url = 'zipLink';

    public $max_level;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%documents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['directory', 'file_level', 'dir_or_file', 'created_by', 'status_by', 'forwarded_for_update_by', 'opened_for_update_by', 'visible_to_others_during_update', 'can_be_updated', 'can_be_moved', 'can_be_deleted', 'updated_by', 'archived_by', 'deleted_by', 'restored_by'], 'integer'],
            [['name', 'filename', 'file_level'], 'required'],
            [['filename'], 'file', 'extensions' => StaticMethods::implodeAcceptableFileTypes(), 'checkExtensionByMimeType' => false, 'maxSize' => 1024 * 1024 * 1024 * 1024 * 1024],
            [['description', 'status', 'permissions', 'opened_for_update', 'archived_in', 'deleted_to'], 'string'],
            [['created_at', 'status_at', 'opened_for_update_at', 'updated_at', 'archived_at', 'deleted_at', 'restored_at'], 'safe'],
            [['name'], 'string', 'min' => 2, 'max' => 40],
            ['name', 'nameUnique'],
            [['archived_in', 'deleted_to'], 'string', 'max' => 255],
            [['name', 'description'], 'notNumerical'],
            [['description'], 'string', 'min' => 10, 'max' => 1000],
            [['description'], 'paragraphCase']
        ];
    }

    /**
     * name of file cannot be repeated in a folder
     */
    public function nameUnique() {
        if (is_object(static::duplicateName($this->directory, $this->name, $this->id)))
            $this->name = $this->name . ' ' . StaticMethods::stripNonNumeric(StaticMethods::now());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'directory' => Yii::t('app', 'Parent Folder'),
            'name' => Yii::t('app', 'Document Name'),
            'filename' => Yii::t('app', 'Document Location'),
            'file_level' => Yii::t('app', 'Document Level'),
            'dir_or_file' => Yii::t('app', 'Directory Of File'),
            'description' => Yii::t('app', 'Document Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'status' => Yii::t('app', 'Document Status'),
            'status_by' => Yii::t('app', 'Status Updated By'),
            'status_at' => Yii::t('app', 'Status Updated At'),
            'permissions' => Yii::t('app', 'Document Permissions'),
            'forwarded_for_update_by' => Yii::t('app', 'Forwarded For Update By'),
            'opened_for_update' => Yii::t('app', 'Opened For Update'),
            'opened_for_update_by' => Yii::t('app', 'Opened For Update By'),
            'opened_for_update_at' => Yii::t('app', 'Opened For Update At'),
            'visible_to_others_during_update' => Yii::t('app', 'Visible To Others During Update'),
            'can_be_updated' => Yii::t('app', 'Can Be Updated'),
            'can_be_moved' => Yii::t('app', 'Can Be Moved'),
            'can_be_deleted' => Yii::t('app', 'Can Be Deleted'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Last Updated At'),
            'archived_in' => Yii::t('app', 'Archived In'),
            'archived_by' => Yii::t('app', 'Archived By'),
            'archived_at' => Yii::t('app', 'Archived At'),
            'deleted_to' => Yii::t('app', 'Deleted To'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'restored_by' => Yii::t('app', 'Restored By'),
            'restored_at' => Yii::t('app', 'Restored At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\DocumentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\DocumentsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk document id
     * @return Documents model
     */
    public static function returnDocument($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $pk document id
     * @param integer $status file status
     * @return Documents model
     */
    public static function byIdAndStatus($pk, $status) {
        return static::find()->byFileNameAndStatus($pk, $status);
    }

    /**
     * 
     * @param string $ids where sub-clause: id in ('$ids')
     * @return Documents models
     */
    public function whereIDs($ids) {
        return static::find()->whereIDs($ids);
    }

    /**
     * 
     * @param string $ids where sub-clause: id in ('$ids')
     * @param integer $status file status
     * @return Documents models
     */
    public static function whereIDsAndStatus($ids, $status) {
        return static::find()->whereIDsAndStatus($ids, $status);
    }

    /**
     * 
     * @param string $filenames where sub-clause: filename like 'filename/%'
     * @param integer $status file status
     * @return Documents models
     */
    public static function whereFileNamesAndStatus($filenames, $status) {
        return static::find()->whereFileNamesAndStatus($filenames, $status);
    }

    /**
     * 
     * @param string $ids where sub-clause: id in ('$ids')
     * @param integer $status file status
     * @return string document ids and names
     */
    public static function documentsForSending($ids, $status) {
        $detail_delimiter = DocumentsMailings::detail_delimiter;

        foreach ($documents = static::whereIDs($ids, $status) as $i => $document)
            if ($document->status == $status) {
                $docs = (empty($docs) ? '' : "$docs,") . ucwords(strtolower($document->name)) . "$detail_delimiter$document->id";
                unset($documents[$i]);
            }

        foreach ($documents as $document)
            $where = (empty($where) ? '' : "$where || ") . "filename like '$document->filename/%'";

        if (!empty($where))
            foreach (static::whereFileNamesAndStatus($where, $status) as $document)
                $docs = (empty($docs) ? '' : "$docs,") . ucwords(strtolower($document->name)) . "$detail_delimiter$document->id";

        return empty($docs) ? '' : $docs;
    }

    /**
     * 
     * @param string $filename file location
     * @param integer $status file status
     * @return Documents model
     */
    public static function byFileNameAndStatus($filename, $status) {
        return static::find()->byFileNameAndStatus($filename, $status);
    }

    /**
     * 
     * @param string $name name of file
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentsByName($name, $not_in) {
        return static::find()->searchDocumentsByName($name, $not_in);
    }

    /**
     * 
     * @param string $desc description of file
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentsByDescription($desc, $not_in) {
        return static::find()->searchDocumentsByDescription($desc, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByAuthor($author, $not_in) {
        return static::find()->searchDocumentsByAuthor($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByUpdater($author, $not_in) {
        return static::find()->searchDocumentsByUpdater($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByStatuser($author, $not_in) {
        return static::find()->searchDocumentsByStatuser($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByLocker($author, $not_in) {
        return static::find()->searchDocumentsByLocker($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByArchiver($author, $not_in) {
        return static::find()->searchDocumentsByArchiver($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByDeleter($author, $not_in) {
        return static::find()->searchDocumentsByDeleter($author, $not_in);
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function searchDocumentsByRestorer($author, $not_in) {
        return static::find()->searchDocumentsByRestorer($author, $not_in);
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByCreationDate($date, $not_in) {
        return static::find()->searchDocumentByCreationDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByUpdateDate($date, $not_in) {
        return static::find()->searchDocumentByUpdateDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByStatusDate($date, $not_in) {
        return static::find()->searchDocumentByStatusDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByLockDate($date, $not_in) {
        return static::find()->searchDocumentByLockDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByArchiveDate($date, $not_in) {
        return static::find()->searchDocumentByArchiveDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByRecycleDate($date, $not_in) {
        return static::find()->searchDocumentByRecycleDate($date, $not_in);
    }

    /**
     * 
     * @param string $date date
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByRestoreDate($date, $not_in) {
        return static::find()->searchDocumentByRestoreDate($date, $not_in);
    }

    /**
     * 
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function searchDocumentByFileContent($not_in) {
        return static::find()->searchDocumentByFileContent($not_in);
    }

    /**
     * 
     * @param integer $directory integer $directory parent folder id
     * @param string $filename file location
     * @return \common\models\Documents model
     */
    public static function childByDirectoryOrFilename($directory, $filename) {
        return static::find()->childByDirectoryOrFilename($directory, $filename);
    }

    /**
     * 
     * @param string $filename file location
     * @param integer $status file status
     * @param string $type file type 0 - directory, 1 - file
     * @return \common\models\Documents models
     */
    public static function childrenToDirectoryByFilenameAndLocation($filename, $status, $type) {
        return static::find()->childrenToDirectoryByFilenameAndLocation($filename, $status, $type);
    }

    /**
     * @param string $filename file location
     * @param integer $status 0 - archived, -1 - recycled
     * @return boolean true - directory contains an archived or recycled child
     */
    public static function directoryContainsAnArchivedOrRecycledChild($filename, $status) {
        return is_object(static::find()->directoryContainsAnArchivedOrRecycledChild($filename, $status));
    }

    /**
     * 
     * @param integer $directory parent folder id
     * @param string $name file name
     * @return Documents model
     */
    public static function byDirectoryAndName($directory, $name) {
        return static::find()->byDirectoryAndName($directory, $name);
    }

    /**
     * 
     * @param string $order order by clause
     * @return Documents models
     */
    public static function allDocuments($order) {
        return static::find()->allDocuments($order);
    }

    /**
     * 
     * @param integer $type 0 - folder, 1 - file
     * @return Documents models
     */
    public static function byDocumentType($type) {
        return static::find()->byDocumentType($type);
    }

    /**
     * 
     * @param integer $directory folder id
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @param boolean $foldersOnly true - folders only
     * @param string $order order by clause
     * @return Documents models
     */
    public static function documentsInDirectory($directory, $status, $foldersOnly, $order) {
        return static::find()->documentsInDirectory($directory, $status, $foldersOnly, $order);
    }

    /**
     * 
     * @param integer $directory parent folder id
     * @param string $name document name
     * @param integer $id document id
     * @return Documents model
     */
    public static function duplicateName($directory, $name, $id) {
        return static::find()->duplicateName($directory, $name, $id);
    }

    /**
     * 
     * @return integer max directory level
     */
    public static function maxFileLevelsForDir() {
        return ($max = static::find()->maxAndMinFileLevelsForDirOrFile(self::FILE_IS_DIRECTORY)) > 0 ? $max : self::min_sub_root_document_level;
    }

    /**
     * 
     * @param integer $directory container / parent folder
     * @param string $name name of file
     * @param string $filename file of name
     * @param integer $file_level file level
     * @param integer $dir_or_file directory, 0 or file, 1
     * @return Documents model
     */
    public static function newDocument($directory, $name, $filename, $file_level, $dir_or_file) {
        $model = new Documents;

        $model->directory = $directory;
        $model->name = $name;
        $model->filename = $filename;
        $model->file_level = $file_level;
        $model->dir_or_file = $dir_or_file;

        $model->status = self::FILE_STATUS_AVAILABLE;
        $model->status_by = $model->created_by = Yii::$app->user->identity->id;
        $model->visible_to_others_during_update = self::FILE_VISIBLE_DURING_UPDATE;
        $model->can_be_updated = self::FILE_CAN_BE_UPDATED;
        $model->can_be_moved = self::FILE_CAN_BE_MOVED;
        $model->can_be_deleted = self::FILE_CAN_BE_DELETED;

        return $model;
    }

    /**
     * 
     * @param integer $id document id
     * @param integer $directory container / parent folder
     * @param string $name name of file
     * @param string $filename file of name
     * @param integer $file_level file level
     * @param integer $dir_or_file directory, 0 or file, 1
     * @param integer $status file status
     * @param boolean $byIdOnly true - search by id only
     * @return Documents model
     */
    public static function documentToLoad($id, $directory, $name, $filename, $file_level, $dir_or_file, $status, $byIdOnly) {
        return is_object($model = static::returnDocument($id)) || (!$byIdOnly && (
                (is_string($filename) && is_object($model = static::byFileNameAndStatus($filename, $status))) ||
                is_object($model = static::byDirectoryAndName($directory, $name)))) ? $model :
                static::newDocument($directory, $name, is_string($filename) ? $filename : '', $file_level, $dir_or_file);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord) {
            $isNew = true;
            $this->status_at = $this->created_at = StaticMethods::now();
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        return $this->save() && (empty($isNew) || $this->dir_or_file == self::FILE_IS_DOCUMENT || DocumentsPermissions::defaultDirectoryRights($this->id, $this->allParentsToDocument())) &&
                ((!empty($isNew) && Logs::newLog(Logs::new_document, 'New ' . ($this->dir_or_file == self::FILE_IS_DIRECTORY ? "folder $this->name created in " : "file $this->name uploaded into ") . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, '0', null, $this->id, $this->filename, null, Logs::success)) || true) &&
                ((!empty($isNew) && $this->updateVersion()) || true);
    }

    /**
     * 
     * @return boolean true - file has version history
     */
    public function hasVersions() {
        return Logs::documentHasAVersion($this->id);
    }

    /**
     * 
     * @return boolean true - file is in version history
     */
    public function isAVersion() {
        return Logs::documentIsInVersionHistory($this->filename);
    }

    /**
     * 
     * @return Documents model
     */
    public function parentDocumentModel() {
        return $this->returnDocument($this->directory);
    }

    /**
     * @param Documents $parents pre-loaded parents
     * @return Documents models - parents / container folders to `$this'
     */
    public function allParentsToDocument(&$parents = []) {

        // at the very first run load the immediate parent into the array
        empty($parents) ? array_push($parents, $this->parentDocumentModel()) : '';

        if (is_object($lastParent = end($parents))) { // parent in db
            array_push($parents, $lastParent->parentDocumentModel()); // add into parents array

            $lastParent->allParentsToDocument($parents); // load next parent recursively
        } else
            array_pop($parents); // drop last parent being trivial (non-object) value

        return $parents;
    }

    /**
     * 
     * @param string $location file location
     * @return Documents models - parents / container folders to `$location'
     */
    public static function allParentsToDocumentByLocation($location) {
        $parents = [];

        foreach ($filenames = explode('/', str_replace('\\', '/', $location)) as $filename)
            if ($filename != end($filenames) && is_object($parent = static::byJustFilename($filename)))
                array_push($parents, $parent);

        return $parents;
    }

    /**
     * 
     * @param string $filename file name
     * @return Documents model
     */
    public static function byJustFilename($filename) {
        return static::find()->byJustFilename($filename);
    }

    /**
     * 
     * @return string document filename without location
     */
    public function justDbFileName() {
        $explode = explode('/', $this->filename);
        return end($explode);
    }

    /**
     * 
     * @return array array of users with express write permissions
     */
    public function thePermissions() {
        return StaticMethods::stringExplode($this->permissions, ',');
    }

    /**
     * 
     * @param integer $section section id
     * @param integer $user user id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @param boolean $broughtParentsRight true - parents right already established
     * @param string $parentsRight parents right
     * @return string user privilege to document
     */
    public function userSectionDocumentPrivilege($section, $user, $considerSectionOnly, $mustBeActive, $broughtParentsRight, $parentsRight) {
        return $this->desiredUserPrivilegeToDocument($user, $section, $considerSectionOnly, $mustBeActive, $broughtParentsRight, $parentsRight, true);
    }

    /**
     * 
     * @param integer $user user id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @param boolean $broughtParentsRight true - parents right already established
     * @param string $parentsRight parents right
     * @return string user privilege to document
     */
    public function userPreferredDocumentPrivilege($user, $considerSectionOnly, $mustBeActive, $broughtParentsRight, $parentsRight) {
        return $this->desiredUserPrivilegeToDocument($user, null, $considerSectionOnly, $mustBeActive, $broughtParentsRight, $parentsRight, true);
    }

    /**
     * 
     * @param integer $user user id
     * @param integer $section section id
     * @param boolean $considerSectionOnly true - consider section only without necessarily analyzing its users
     * @param boolean $mustBeActive true - section must be active
     * @param boolean $broughtParentsRight true - parents right already established
     * @param string $parentsRight parents right
     * @param boolean $maxPrivilege true - max privilege
     * @return string user access privilege to document
     */
    public function desiredUserPrivilegeToDocument($user, $section, $considerSectionOnly, $mustBeActive, $broughtParentsRight, $parentsRight, $maxPrivilege) {
        if ($this->dir_or_file == self::FILE_IS_DOCUMENT)
            return $broughtParentsRight ? $parentsRight : static::returnDocument($this->directory)->desiredUserPrivilegeToDocument($user, $section, $considerSectionOnly, $mustBeActive, false, self::file_deny, $maxPrivilege);

        return DocumentsPermissions::desiredUserPrivilegeToDocument($user, "$this->id", $section, $considerSectionOnly, $mustBeActive, $maxPrivilege);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeOpenedByUser($user, $right, $is_admin) {
        return $is_admin || $right == self::file_alter || (($this->opened_for_update != self::FILE_OPENED_FOR_UPDATE || ($this->opened_for_update_by == $user && $right == self::file_write)) && in_array($right, [self::file_read, self::file_write]));
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeLockedByUser($right, $is_admin) {
        return $this->can_be_updated == self::FILE_CAN_BE_UPDATED && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE && $this->status == self::FILE_STATUS_AVAILABLE && ($is_admin || in_array($right, [self::file_write, self::file_alter]));
    }

    /**
     * 
     * @param integer $user user id
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentUpdateCanBeCanceledByUser($user, $right, $is_admin) {
        return $this->opened_for_update == self::FILE_OPENED_FOR_UPDATE && ($is_admin || $right == self::file_alter || ($this->opened_for_update_by == $user && $right == self::file_write));
    }

    /**
     * 
     * @param integer $user user id
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeUpdatedByUser($user, $right, $is_admin) {
        return $this->can_be_updated == self::FILE_CAN_BE_UPDATED && $this->opened_for_update == self::FILE_OPENED_FOR_UPDATE && $this->status == self::FILE_STATUS_AVAILABLE && ($this->opened_for_update_by == $user || ($is_admin && in_array($right, [self::file_write, self::file_alter])));
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeRevertedByUser($right, $is_admin) {
        return $this->can_be_updated == self::FILE_CAN_BE_UPDATED && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE && ($this->status == self::FILE_STATUS_AVAILABLE || $this->status == self::FILE_STATUS_ARCHIVED) && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentVersionCanBeOperatedByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeZippedByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeCreatedFolderIntoByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeUploadedFilesIntoByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeCopiedByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeMovedByUser($right, $is_admin) {
        return $this->can_be_moved == self::FILE_CAN_BE_MOVED && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeSentByUser($right, $is_admin) {
        return $is_admin || $right == self::file_alter;
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeArchivedByUser($right, $is_admin) {
        return $this->status == self::FILE_STATUS_AVAILABLE && $this->can_be_moved == self::FILE_CAN_BE_MOVED && $this->can_be_deleted == self::FILE_CAN_BE_DELETED && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeRecycledByUser($right, $is_admin) {
        return ($this->status == self::FILE_STATUS_ARCHIVED || static::directoryContainsAnArchivedOrRecycledChild($this->filename, self::FILE_STATUS_ARCHIVED)) && $this->can_be_moved == self::FILE_CAN_BE_MOVED && $this->can_be_deleted == self::FILE_CAN_BE_DELETED && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeDroppedByUser($right, $is_admin) {
        return ($this->status == self::FILE_STATUS_DELETED || static::directoryContainsAnArchivedOrRecycledChild($this->filename, self::FILE_STATUS_DELETED)) && $this->can_be_moved == self::FILE_CAN_BE_MOVED && $this->can_be_deleted == self::FILE_CAN_BE_DELETED && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeRestoredFromRecycleByUser($right, $is_admin) {
        return ($this->status == self::FILE_STATUS_DELETED || static::directoryContainsAnArchivedOrRecycledChild($this->filename, self::FILE_STATUS_DELETED)) && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeRestoredFromArchiveByUser($right, $is_admin) {
        return ($this->status == self::FILE_STATUS_ARCHIVED || static::directoryContainsAnArchivedOrRecycledChild($this->filename, self::FILE_STATUS_ARCHIVED)) && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeMarkedMovableByUser($right, $is_admin) {
        return $this->status == self::FILE_STATUS_AVAILABLE && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeMarkedUpdatableByUser($right, $is_admin) {
        return $this->status == self::FILE_STATUS_AVAILABLE && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $right right
     * @param boolean $is_admin true - user is admin
     * @return boolean true - can be opened
     */
    public function documentCanBeMarkedDeletableByUser($right, $is_admin) {
        return ($this->status == self::FILE_STATUS_AVAILABLE || $this->status == self::FILE_STATUS_ARCHIVED) && ($is_admin || $right == self::file_alter);
    }

    /**
     * 
     * @param string $name name of file
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byName($name, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByName($name, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $desc description of file
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byDescription($desc, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByDescription($desc, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byAuthor($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByAuthor($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byUpdater($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByUpdater($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byStatuser($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByStatuser($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byLocker($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByLocker($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byArchiver($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByArchiver($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byDeleter($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByDeleter($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $author name email or username
     * @param string $not_in ids to skip
     * @return \common\models\Documents ActiveRecords
     */
    public static function byRestorer($author, $not_in) {
        foreach ($documentsByName = static::searchDocumentsByRestorer($author, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byCreationDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByCreationDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byUpdateDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByUpdateDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byStatusDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByStatusDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byLockDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByLockDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byArchiveDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByArchiveDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byRecycleDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByRecycleDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date of file upload
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byRestoreDate($date, $not_in) {
        foreach ($documentsByName = static::searchDocumentByRestoreDate($date, $not_in) as $document)
            $searched = empty($searched) ? $document->id : "$searched, $document->id";

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $string string to search
     * @param string $not_in ids to skip
     * @return Documents models
     */
    public static function byFileContent($string, $not_in) {
        foreach ($documentsByName = static::searchDocumentByFileContent($not_in) as $i => $document) {
            if (!StaticMethods::searchFileContent(StaticMethods::dirRoot() . $document->fileLocation(), $string, false))
                unset($documentsByName[$i]);

            $searched = empty($searched) ? $document->id : "$searched, $document->id";
        }

        return [$documentsByName, empty($searched) ? '' : $searched];
    }

    /**
     * 
     * @param string $date date property of document
     * @return Documents models
     */
    public static function searchDocumentsByGivenDate($date) {
        $createdOn = static::byCreationDate($date, null);
        $documents ['Created on or later'] = $createdOn[0];
        $searched = empty($createdOn[1]) ? (null) : (empty($searched) ? $createdOn[1] : "$searched, $createdOn[1]");

        $updatedOn = static::byUpdateDate($date, $searched);
        $documents ['Updated on or later'] = $updatedOn[0];
        $searched = empty($updatedOn[1]) ? ($searched) : (empty($searched) ? $updatedOn[1] : "$searched, $updatedOn[1]");

        $statusOn = static::byStatusDate($date, $searched);
        $documents ['Status updated on or later'] = $statusOn[0];
        $searched = empty($statusOn[1]) ? ($searched) : (empty($searched) ? $statusOn[1] : "$searched, $statusOn[1]");

        $lockedOn = static::byLockDate($date, $searched);
        $documents ['Locked on or later'] = $lockedOn[0];
        $searched = empty($lockedOn[1]) ? ($searched) : (empty($searched) ? $lockedOn[1] : "$searched, $lockedOn[1]");

        $archivedOn = static::byArchiveDate($date, $searched);
        $documents ['Archived on or later'] = $archivedOn[0];
        $searched = empty($archivedOn[1]) ? ($searched) : (empty($searched) ? $archivedOn[1] : "$searched, $archivedOn[1]");

        $recycledOn = static::byRecycleDate($date, $searched);
        $documents ['Recycled on or later'] = $recycledOn[0];
        $searched = empty($recycledOn[1]) ? ($searched) : (empty($searched) ? $recycledOn[1] : "$searched, $recycledOn[1]");

        $restoredOn = static::byRestoreDate($date, $searched);
        $documents ['Restored on or later'] = $restoredOn[0];
        $searched = empty($restoredOn[1]) ? ($searched) : (empty($searched) ? $restoredOn[1] : "$searched, $restoredOn[1]");

//        $byFileContent = static::byFileContent($date, $searched);
//        $documents ['File Content Search'] = $byFileContent[0];
//        $searched = empty($byFileContent[1]) ? ($searched) : (empty($searched) ? $byFileContent[1] : "$searched, $byFileContent[1]");

        return $documents;
    }

    /**
     * 
     * @param string $value property of document
     * @return Documents models
     */
    public static function searchDocumentsByGivenString($value) {
        $byName = static::byName($value, null);
        $documents ['By Filename'] = $byName[0];
        $searched = empty($byName[1]) ? (null) : (empty($searched) ? $byName[1] : "$searched, $byName[1]");

        $byDescription = static::byDescription($value, $searched);
        $documents ['By Description'] = $byDescription[0];
        $searched = empty($byDescription[1]) ? ($searched) : (empty($searched) ? $byDescription[1] : "$searched, $byDescription[1]");

        $byAuthor = static::byAuthor($value, $searched);
        $documents ['Created / Uploaded By'] = $byAuthor[0];
        $searched = empty($byAuthor[1]) ? ($searched) : (empty($searched) ? $byAuthor[1] : "$searched, $byAuthor[1]");

        $byUpdater = static::byUpdater($value, $searched);
        $documents ['Last Updated By'] = $byUpdater[0];
        $searched = empty($byUpdater[1]) ? ($searched) : (empty($searched) ? $byUpdater[1] : "$searched, $byUpdater[1]");

        $statusBy = static::byStatuser($value, $searched);
        $documents ['Changed Status By'] = $statusBy[0];
        $searched = empty($statusBy[1]) ? ($searched) : (empty($searched) ? $statusBy[1] : "$searched, $statusBy[1]");

        $byLocker = static::byLocker($value, $searched);
        $documents ['Locked By'] = $byLocker[0];
        $searched = empty($byLocker[1]) ? ($searched) : (empty($searched) ? $byLocker[1] : "$searched, $byLocker[1]");

        $byArchiver = static::byArchiver($value, $searched);
        $documents ['Archived By'] = $byArchiver[0];
        $searched = empty($byArchiver[1]) ? ($searched) : (empty($searched) ? $byArchiver[1] : "$searched, $byArchiver[1]");

        $byDeleter = static::byDeleter($value, $searched);
        $documents ['Recyled By'] = $byDeleter[0];
        $searched = empty($byDeleter[1]) ? ($searched) : (empty($searched) ? $byDeleter[1] : "$searched, $byDeleter[1]");

        $byRestorer = static::byRestorer($value, $searched);
        $documents ['Restored By'] = $byRestorer[0];
        $searched = empty($byRestorer[1]) ? ($searched) : (empty($searched) ? $byRestorer[1] : "$searched, $byRestorer[1]");

//        $byFileContent = static::byFileContent($value, $searched);
//        $documents ['File Content Search'] = $byFileContent[0];
//        $searched = empty($byFileContent[1]) ? ($searched) : (empty($searched) ? $byFileContent[1] : "$searched, $byFileContent[1]");

        return $documents;
    }

    /**
     * 
     * @param Documents $documents search results
     * @param integer $user user id
     * @return Documents models
     */
    public static function filterOnlyVisiblePrivileges($documents, $user) {
        /* @var $document Documents */

        $is_admin = User::returnUser($user)->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]);

        $accepts = [self::file_read, self::file_write, self::file_alter];

        foreach ($documents as $j => $criteria)
            foreach ($criteria as $i => $document) {
                if (!$is_admin && !in_array($right = $document->desiredUserPrivilegeToDocument($user, null, false, true, $iko = !empty($rights[$document->directory]), $iko ? $rights[$document->directory] : self::file_deny, false), $accepts))
                    unset($documents[$j][$i]);
                !$is_admin && ($document->dir_or_file == self::FILE_IS_DIRECTORY || !$iko) ? $rights[$document->dir_or_file == self::FILE_IS_DIRECTORY ? $document->id : $document->directory] = $right : '';
            }

        return $documents;
    }

    /**
     * 
     * @param Documents $documents search results
     * @param integer $preferred_folder_id preferred folder id
     * @return Documents models
     */
    public static function currentFolderFilter($documents, $preferred_folder_id) {
        /* @var $document Documents */

        if (is_object($preferred_folder = static::returnDocument($preferred_folder_id))) {
            foreach ($documents as $j => $criteria)
                foreach ($criteria as $i => $document)
                    if (stripos($document->filename, $preferred_folder->filename) > -1 && $document->file_level > $preferred_folder->file_level) {
                        $preferred_documents[$document->name] = $document;
                        unset($documents[$j][$i]);
                    }
            !empty($preferred_documents) && ksort($preferred_documents);
        }

        return empty($preferred_documents) ? ($documents) : (['Within Current Folder' => $preferred_documents] + $documents);
    }

    /**
     * 
     * @param string $value property of document
     * @param integer $user user id
     * @param integer $preferred_folder_id preferred folder id
     * @return Documents models
     */
    public static function searchDocuments($value, $user, $preferred_folder_id) {
        return static::currentFolderFilter(static::filterOnlyVisiblePrivileges(StaticMethods::isDate($value) ? static::searchDocumentsByGivenDate($value) : static::searchDocumentsByGivenString($value), $user), $preferred_folder_id);
    }

    /**
     * 
     * @param Documents $docs document models
     * @return string list of `$docs` ids
     */
    public static function concatIDs($docs) {
        foreach ($docs as $doc)
            $children = empty($children) ? "'$doc->id'" : "$children, '$doc->id'";

        return empty($children) ? '' : $children;
    }

    /**
     * 
     * @param integer $user user id
     * @param string $privilege admin, sub_admin, other_user
     * @return Documents models
     */
    public static function documentsToWhichUserHasPrivilege($user, $privilege) {
        foreach (DocumentsPermissions::userHasDocumentPermissions(null, $user, $privilege) as $permission)
            $ids = empty($ids) ? "'$permission->document'" : "$ids, '$permission->document'";

        if (empty($ids))
            return [];

        return static::find()->documentsByCustomQuery("id in ($ids)", Sections::all);
    }

    /**
     * 
     * @param integer $user user id
     * @return Documents models
     */
    public static function openedByUserForUpdate($user) {
        return static::find()->openedByUserForUpdate($user);
    }

    /**
     * 
     * @param array $parentPrivileges array with access parameters to a document: privilege to parent document, privilege to document, if document has permissions, if parent has permissions, if parent has barring effect to document by permissions
     * @return boolean true - parent has permissions
     */
    public static function aParentHasABarringEffectToChildDocumentPermission($parentPrivileges) {
        foreach ($parentPrivileges as $parentPrivilege)
            if ($parentPrivilege[2])
                return true;
    }

    /**
     * 
     * @param string $previousPrivilege previous privilege
     * @param string $nextPrivilege next privilege
     * @param boolean $inherit true - choose `$previousPrivilege` if less than `$nextPrivilege`
     * @return string appropriate desired privilege
     */
    public static function nextPrivilege($previousPrivilege, $nextPrivilege, $inherit) {
        if (!$inherit || $nextPrivilege == self::file_deny || $nextPrivilege == $previousPrivilege || $previousPrivilege == self::file_alter || ($previousPrivilege == self::file_write && $nextPrivilege != self::file_alter) || ($previousPrivilege == self::file_read && $nextPrivilege != self::file_write && $nextPrivilege != self::file_alter))
            return $nextPrivilege;
        else
            return $previousPrivilege;
    }

    /**
     * 
     * @param string $previousPrivilege previous privilege
     * @param string $nextPrivilege next privilege
     * @param boolean $inherit true - choose `$previousPrivilege` if less than `$nextPrivilege`
     * @return string appropriate desired privilege
     */
    public static function subNextPrivilege($previousPrivilege, $nextPrivilege, $inherit) {
        if (!$inherit || $previousPrivilege == self::file_deny || $nextPrivilege == $previousPrivilege || $nextPrivilege == self::file_alter || ($nextPrivilege == self::file_write && $previousPrivilege != self::file_alter) || ($nextPrivilege == self::file_read && $previousPrivilege != self::file_write && $previousPrivilege != self::file_alter))
            return $nextPrivilege;
        else
            return $previousPrivilege;
    }

    /**
     * 
     * @param integer $status desired status
     * @return string full db version of file parent directory location
     */
    public function fileParentFolder($status) {
        return is_object($directory = $this->returnDocument($this->directory)) ? $directory->fileLocation() : static::dbNameFileLocation('', empty($status) ? (isset($this->status) ? $this->status : self::FILE_STATUS_AVAILABLE) : ($status));
    }

    /**
     * 
     * @param string $filename file location
     * @return string immediate parent folder to `$filename`
     */
    public function parentFolder($filename) {
        $exp = explode('/', $filename);

        array_pop($exp);

        return implode('/', $exp);
    }

    /**
     * 
     * @return string the nearest folder location
     */
    public function nearestFolderLocation() {
        return $this->dir_or_file == self::FILE_IS_DOCUMENT ? substr($this->filename, 0, strripos($this->filename, '/')) : $this->filename;
    }

    /**
     * 
     * @return string full db version of file location
     */
    public function fileLocation() {
        return static::dbNameFileLocation($this->filename, $this->status);
    }

    /**
     * 
     * @return string extension of document
     */
    public function fileExtesion() {
        return $this->dir_or_file == self::FILE_IS_DOCUMENT ? substr($this->filename, strripos($this->filename, '.') + 1) : StaticMethods::ext_folder;
    }

    /**
     * 
     * @param boolean $location true - return icon location, else icon url
     * @return string icon location or url
     */
    public function fileIcon($location) {
        return StaticMethods::documentVersionIcon($this->fileExtesion(), $location);
    }

    /**
     * 
     * @return string the precise name of file without its location
     */
    public function justNameOFile() {
        $split = explode('/', $this->filename);
        return end($split);
    }

    /**
     * 
     * @param integer $status document status
     * @return string location to download document
     */
    public function downloadFile($status) {
        return $this->status == $status && StaticMethods::fileExists($location = $this->fileLocation()) != StaticMethods::file_not_found &&
                (Logs::newLog(Logs::document_download, "Dowloaded document $this->name, id $this->id from " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->filename, $this->id, $location, str_replace(StaticMethods::downloadsFolderUrl(), StaticMethods::downloads_folder . '/', $url = StaticMethods::fileDownload($location)), Logs::success) || true) &&
                !empty($url) ? $url : static::file_not_exists;
    }

    /**
     * 
     * @return boolean true - file locked for update
     */
    public function lockForUpdate() {
        if ($this->documentCanBeLockedByUser($this->userPreferredDocumentPrivilege($user = Yii::$app->user->identity->id, false, true, false, self::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $this->opened_for_update != self::FILE_OPENED_FOR_UPDATE || $this->opened_for_update_by == $user) {
            if ($this->opened_for_update != self::FILE_OPENED_FOR_UPDATE) {
                $this->opened_for_update = self::FILE_OPENED_FOR_UPDATE;
                $this->opened_for_update_at = StaticMethods::now();
            }

            return $this->update(false, ['opened_for_update', 'opened_for_update_by', 'opened_for_update_at', 'visible_to_others_during_update']) &&
                    (Logs::newLog(Logs::lock_document, "Locked document $this->name in " . static::tableName() . ' for update', Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, self::FILE_NOT_OPENED_FOR_UPDATE . ',' . self::FILE_VISIBLE_DURING_UPDATE, $this->id, "$this->opened_for_update,$this->visible_to_others_during_update", $this->visible_to_others_during_update == self::FILE_VISIBLE_DURING_UPDATE ? 'Visible By Other Users During Update' : 'Not Visible By Other Users During Update', Logs::success) || true);
        }
    }

    /**
     * 
     * @param integer $user user id
     * @return boolean true - file unlocked
     */
    public function unlockFile($user) {
        if ($this->opened_for_update == self::FILE_OPENED_FOR_UPDATE && $this->opened_for_update_by == $user) {

            $this->opened_for_update = self::FILE_NOT_OPENED_FOR_UPDATE;

            $this->opened_for_update_by = null;

            $this->opened_for_update_at = null;

            ($visible = $this->visible_to_others_during_update == self::FILE_VISIBLE_DURING_UPDATE) ? '' : $this->visible_to_others_during_update = self::FILE_VISIBLE_DURING_UPDATE;

            return $this->update(false, ['opened_for_update', 'opened_for_update_by', 'opened_for_update_at', 'visible_to_others_during_update']) &&
                    (Logs::newLog(Logs::unlock_document, "Unlocked document $this->name in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, self::FILE_OPENED_FOR_UPDATE . ',' . ($visible ? self::FILE_VISIBLE_DURING_UPDATE : self::FILE_NOT_VISIBLE_DURING_UPDATE), $this->id, "$this->opened_for_update,$this->visible_to_others_during_update", $this->visible_to_others_during_update == self::FILE_VISIBLE_DURING_UPDATE ? 'Visible By Other Users During Update' : 'Not Visible By Other Users During Update', Logs::success) || true);
        }
    }

    /**
     * 
     * @param integer $user unlock files locked by user
     */
    public static function unlockFilesLockedByUser($user) {
        foreach (static::openedByUserForUpdate($user) as $document)
            $document->unlockFile($user);
    }

    /**
     * 
     * @param \yii\web\UploadedFile $instance uploaded file instance
     * @param string $folder folder to upload file to
     * @return boolean true - file updated. new uploaded, previous dropped
     */
    public function updateFile($instance, $folder) {
        if ($this->documentCanBeUpdatedByUser($user = Yii::$app->user->identity->id, $folder, Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $this->opened_for_update == self::FILE_OPENED_FOR_UPDATE && $this->opened_for_update_by == $user) {
            $previousLocation = $this->fileLocation();

            StaticMethods::saveUploadedFile($this, 'filename', $instance, StaticMethods::dirSubRoot(self::subDirNameForStatus($this->status)), $folder, StaticMethods::stripNonNumeric(StaticMethods::now()));

            $this->opened_for_update = self::FILE_NOT_OPENED_FOR_UPDATE;

            $this->opened_for_update_by = null;

            $this->opened_for_update_at = null;

            $this->visible_to_others_during_update = self::FILE_VISIBLE_DURING_UPDATE;

            $this->updated_by = $user;

            $this->updated_at = StaticMethods::now();

            if (!$this->hasErrors('filename') && $this->update(false, ['filename', 'updated_by', 'updated_at', 'opened_for_update', 'opened_for_update_by', 'opened_for_update_at', 'visible_to_others_during_update']))
                return $this->updateVersion() && StaticMethods::fileUnlink($previousLocation);
            else
                StaticMethods::fileUnlink($this->fileLocation());
        }
    }

    /**
     * 
     * @return boolean true - document version created
     */
    public function updateVersion() {
        return $this->dir_or_file == self::FILE_IS_DOCUMENT ? copy(StaticMethods::dirRoot() . $this->fileLocation(), StaticMethods::versionsFolder() . ($version = substr($this->filename, strripos($this->filename, '/') + 1))) &&
                Logs::newLog(Logs::new_version, "Update of document $this->name in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->filename, $this->id, $this->filename, $version, Logs::success) : true;
    }

    /**
     * 
     * @param integer $version_id log / version id
     * @param integer $status document status
     * @return string document reverted from history or not
     */
    public function revertFromHistory($version_id, $status) {
        if ($this->documentCanBeRevertedByUser($this->userPreferredDocumentPrivilege($user = Yii::$app->user->identity->id, false, true, false, Documents::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && $this->status == $status && StaticMethods::fileExists($this->fileLocation()) != StaticMethods::file_not_found)
            if ($this->opened_for_update != self::FILE_OPENED_FOR_UPDATE || $this->opened_for_update_by == Yii::$app->user->identity->id)
                if (is_object($version = Logs::returnLog($version_id)) && $version->origin_id == $this->id && $version->status == Logs::success && $version->available == Logs::available && is_file($version_location = $version->documentVersionLocation()))
                    if (!$version->documentVersionIsCurrent($this->filename)) {
                        copy($version_location, StaticMethods::dirRoot() . static::subDirNameForStatus($this->status) . '/' . ($new_filename = substr($this->filename, 0, strripos($previousFilename = $this->filename, '/') + 1) . $version->further_narration));

                        StaticMethods::fileUnlink($this->fileLocation());

                        $this->filename = $new_filename;
                        $this->updated_by = $user;
                        $this->updated_at = StaticMethods::now();

                        return $this->update(false, ['filename', 'updated_by', 'updated_at']) &&
                                (Logs::newLog(Logs::revert_from_history, "Document $this->name in " . static::tableName() . " reverted to  $version->further_narration from " . Logs::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $previousFilename, $this->id, $this->filename, $version->further_narration, Logs::success) || true) &&
                                ($this->unlockFile($this->updated_by) || true);
                    } else
                        return true;
                else
                    return Logs::document_version_not_exists;
            else
                return self::open_for_update;
        else
            return self::file_not_exists;
    }

    /**
     * 
     * @param boolean $ignoreStatus true - ignore document status
     * @return Logs models
     */
    public function documentVersions($ignoreStatus) {
        return $ignoreStatus || $this->status > self::FILE_STATUS_DELETED ? Logs::documentVersions($this->id) : [];
    }

    /**
     * 
     * @param integer $status desired status
     * @return Documents contents of `$this` directory
     */
    public function documentContents($status) {
        return static::documentsInDirectory($this->id, in_array("$status", static::documentStatuses()) ? $this->status : $status, false, 'id asc');
    }

    /**
     * 
     * @param integer $status desired status
     * @return Documents contents of `$this` directory
     */
    public function childFolders($status) {
        return static::documentsInDirectory($this->id, $status, true, 'id asc');
    }

    /**
     * 
     * @param Documents $destination model
     * @return boolean true or folder - file moved successfully
     */
    public function fileMove($destination) {
        // if the destination folder is the immediate containing folder then we consider the move done
        if (static::isImmediateParent($from = $this->filename, $destination->filename, $this->status, $destination->status))
            return true;

        // move only clients' documents, within the clients' directories, and within the main sub-root folder
        if ($destination->status == $this->status && $this->file_level >= self::min_client_document_level && ($destination->file_level >= self::min_client_document_level || ($destination->file_level == self::min_sub_root_document_level && $this->dir_or_file == self::FILE_IS_DIRECTORY))) {

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            if (($is_dir = $this->dir_or_file == self::FILE_IS_DIRECTORY) ? (is_dir($path = $root . $destination->fileLocation() . '/' . ($filename = $this->justNameOFile())) ? true : mkdir($path, 0777, false)) : (rename($root . $this->fileLocation(), ($root . $destination->fileLocation() . '/' . ($filename = $this->justNameOFile()))))) {
                $this->directory = $destination->id;
                $this->filename = "$destination->filename/$filename";
                $this->file_level = $destination->file_level + 1;
                $this->status = $destination->status;
                $this->status_by = Yii::$app->user->identity->id;
                $this->status_at = StaticMethods::now();

                $this->validate(['name']) ? '' : $this->name = ($this->name . ' ' . StaticMethods::stripNonNumeric($this->status_at));

                return $this->update(false, ['directory', 'filename', 'name', 'file_level', 'status', 'status_by', 'status_at']) &&
                        (Logs::newLog(Logs::move_document, "Moved $this->name from $from to $this->filename in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $from, $this->id, $this->filename, $this->name, Logs::success) || true);
            }
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @param Documents $destination destination document id
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @return boolean true - file or folder with contents moved successfully
     */
    public function fileRecursiveMove($destination, $status) {
        $move_successful = true;

        $source = $this->filename;

        if (is_object($destination)) //destination must be in db
            if ($this->status == $status && StaticMethods::fileExists($this->fileLocation()) != StaticMethods::file_not_found) //the file notation db agree with file location
                if (StaticMethods::fileExists(StaticMethods::fileExists($destination->fileLocation())) != StaticMethods::file_not_found) //destination folder must exist
                    if ($this->fileMove($destination) == '1') //move the file
                        foreach ($this->documentContents($status) as $new_source) //for the folders, consider its children and move them too, recursively
                            $new_source->fileRecursiveMove($this, $new_source->status) == '1' ? '' : $move_successful = false;
                    else
                        $move_successful = false;
                else
                    return self::file_destination_not_exists;
            else
                return self::file_not_exists;
        else
            return self::file_destination_not_in_db;

        if ($move_successful) {

            if (is_dir(StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status))) {
                $this->ifChangeArchivedAndRecycledLocation($source, $this->filename);
                @rmdir(StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status));
            }

            return '1';
        }
    }

    /**
     * 
     * @param integer $status file status
     * @param string $type file type 0 - directory, 1 - file
     * @return Documents choice children to folder
     */
    public function documentChildrenByFilenameAndLocation($status, $type) {
        return static::childrenToDirectoryByFilenameAndLocation($this->filename, $status, $type);
    }

    /**
     * 
     * @param string $ids document ids comma separated
     * @param integer $status document status
     * @param string $type - zipFldr or zipFldrUrl
     * @return string zipped folder location or url
     */
    public static function zipAndExport($ids, $status, $type) {
        $documents = [];

        foreach (explode(',', $ids) as $id)
            if (is_object($document = static::returnDocument($id)) && $document->documentCanBeZippedByUser($right = $document->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, Documents::file_deny), $is_admin = Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])) && ($type != self::zip_location || $document->documentCanBeSentByUser($right, $is_admin)))
                if ($document->dir_or_file == self::FILE_IS_DOCUMENT)
                    array_push($documents, [StaticMethods::dirRoot() . $document->fileLocation(), $document->name, $document->id]);
                else
                    foreach ($document->documentChildrenByFilenameAndLocation($status, self::FILE_IS_DOCUMENT) as $child)
                        array_push($documents, [StaticMethods::dirRoot() . $child->fileLocation(), $child->name, $child->id]);

        return $type == self::zip_location ? StaticMethods::zipAndLoad($documents) : StaticMethods::zipAndDownload($documents);
    }

    /**
     * 
     * @param array $post array of post parameters
     * @return string|boolean if document sent and received successfully
     */
    public function sendDocumentAsSchemeOfWork($post) {
        if (isset($post['sbmt'])) {
            $post['SchemesOfWork']['location'] = new \CURLFile(realpath(StaticMethods::dirRoot() . $this->fileLocation()));

            $post['SchemesOfWork']['submitted_by'] = Yii::$app->user->identity->name;
        } else
            $post['SchemesOfWork']['school'] = 1;

        return StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/receive-schemes-of-work', $post);
    }

    /**
     * 
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @param string $attribute can_be_updated, can_be_moved, can_be_deleted
     * @param integer $value 0 - false, 1 - true
     * @return boolean true - model updated
     */
    public function fileUpdatability($status, $attribute, $value) {
        $toMark = $attribute == 'can_be_updated' ? ('documentCanBeMarkedUpdatableByUser') : ($attribute == 'can_be_moved' ? 'documentCanBeMarkedMovableByUser' : 'documentCanBeMarkedDeletableByUser');

        if ($this->$toMark($this->userPreferredDocumentPrivilege(Yii::$app->user->identity->id, false, true, false, self::file_deny), Yii::$app->user->identity->userStillHasRights([User::USER_ADMIN, User::USER_SUPER_ADMIN])))
            if ($this->status == $status && StaticMethods::fileExists($this->fileLocation()) != StaticMethods::file_not_found) { //the file notation db agree with file location)
                $this->$attribute = $value;

                $previousValue = static::returnDocument($this->id)->$attribute;

                return $this->update(false, [$attribute]) &&
                        (Logs::newLog(Logs::document_movable_updatable_deletable, "Updated document, $this->name, property $attribute from $previousValue to $value in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $previousValue, $this->id, $value, $this->filename, Logs::success) || true);
            }
    }

    /**
     * 
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @param string $name new name of file
     * @return boolean true - name of file saved
     */
    public function changeNameOfFile($status, $name) {
        if ($this->status == $status && StaticMethods::fileExists($this->fileLocation()) != StaticMethods::file_not_found) { //the file notation db agree with file location)
            $this->name = str_replace("'", '', str_replace('"', '', $name));

            $previousDoc = static::returnDocument($this->id);

            return !is_object(static::duplicateName($this->directory, $this->name, $this->id)) && ($this->save(['name']) &&
                    (Logs::newLog(Logs::rename_document, "Rename document from $previousDoc->name to $this->name in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $previousDoc->name, $this->id, $this->name, $this->filename, Logs::success) || true)) ?
                    ucwords(strtolower($this->name)) : false;
        }
    }

    /**
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @return string folder containing document
     */
    public function fileLocationToClient($status) {
        if ($this->status != $status)
            return static::fileLocationToClientByLocation($status, $this->fileLocation());

        $location = ucfirst(static::subDirForStatus($this->status));

        $parents = $this->allParentsToDocument();

        krsort($parents);

        foreach ($parents as $parent)
            $location = "$location \\ $parent->name";

        return "$location";
    }

    /**
     * 
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @param string $location file location
     * @return string folder containing document
     */
    public static function fileLocationToClientByLocation($status, $location) {
        $parentLocation = ucfirst(static::subDirForStatus($status));

        foreach (static::allParentsToDocumentByLocation($location) as $parent)
            $parentLocation = "$parentLocation > $parent->name";

        return $parentLocation;
    }

    /**
     * 
     * @return integer document size
     */
    public function documentSize() {
        return static::fileSize($this->fileLocation());
    }

    /**
     * 
     * @param string $source source directory
     * @param string $destination destination directory
     */
    public function ifChangeArchivedAndRecycledLocation($source, $destination) {
        $root = StaticMethods::dirRoot();

        foreach ([self::FILE_STATUS_ARCHIVED, self::FILE_STATUS_DELETED] as $status)
            if (is_dir($full_source = $root . static::dbNameFileLocation($source, $status))) {
                static::changeArchivedAndRecycledLocation($full_source, $root . static::dbNameFileLocation($destination, $status), $status);

                if (!in_array(substr($full_source, strrpos('/', $full_source) + 1), StaticMethods::rootSubDirs()))
                    glob($parent = str_replace(substr($full_source, strrpos('/', $full_source)), '', $full_source)) ? '' : @rmdir($parent);
            }
    }

    /**
     * 
     * @param string $source source directory
     * @param string $destination destination directory
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     */
    public static function changeArchivedAndRecycledLocation($source, $destination, $status) {

        is_dir($destination) ? '' : mkdir($destination, 0777, true);

        foreach (scandir($source) as $name)
            if ($name != '.' && $name != '..') {
                if (is_dir($path = realpath($source . DIRECTORY_SEPARATOR . $name))) {
                    static::changeArchivedAndRecycledLocation($path, $to = "$destination/" . basename($path), $status);
                    @rmdir($source);
                } else
                    rename($path, $to = "$destination/" . basename($path));

                static::adjustFilenameInDbToo($path, $to, $status);
            }
    }

    /**
     * 
     * @param string $old_name original location
     * @param string $new_name final location
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     */
    public static function adjustFilenameInDbToo($old_name, $new_name, $status) {
        $chuja = self::firm_root_folder . '/' . self::subDirNameForStatus($status) . '/';

        $old_name_db = str_replace($chuja, '', substr($old_name = str_replace('\\', '/', $old_name), stripos($old_name, $chuja)));
        $new_name_db = str_replace($chuja, '', substr($new_name = str_replace('\\', '/', $new_name), stripos($new_name, $chuja)));

        if (is_object($document = static::byFileNameAndStatus($old_name_db, $status))) {
            $document->filename = $new_name_db;
            $document->update(false, ['filename']);
        }
    }

    /**
     * 
     * @param Documents $destination model
     * @return Documents the created new document
     */
    public function fileCopy($destination) {
        // copy only clients' documents, within the clients' directories, and within the main sub-root folder
        if ($destination->status == $this->status && $this->file_level >= self::min_client_document_level && ($destination->file_level >= self::min_client_document_level || ($destination->file_level == self::min_sub_root_document_level && $this->dir_or_file == self::FILE_IS_DIRECTORY))) {

            $justNameOfFile = ($is_dir = $this->dir_or_file == self::FILE_IS_DIRECTORY) ? $this->justNameOFile() : explode('.', $this->justNameOFile());

            $new_filename = StaticMethods::stripNonNumeric(StaticMethods::now()) . ($is_dir ? ('') : ('.' . end($justNameOfFile)));

            // instantiate a new document
            $document = static::documentToLoad(null, $destination->id, $this->name, "$destination->filename/$new_filename", $destination->file_level + 1, $this->dir_or_file, $destination->status, true);

            $document->validate(['name']) ? '' : $document->name = ($document->name . ' ' . StaticMethods::stripNonNumeric(StaticMethods::now()));

            $document->status_at = $document->created_at = StaticMethods::now();
            $document->visible_to_others_during_update = $this->visible_to_others_during_update;
            $document->can_be_updated = $this->can_be_updated;
            $document->can_be_moved = $this->can_be_moved;
            $document->can_be_deleted = $this->can_be_deleted;

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            return ($is_dir ? (is_dir($path = $root . $document->fileLocation()) ? true : mkdir($path, 0777, false)) : (copy($root . $this->fileLocation(), $root . $document->fileLocation()))) && $document->save(false) &&
                    (Logs::newLog(Logs::copy_document, 'Copied ' . ($this->dir_or_file == self::FILE_IS_DIRECTORY ? "folder $this->name " : "file $this->name ") . "to $document->name in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->filename, $document->id, $document->filename, $document->name, Logs::success) || true) && ($document->updateVersion() || true) ? $document : false;
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @param Documents $destination destination document id
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @return boolean true - file or folder with contents copied successfully
     */
    public function fileRecursiveCopy($destination, $status) {

        $copy_successful = true;

        if (is_object($destination)) //destination must be in db
            if ($this->status == $status && StaticMethods::fileExists($this->fileLocation()) != StaticMethods::file_not_found) // db notation must agree with file location
                if (StaticMethods::fileExists(StaticMethods::fileExists($destination->fileLocation())) != StaticMethods::file_not_found) //destination must exist
                    if (is_object($new_destination = $this->fileCopy($destination))) // copy file into destination
                        foreach ($this->documentContents(null) as $new_source) //if folder then consider its children and recursively copy them too
                            $new_source->fileRecursiveCopy($new_destination, $new_source->status) == '1' ? '' : $copy_successful = false;
                    else
                        $copy_successful = false;
                else
                    return self::file_destination_not_exists;
            else
                return self::file_not_exists;
        else
            return self::file_destination_not_in_db;

        return $copy_successful ? '1' : false;
    }

    /**
     * 
     * @return boolean true - file or folder archived successfully
     */
    public function fileArchive() {
        // archive only clients' documents
        if ($this->file_level >= self::min_client_document_level) {

            // notation of the archive location for the file
            $destination = static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_ARCHIVED);

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            if ((is_dir($dest_prnt = $root . $this->parentFolder($destination)) ? true : mkdir($dest_prnt, 0777, true)) && $this->dir_or_file == self::FILE_IS_DIRECTORY ? (is_dir($path = "$root$destination") ? true : mkdir($path, 0777, false)) : (rename($root . $this->fileLocation(), "$root$destination"))) {
                $this->deleted_at = $this->deleted_by = $this->deleted_to = null;
                $this->archived_in = $this->filename;
                $this->status = $status;
                $this->archived_by = $this->status_by = Yii::$app->user->identity->id;
                $this->archived_at = $this->status_at = StaticMethods::now();

                return ($this->update(false, ['archived_in', 'archived_by', 'archived_at', 'deleted_to', 'deleted_by', 'deleted_at', 'status', 'status_by', 'status_at']) &&
                        (Logs::newLog(Logs::archive_document, "Archived document $this->name from $this->filename to $this->filename in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, static::subDirForStatus(static::FILE_STATUS_AVAILABLE), $this->id, static::subDirForStatus(static::FILE_STATUS_ARCHIVED), $this->name, Logs::success) || true)) || !$this->hasErrors() ? '1' : false;
            }
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @return boolean true - file or folder with contents archived successfully
     */
    public function fileRecursiveArchive() {
        $archive_successful = true;

        $source = $this->filename;

        if (StaticMethods::fileExists(static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_AVAILABLE)) != StaticMethods::file_not_found) // the file notation db agree with file location, given the status
            if ($this->fileArchive() == '1') // archive the file
                foreach ($this->documentContents($status) as $new_source) // for the folders, consider its children and archive them too, recursively
                    $new_source->fileRecursiveArchive() == '1' ? '' : $archive_successful = false;
            else
                $archive_successful = false;
        else
            return self::file_not_exists;

        if ($archive_successful) {
            is_file($dir = StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status)) || @rmdir($dir);
            return '1';
        }
    }

    /**
     * 
     * @return boolean true - file or folder recycled successfully
     */
    public function fileRecycle() {
        // archive only clients' documents
        if ($this->file_level >= self::min_client_document_level) {

            // if document is not archived, stop here
            if ($this->status != self::FILE_STATUS_ARCHIVED)
                return '1';

            // notation of the recycle location for the file
            $destination = static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_DELETED);

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            if ((is_dir($dest_prnt = $root . $this->parentFolder($destination)) ? true : mkdir($dest_prnt, 0777, true)) && $this->dir_or_file == self::FILE_IS_DIRECTORY ? (is_dir($path = "$root$destination") ? true : mkdir($path, 0777, false)) : (rename($root . $this->fileLocation(), "$root$destination"))) {

                $this->archived_at = $this->archived_by = $this->archived_in = null;
                $this->deleted_to = $this->filename;
                $this->status = $status;
                $this->deleted_by = $this->status_by = Yii::$app->user->identity->id;
                $this->deleted_at = $this->status_at = StaticMethods::now();

                return ($this->update(false, ['archived_in', 'archived_by', 'archived_at', 'deleted_to', 'deleted_by', 'deleted_at', 'status', 'status_by', 'status_at']) &&
                        (Logs::newLog(Logs::recycle_document, "Recycled document $this->name from $this->filename to $this->filename in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, static::subDirForStatus(static::FILE_STATUS_ARCHIVED), $this->id, static::subDirForStatus(static::FILE_STATUS_DELETED), $this->name, Logs::success) || true)) || !$this->hasErrors() ? '1' : false;
            }
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @return boolean true - file or folder with contents recycled successfully
     */
    public function fileRecursiveRecycle() {
        $recycle_successful = true;

        $source = $this->filename;

        if (StaticMethods::fileExists(static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_ARCHIVED)) != StaticMethods::file_not_found || StaticMethods::fileExists(static::dbNameFileLocation($this->filename, self::FILE_STATUS_AVAILABLE)) != StaticMethods::file_not_found) // the file notation db agree with file location, given the status
            if ($this->fileRecycle() == '1') // archive the file
                foreach ((count($children = $this->documentContents($status)) > 0 ? $children : $this->documentContents(self::FILE_STATUS_AVAILABLE)) as $new_source)// for the folders, consider its children and recycle them too, recursively
                    $new_source->fileRecursiveRecycle() == '1' ? '' : $recycle_successful = false;
            else
                $recycle_successful = false;
        else
        if ($this->status == $status)
            return self::file_not_exists;

        if ($recycle_successful) {
            is_file($dir = StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status)) || @rmdir($dir);
            return '1';
        }
    }

    /**
     * 
     * on restoring a document from archive or recycle, consider the containing folders too
     * @param integer $status 0 - archived, 1 - available, -1 - recycled
     * @return boolean true - parent directories restored accordingly
     */
    public function ifRestoreParents($status) {

        foreach ($this->allParentsToDocument() as $parent)
            if ($parent->status < $status)
                if (($parent->status == self::FILE_STATUS_ARCHIVED ? $parent->fileRestoreFromArchive() : $parent->fileRestoreFromRecycle($status)) != '1')
                    return false;

        return true;
    }

    /**
     * 
     * @return boolean true - file or folder restored from archives successfully
     */
    public function fileRestoreFromArchive() {
        // restore only clients' documents
        if ($this->file_level >= self::min_client_document_level) {

            // if document is already in documents, then stop here
            if ($this->status == ($status = self::FILE_STATUS_AVAILABLE))
                return '1';

            // notation of the restore location for the file
            $destination = static::dbNameFileLocation($this->filename, $status);

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            if ((is_dir($dest_prnt = $root . $this->parentFolder($destination)) ? true : mkdir($dest_prnt, 0777, true)) && $this->dir_or_file == self::FILE_IS_DIRECTORY ? (is_dir($path = "$root$destination") ? true : mkdir($path, 0777, false)) : (rename($root . $this->fileLocation(), "$root$destination"))) {
                $this->deleted_at = $this->deleted_by = $this->deleted_to = $this->archived_at = $this->archived_by = $this->archived_in = null;
                $this->status = $status;
                $this->status_by = Yii::$app->user->identity->id;
                $this->status_at = StaticMethods::now();

                return ($this->update(false, ['archived_in', 'archived_by', 'archived_at', 'deleted_to', 'deleted_by', 'deleted_at', 'status', 'status_by', 'status_at']) &&
                        (Logs::newLog(Logs::restore_from_archive, "Restored document $this->name from $this->filename to $this->filename in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, static::subDirForStatus(static::FILE_STATUS_ARCHIVED), $this->id, static::subDirForStatus(static::FILE_STATUS_AVAILABLE), $this->name, Logs::success) || true)) || !$this->hasErrors() ? '1' : false;
            }
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @return boolean true - file or folder with contents restored from archives successfully
     */
    public function fileRecursiveRestoreFromArchive() {
        $restore_successful = true;

        $source = $this->filename;

        if (StaticMethods::fileExists($location = static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_ARCHIVED)) != StaticMethods::file_not_found || StaticMethods::fileExists(static::dbNameFileLocation($this->filename, self::FILE_STATUS_AVAILABLE)) != StaticMethods::file_not_found) // the file notation db agree with file location
            if ($this->ifRestoreParents($new_status = self::FILE_STATUS_AVAILABLE) && $this->fileRestoreFromArchive() == '1') // restore the file
                foreach ((count($children = $this->documentContents($status)) > 0 ? $children : $this->documentContents($new_status)) as $new_source) // for the folders, consider its children and restore them too, recursively
                    $new_source->fileRecursiveRestoreFromArchive() == '1' ? '' : $restore_successful = false;
            else
                $restore_successful = false;
        else
        if ($this->status == $status)
            return self::file_not_exists;

        if ($restore_successful) {
            is_file($dir = StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status)) || @rmdir($dir);
            return '1';
        }
    }

    /**
     * 
     * @param integer $status 0 - archived, 1 - available
     * @return boolean true - file or folder restored from archives successfully
     */
    public function fileRestoreFromRecycle($status) {
        // restore only clients' documents
        if ($this->file_level >= self::min_client_document_level) {

            // if document is already in desired destination folder, then stop here
            if ($this->status >= $status)
                return '1';

            // notation of the restore location for the file
            $destination = static::dbNameFileLocation($this->filename, $status);

            $root = StaticMethods::dirRoot();

            // if directory then make in the destination else simply rename the file into destination
            if ((is_dir($dest_prnt = $root . $this->parentFolder($destination)) ? true : mkdir($dest_prnt, 0777, true)) && $this->dir_or_file == self::FILE_IS_DIRECTORY ? (is_dir($path = "$root$destination") ? true : mkdir($path, 0777, false)) : (rename($root . $this->fileLocation(), "$root$destination"))) {
                $this->deleted_at = $this->deleted_by = $this->deleted_to = $this->archived_at = $this->archived_by = $this->archived_in = null;
                $this->status = $status;
                $this->status_by = Yii::$app->user->identity->id;
                $this->status_at = StaticMethods::now();

                return ($this->update(false, ['archived_in', 'archived_by', 'archived_at', 'deleted_to', 'deleted_by', 'deleted_at', 'status', 'status_by', 'status_at']) &&
                        (Logs::newLog(($toDocs = $this->status == self::FILE_STATUS_AVAILABLE) ? Logs::restore_to_documents : Logs::restore_to_archive, "Restored document $this->name from $this->filename to $this->filename in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, static::subDirForStatus(static::FILE_STATUS_DELETED), $this->id, static::subDirForStatus($toDocs ? static::FILE_STATUS_AVAILABLE : static::FILE_STATUS_ARCHIVED), $this->name, Logs::success) || true)) || !$this->hasErrors() ? '1' : false;
            }
        } else
            return self::action_not_allowed;
    }

    /**
     * 
     * @param integer $new_status 0 - archived, 1 - available
     * @return boolean true - file or folder with contents restored from archives successfully
     */
    public function fileRecursiveRestoreFromRecycle($new_status) {
        $restore_successful = true;

        $source = $this->filename;

        if (StaticMethods::fileExists(static::dbNameFileLocation($this->filename, $status = self::FILE_STATUS_DELETED)) != StaticMethods::file_not_found || StaticMethods::fileExists(static::dbNameFileLocation($this->filename, self::FILE_STATUS_ARCHIVED)) != StaticMethods::file_not_found || StaticMethods::fileExists(static::dbNameFileLocation($this->filename, self::FILE_STATUS_AVAILABLE)) != StaticMethods::file_not_found) // the file notation db agree with file location
            if ($this->ifRestoreParents($new_status) && $this->fileRestoreFromRecycle($new_status) == '1') // restore the file
                foreach ((count($children = $this->documentContents($status)) > 0 ? ($children) : (count($children = $this->documentContents(self::FILE_STATUS_ARCHIVED)) > 0 ? $children : $this->documentContents(self::FILE_STATUS_AVAILABLE))) as $new_source) // for the folders, consider its children and restore them too, recursively
                    $new_source->fileRecursiveRestoreFromRecycle($new_status) == '1' ? '' : $restore_successful = false;
            else
                $restore_successful = false;
        else
        if ($this->status == $status)
            return self::file_not_exists;

        if ($restore_successful) {
            is_file($dir = StaticMethods::dirRoot() . static::dbNameFileLocation($source, $status)) || @rmdir($dir);
            return '1';
        }
    }

    /**
     * 
     * @return boolean true - folder has children as per db
     */
    public function hasChildren() {
        return is_object(static::childByDirectoryOrFilename($this->id, $this->filename));
    }

    /**
     * 
     * @param string $path drop files recursively
     */
    public static function dropNonModelFiles($path) {
        if (!is_dir($path))
            @unlink($path);
        else {
            foreach (scandir($path) as $name)
                if ($name != '.' && $name != '..')
                    static::dropNonModelFiles(realpath($path . DIRECTORY_SEPARATOR . $name));

            @rmdir($path);
        }
    }

    /**
     * 
     * @param Documents $destination model
     * @return Documents the created new document
     */
    public function fileRecursiveDrop() {
        $drop_successful = true;

        $status = self::FILE_STATUS_DELETED;

        // drop only clients' documents 
        if ($this->file_level >= self::min_client_document_level) {

            // find chidren in the recycle
            if (is_dir($location = StaticMethods::dirRoot() . static::dbNameFileLocation($this->filename, $status)))
                foreach (scandir($location) as $name)
                    if ($name != '.' && $name != '..') {
                        $filename = substr($mod_path = str_replace('\\', '/', $path = realpath($location . DIRECTORY_SEPARATOR . $name)), $pos = stripos($mod_path, $this->filename));

                        if (is_object($new_document = static::byFileNameAndStatus($filename, $status)) || is_object($new_document = static::byFileNameAndStatus($filename, self::FILE_STATUS_ARCHIVED)) || is_object($new_document = static::byFileNameAndStatus($filename, self::FILE_STATUS_AVAILABLE)))
                            $new_document->fileRecursiveDrop() == '1' ? '' : $drop_successful = false;
                        else
                            static::dropNonModelFiles($path);
                    }
        } else
            return self::action_not_allowed;

        return ($this->status != $status && (empty($location) || (is_dir($location) ? (@rmdir($location)) : (is_file($location) ? @unlink($location) : true)))) || ($drop_successful && $this->modelDelete()) ? '1' : false;
    }

    /**
     * 
     * @return boolean true file dropped and model deleted
     */
    public function modelDelete() {
        return ($this->isNewRecord || (!$this->hasChildren() && ($del = $this->delete()) && DocumentsPermissions::dropDocumentPermissions($this->id))) && $this->removeUnlink() && !empty($del) && (Logs::newLog(Logs::drop_document, "Drop document $this->name from " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, static::subDirForStatus(static::FILE_STATUS_DELETED), '0', null, "$this->filename dropped from both database and folder", Logs::success) || true) && (Logs::dropDocumentVersions($this->id, StaticMethods::now()) || true);
    }

    /**
     * 
     * @return boolean true - file / folder dropped
     */
    public function removeUnlink() {
        return (($this->dir_or_file == self::FILE_IS_DIRECTORY && StaticMethods::removeDirectory($this->fileLocation())) || ($this->dir_or_file == self::FILE_IS_DOCUMENT && StaticMethods::fileUnlink($this->fileLocation())));
    }

    /**
     * @param string $selected selected location
     * @return array folders contained in the root institution folder
     */
    public static function rootFileDirectories($selected) {
        return StaticMethods::dirRecursor(StaticMethods::dirRoot(), StaticMethods::dir_recursive, StaticMethods::folders_only, StaticMethods::directory_tree, $selected, []);
    }

    /**
     * 
     * @param string $directory directory location
     * @param string $selected selected location
     * @return array files and folders contained in the `$directory`
     */
    public static function directoryContentTree($directory, $selected) {
        return StaticMethods::dirRecursor($directory, StaticMethods::dir_recursive, StaticMethods::folders_only, StaticMethods::directory_tree, $selected, []);
    }

    /**
     * 
     * @param string $directory directory location
     * @param string $selected selected location
     * @param integer $filesOrFolders files, folders, or both
     * @return array files and/or folders contained in the `$directory`
     */
    public static function directoryContentList($directory, $recursive, $filesOrFolders, $selected) {
        return StaticMethods::dirRecursor($directory, $recursive, $filesOrFolders, StaticMethods::directory_list, $selected, []);
    }

    /**
     * 
     * @param string $filename directory location
     * @param integer $status directory status
     * @param integer $level directory level
     * @return Documents models
     */
    public static function directoryListModels($filename, $status, $level) {
        $documents = [];

        foreach (static::directoryContentList(Documents::fileNameFromTheClient($filename, $status), StaticMethods::dir_unrecursive, StaticMethods::folders_only, null) as $folder)
            is_object($document = Documents::fileLocationIsViewable($level, $folder, $status)) ? array_push($documents, $document) : '';

        return $documents;
    }

    /**
     * 
     * @param string $location file / folder location
     * @return integer file / folder size
     */
    public static function fileSize($location) {
        if (is_file($location))
            return filesize($location);

        $size = '0';

        if (is_dir($location))
            foreach (Documents::directoryContentList($location, StaticMethods::dir_recursive, StaticMethods::files_and_folders, null) as $file)
                is_file($file) ? $size = $size + filesize($file) : '';

        return $size;
    }

    /**
     * 
     * @param integer $level document level
     * @param string $filename file name
     * @param integer $status file status
     * @return boolean|Documents model
     */
    public static function documentByLevelAndFilename($level, $filename, $status) {
        if (StaticMethods::isRootOrSubRootFolder($level))
            return false;

        return static::byFileNameAndStatus(StaticMethods::altDirSeparator(static::fileNameIntoDb($filename), DIRECTORY_SEPARATOR), $status);
    }

    /**
     * 
     * @param integer $level document level
     * @param string $name file name
     * @param integer $status file status
     * @return boolean|Documents true - file is a root sub directory, model - client folder and exists in db, false - invalid location
     */
    public static function fileLocationIsViewable($level, $name, $status) {
        if (in_array(($displayName = basename($name)), StaticMethods::rootSubDirs()))
            return true;

        if (is_object($document = static::documentByLevelAndFilename($level, $name, $status)))
            return $document;

        if ($status != self::FILE_STATUS_AVAILABLE)
            for ($i = 0; $i < 2; $i++) { // only three statuses, one executed above, remaining 2: self::FILE_STATUS_ARCHIVED, self::FILE_STATUS_DELETED
                $name = str_replace(static::subDirNameForStatus($status), static::subDirNameForStatus(++$status), $name);

                if (is_object($document = static::documentByLevelAndFilename($level, $name, $status)))
                    return $document;
            }
    }

    /**
     * 
     * @param string $filename file name as is / should be in db
     * @param integer $status file status
     * @return string file location
     */
    public static function dbIntoFileName($filename, $status) {
        return StaticMethods::altDirSeparator(StaticMethods::rootFolderHardCode(), '/') . static::subDirForStatus($status) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $filename);
    }

    /**
     * 
     * @param string $filename file name as is / should be in db
     * @param integer $status file status
     * @return string file location
     */
    public static function fileNameFromTheClient($filename, $status) {
        return StaticMethods::altDirSeparator(StaticMethods::rootFolderHardCode(), '/') . static::subDirNameForStatus($status) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $filename);
    }

    /**
     * 
     * @param string $filename filename in db
     * @param string $folder foldername in db
     * @param integer $file_status file status
     * @param integer $folder_status folder status
     * @return boolean true - is immediate parent
     */
    public static function isImmediateParent($filename, $folder, $file_status, $folder_status) {
        $expld = explode('/', $filename);

        return $file_status == $folder_status && str_replace("$folder/", null, $filename) == end($expld);
    }

    /**
     * 
     * @param string $filename file location
     * @return string `$filename` modified into db version
     */
    public static function fileNameIntoDb($filename) {
        $rootFolder = StaticMethods::altDirSeparator(StaticMethods::rootFolderHardCode(), '/');

        foreach (StaticMethods::rootSubDirs() as $subDir)
            $filename = str_replace($rootFolder . $subDir, '', $filename);

        return substr(str_replace(DIRECTORY_SEPARATOR, '/', $filename), 1);
    }

    /**
     * 
     * @param string $filename file name as is / should be in db
     * @param integer $status file status
     * @return string file location db version
     */
    public static function dbNameFileLocation($filename, $status) {
        return static::subDirNameForStatus($status) . '/' . $filename;
    }

    /**
     * 
     * @param integer $status file status
     * @return string respective server folder name
     */
    public static function subDirNameForStatus($status) {
        return $status == self::FILE_STATUS_AVAILABLE ? (self::regular_folder) : ($status == self::FILE_STATUS_ARCHIVED ? (self::archive_folder) : ($status == self::FILE_STATUS_DELETED ? self::recycle_folder : ''));
    }

    /**
     * 
     * @param integer $status file status
     * @return string subroot file location
     */
    public static function subRootLocation($status) {
        return StaticMethods::altDirSeparator(StaticMethods::rootFolderHardCode(), '/') . self::subDirNameForStatus($status);
    }

    /**
     * 
     * @param integer $status file status
     * @return string respective client folder name
     */
    public static function subDirForStatus($status) {
        return $status == self::FILE_STATUS_AVAILABLE ? (self::regular_name) : ($status == self::FILE_STATUS_ARCHIVED ? (self::archive_name) : ($status == self::FILE_STATUS_DELETED ? self::recycle_name : ''));
    }

    /**
     * 
     * @param integer $level document level
     * @param string $filename document location
     * @return string document location notation shorter version of `$filename`
     */
    public static function fileShortFileName($level, $filename) {
        return $level < self::min_client_document_level ? ('') : (StaticMethods::isRootOrSubRootFolder($level) ? basename($filename) : static::fileNameIntoDb($filename));
    }

    /**
     * 
     * @return array document statuses
     */
    public static function documentStatuses() {
        return ["'" . self::FILE_STATUS_AVAILABLE . "'", "'" . self::FILE_STATUS_ARCHIVED . "'", "'" . self::FILE_STATUS_DELETED . "'"];
    }

    /**
     * 
     * @param integer $level document level
     * @param string $name file name
     * @param integer $status file status
     * @return integer file new status
     */
    public static function subDirFileStatus($level, $name, $status) {
        if ($level > self::min_sub_root_document_level)
            return $status;

        if (in_array(($displayName = basename($name)), StaticMethods::rootSubDirs()))
            return $displayName == self::regular_folder ? (self::FILE_STATUS_AVAILABLE) :
                    ($displayName == self::archive_folder ? self::FILE_STATUS_ARCHIVED : self::FILE_STATUS_DELETED);
    }

    /**
     * 
     * @param string $name file name
     * @param string $document_name file name if in db
     * @return string name to display
     */
    public static function fileNameToDisplay($name, $document_name) {
        if (in_array(($displayName = basename($name)), StaticMethods::rootSubDirs()))
            return $displayName == self::regular_folder ? (self::regular_name) :
                    ($displayName == self::archive_folder ? self::archive_name : self::recycle_name);

        return empty($document_name) ? $displayName : $document_name;
    }

    /**
     * 
     * @param integer $level document level
     * @return boolean document can have custom menu options
     */
    public static function hasCustomMenu($level) {
        return $level > self::min_root_document_level;
    }

    /**
     * 
     * @param integer $level level of file
     *  @param integer $status status of file
     * @return boolean true - folder can accept files 
     */
    public static function folderCanReceiveFilesFromClient($level, $status) {
        return $status == self::FILE_STATUS_AVAILABLE && !in_array($level, [self::min_root_document_level, self::min_sub_root_document_level]);
    }

    /**
     * 
     * @param string $filename file location
     * @return boolean true - folder can be created sub-folders into
     */
    public static function folderCanBeAddedFolder($filename) {
        $regular = StaticMethods::altDirSeparator(StaticMethods::dirSubRoot(StaticMethods::regular_folder), '/');

        return is_dir($filename) && (stripos($filename, str_replace('\frontend\\..\\', '\\', $regular)) > -1 || stripos(str_replace('\frontend\\..\\', '\\', $regular), $filename) > -1);
    }

    /**
     * 
     * @param array $dir_contents folder and file paths
     * @param integer $level parent folder level
     * @param integer $status documents status
     * @param integer $user user id
     * @return array folders, files, privileges
     */
    public static function modelDocumentNavigationPrivileges($dir_contents, $level, $status, $user) {

        $preferredRights = $new_file_contents = $new_dir_contents = $rights = $files = $folders = [];

        if (is_object($userModel = User::returnUser($user)))
            foreach ($dir_contents as $path)
                if (is_object($document = Documents::fileLocationIsViewable($level, $path, $status)) &&
                        in_array($right = $document->desiredUserPrivilegeToDocument($user, null, false, true, $iko = !empty($rights[$document->directory]), $iko ? $rights[$document->directory] : self::file_deny, false), [self::file_read, self::file_write, self::file_alter]) &&
                        $document->documentCanBeOpenedByUser($user, $preferredRight = $document->userPreferredDocumentPrivilege($user, false, true, $iko2 = !empty($preferredRights[$document->directory]), $iko2 ? $preferredRights[$document->directory] : self::file_deny), $is_admin = isset($is_admin) ? $is_admin : $userModel->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]))
                ) {
                    if (is_dir($path)) {
                        $rights[$document->id] = $right;
                        $preferredRights[$document->id] = $preferredRight;
                        array_push($folders, $document);
                        $new_dir_contents[$document->id] = $path;
                    } else
                    if (is_file($path)) {
                        $iko ? '' : $rights[$document->directory] = $right;
                        $iko2 ? '' : $preferredRights[$document->directory] = $preferredRight;
                        array_push($files, $document);
                        $new_file_contents[$document->id] = $path;
                    }
                }

        return [$folders, $files, $rights, $new_dir_contents, $new_file_contents, $preferredRights, !empty($is_admin)];
    }

    /**
     * launch root document folders
     */
    public static function launchDirectories() {
        if (!file_exists($fldr = substr($folder = StaticMethods::dirRoot(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = $folder . static::subDirNameForStatus(self::FILE_STATUS_AVAILABLE)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = $folder . static::subDirNameForStatus(self::FILE_STATUS_ARCHIVED)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = $folder . static::subDirNameForStatus(self::FILE_STATUS_DELETED)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = substr($folder = StaticMethods::downloadsFolder(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = substr($folder = StaticMethods::mailZipsFolder(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = substr($folder = StaticMethods::slidesFolder(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = substr($folder = StaticMethods::versionsFolder(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);

        if (!file_exists($fldr = substr($folder = StaticMethods::uploadsFolder(), 0, strlen($folder) - 1)))
            mkdir($fldr, 0777, false);
    }

    /**
     * @param array $file_types array(0 - directory, 1 - file)
     * @param integer $no number of files
     * @return array document actions in an order
     */
    public static function documentActionsOrder($file_types, $no) {
        $file_is_document = count($file_types) == 1 && in_array(self::FILE_IS_DOCUMENT, $file_types);
        $one_file = $no == 1 && $file_is_document;
        $file_is_folder = count($file_types) == 1 && in_array(self::FILE_IS_DIRECTORY, $file_types);
        $one_folder = $no == 1 && $file_is_folder;
        $many_items = count($file_types) > 1;
        $one_item = $one_file || $one_folder;



        return
                $no < 1 || empty($file_types) ? []//if no file selection
                :
                //if file selection
                [
            0 => $one_item ? self::open : '',
            1 => $one_file ? self::open_for_update : '', //only one document can be opened for update at a time
            2 => $one_file ? self::update : '', //only documents can be updated
            3 => self::copy, // multiple items at a time
            4 => $one_folder ? self::paste : '', //only one directory can be pasted into at a time
            5 => self::duplicate, // multiple items at a time
            6 => $one_item ? self::rename : '', // one item at a time
            7 => self::move, // multiple items at a time
            8 => self::archive, // multiple items at a time
            9 => self::delete, // multiple items at a time
            10 => self::restore, // multiple items at a time
            11 => self::drop, // multiple items at a time
            12 => $one_folder ? self::upload : '', // can only upload into one folder at a time
            13 => self::download, // multiple items at a time
            14 => self::share, // multiple items at a time
            15 => self::share_for_update, // multiple items at a time
            16 => self::send, // multiple items at a time
            17 => $one_item ? self::properties : '', // one item at a time
                ]
        ;
    }

    /**
     * 
     * @param string $right read, write, alter
     * @param array $file_types file types = array(0 - directory, 1 - file)
     * @param integer $no number of files
     * @return array document desired actions
     */
    public static function documentDesiredActions($right, $file_types, $no) {
        $all_actions = static::documentActionsOrder($file_types, $no);

        $ask_actions = ksort($right == self::file_alter ? (static::documentAlterActions()) : ($right == self::file_write ? static::documentWriteActions() : static::documentReadActions()));

        foreach ($ask_actions as $action)
            if (!empty($all_actions[$action]))
                $actions[$action] = ucwords($all_actions[$action]);

        return empty($actions) ? [] : $actions;
    }

    /**
     * 
     * @param integer $file_type 0 - directory, 1 - file
     * @return array actions granted to read document
     */
    public static function documentReadActions() {
        return [0, 15, 17];
    }

    /**
     * 
     * @param integer $file_type 0 - directory, 1 - file
     * @return array actions granted to write document
     */
    public static function documentWriteActions() {
        return [0, 1, 2, 12, 13, 15, 17];
    }

    /**
     * 
     * @return array actions granted to alter document
     */
    public static function documentAlterActions() {
        return [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
    }

}
