<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property integer $created_by
 * @property string $author_name
 * @property string $created_at
 * @property string $session_id
 * @property string $session_ip
 * @property string $origin_id
 * @property string $origin_value
 * @property string $destination_id
 * @property string $destination_value
 * @property string $further_narration
 * @property string $status
 * @property string $available
 * @property integer $updated_by
 * @property string $updated_at
 */
class Logs extends \yii\db\ActiveRecord {

    const success = 'success';
    const failed = 'failed';
    const available = 'yes';
    const not_available = 'no';
    const login = 'User Login';
    const logout = 'User Logout';
    const new_password_reset_token = 'New Password Reset Token';
    const new_password_reset_token_by_self = 'New Password Reset Token By Self';
    const new_password_reset_token_by_admin = 'New Password Reset Token By Admin';
    const send_password_reset_token = 'Send Password Reset Token';
    const send_password_reset_token_by_self = 'Send Password Reset Token By Self';
    const send_password_reset_token_by_admin = 'Send Password Reset Token By Admin';
    const remove_password_reset_token_at_login = 'Removed Password Reset Token At Login';
    const password_reset = 'Password Reset';
    const change_user_account_status = 'Change User Account Status';
    const update_user_profile = 'Update User Profile';
    const password_reset_by_self = 'Password Reset By Self';
    const password_reset_by_admin = 'Password Reset By Admin';
    const new_document = 'New Document';
    const copy_document = 'Copy Document';
    const move_document = 'Move Document';
    const archive_document = 'Archive Document';
    const recycle_document = 'Recycle Document';
    const drop_document = 'Drop Document';
    const update_document_description = 'Update Document Description';
    const rename_document = 'Rename Document';
    const document_movable_updatable_deletable = 'Document Movable Updatable Deletable';
    const restore_from_archive = 'Restore Document From Archive';
    const restore_to_archive = 'Restore Document From Recycle To Archive';
    const restore_to_documents = 'Restore Document From Recycle To Documents';
    const lock_document = 'Lock Document For Update';
    const unlock_document = 'Unlock Document';
    const new_version = 'Document Update';
    const insert_into_history = 'Insert Into History';
    const revert_from_history = 'Revert From History';
    const document_version_not_exists = 'Document Version Does Not Exist';
    const document_download = 'Download Document';
    const send_documents_by_mail = 'Send Documents By Mail';
    const zip_and_export = 'Zip And Download Documents';
    const document_version_download = 'Download Version Of Document';
    const document_version_delete = 'Delete Version Of Document';
    const create_new_mail_contact = 'Create New Mail Contact';
    const update_mail_contact = 'Update Mail Contact';
    const delete_mail_contact = 'Delete Mail Contact';
    const create_group = 'Create Group';
    const update_group = 'Update Group';
    const update_group_access_to_folder = 'Update Group Access To Folder';
    const activate_group = 'Group Active Status';
    const delete_group = 'Delete Group';
    const give_user_group_privilege = 'Add User To Group';
    const remove_user_from_group = 'Remove User From Group';
    const drop_document_permission = 'Delete Document Permission';
    const create_storage_level = 'Create Storage Level';
    const update_storage_level = 'Update Storage Level';
    const create_store = 'Create Store';
    const update_store = 'Update Store';
    const move_store = 'Move Store';
    const delete_store = 'Delete Store';
    const update_store_rigts = 'Update Store Rights';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'description', 'created_by', 'author_name'], 'required'],
            [['description', 'origin_id', 'origin_value', 'destination_id', 'destination_value', 'further_narration', 'status'], 'string'],
            [['created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['origin_id', 'destination_id'], 'string', 'max' => 15],
            [['type', 'author_name', 'session_id', 'session_ip'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Log Type'),
            'description' => Yii::t('app', 'Log Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'author_name' => Yii::t('app', 'Author Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'session_id' => Yii::t('app', 'Session ID'),
            'session_ip' => Yii::t('app', 'Session IP'),
            'origin_id' => Yii::t('app', 'Origin ID'),
            'origin_value' => Yii::t('app', 'Original Value'),
            'destination_id' => Yii::t('app', 'Destination ID'),
            'destination_value' => Yii::t('app', 'Final Value'),
            'further_narration' => Yii::t('app', 'Further Narration'),
            'status' => Yii::t('app', 'Status'),
            'available' => Yii::t('app', 'Extra Attributes Available'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\LogsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\LogsQuery(get_called_class());
    }

    /**
     * 
     * @param string $type event (name / type)
     * @param string $description event description
     * @param integer $created_by involved user id
     * @param string $author_name involved user name
     * @param string $session_id session id
     * @param string $session_ip session ip
     * @param integer $origin_id origin item id
     * @param string $origin_value origin item value
     * @param integer $destination_id destination item id
     * @param string $destination_value destination item value
     * @param string $further_narration further event description
     * @param boolean $status event status false - failed, true - success
     * @return boolean|Logs true - the created log
     */
    public static function newLog($type, $description, $created_by, $author_name, $session_id, $session_ip, $origin_id, $origin_value, $destination_id, $destination_value, $further_narration, $status) {
        $model = new Logs;

        $model->type = $type;
        $model->description = $description;
        $model->created_by = $created_by;
        $model->author_name = $author_name;
        $model->session_id = $session_id;
        $model->session_ip = $session_ip;
        $model->origin_id = $origin_id;
        $model->origin_value = $origin_value;
        $model->destination_id = $destination_id;
        $model->destination_value = $destination_value;
        $model->further_narration = $further_narration;
        $model->status = $status == self::success || (is_bool($status) === true) ? self::success : self::failed;
        $model->created_at = StaticMethods::now();
        $model->available = self::available;

        return $model->save(false) ? $model : false;
    }

    /**
     * 
     * @param integer $pk log id
     * @return Logs model
     */
    public static function returnLog($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param integer $document_id document id
     * @return boolean true - document has version history
     */
    public static function documentHasAVersion($document_id) {
        return is_object(static::find()->documentHasAVersion($document_id));
    }

    /**
     * 
     * @param integer $document_id document id
     * @return Logs models
     */
    public static function documentVersions($document_id) {
        return static::find()->documentVersions($document_id);
    }

    /**
     * 
     * @param integer $document_id document id
     * @param string $since earliest version date desired
     * @param string $till latest version date desired
     * @param boolean $ascDesc true - order by created_at ascending
     * @return Logs models
     */
    public static function documentVersionsDetweenDates($document_id, $since, $till, $ascDesc) {
        return static::find()->documentVersionsDetweenDates($document_id, $since, $till, $ascDesc);
    }

    /**
     * 
     * @param integer $filename document filename
     * @return boolean true - document has version history
     */
    public static function documentIsInVersionHistory($filename) {
        return is_object(static::find()->documentIsAVersion(substr($filename, strripos($filename, '/') + 1)));
    }

    /**
     * 
     * @param integer $filename document filename
     * @return boolean true - version is current
     */
    public function documentVersionIsCurrent($filename) {
        return substr($filename, strripos($filename, '/') + 1) == $this->further_narration;
    }

    /**
     * 
     * @return string location of version file
     */
    public function documentVersionLocation() {
        return StaticMethods::versionsFolder() . $this->further_narration;
    }

    /**
     * 
     * @return string download location of version file
     */
    public function documentVersionDownloadLocation() {
        return StaticMethods::downloadsFolder() . $this->further_narration;
    }

    /**
     * 
     * @return string location link of version file
     */
    public function documentVersionLocationUrl() {
        return StaticMethods::versionsFolderUrl() . $this->further_narration;
    }

    /**
     * 
     * @return string download location link of version file
     */
    public function documentVersionDownloadLocationUrl() {
        return StaticMethods::downloadsFolderUrl() . $this->further_narration;
    }

    /**
     * 
     * @return string extension of document version
     */
    public function documentVersionExtension() {
        return substr($this->further_narration, strripos($this->further_narration, '.') + 1);
    }

    /**
     * 
     * @return string file type extension of document version
     */
    public function documentVersionType() {
        return StaticMethods::documentType($extension = $this->documentVersionExtension()) . ", $extension";
    }

    /**
     * 
     * @param boolean $location true - return icon location, else icon url
     * @return string icon location or url
     */
    public function documentVersionIcon($location) {
        return StaticMethods::documentVersionIcon($this->documentVersionExtension(), $location);
    }

    /**
     * 
     * @return string file size
     */
    public function documentVersionSize() {
        $size = StaticMethods::fileSizeConverter(filesize($this->documentVersionLocation()));

        return "$size[0] $size[1]";
    }

    /**
     * 
     * @return string name of log author
     */
    public function logAuthorName() {
        return User::returnUser($this->created_by)->name;
    }

    /**
     * @param integer $status document status
     * @return string link from where to download a version
     */
    public function downloadDocumentVersion($status) {
        if ($this->status == self::success && $this->available == self::available && is_file($source = $this->documentVersionLocation())) {
            $document = Documents::returnDocument($this->destination_id);

            return ($this->documentVersionIsCurrent(empty($document->filename) ? '' : $document->filename) && ($url = $document->downloadFile($status))) || (copy($source, $destination = $this->documentVersionDownloadLocation()) && static::newLog(self::document_version_download, "Dowloaded a version of document $document->name, id $document->id in " . Documents::tableName() . "from " . static::tableName() . " dated $this->created_at", Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->further_narration, $this->id, substr($destination, strripos($destination, StaticMethods::downloads_folder)), substr($url = $this->documentVersionDownloadLocationUrl(), strripos($url, StaticMethods::downloads_folder)), self::success)) ? $url : '';
        }
    }

    /**
     * 
     * @param integer $document_id document id
     * @param string $till latest version date desired
     */
    public static function dropDocumentVersions($document_id, $till) {
        foreach (static::documentVersionsDetweenDates($document_id, null, $till, true) as $version)
            $version->dropDocumentVersion();
    }

    /**
     * drop a document version file
     */
    public function dropDocumentVersion() {
        if ($this->status == self::success && $this->available == self::available && (!is_object($document = Documents::returnDocument($this->destination_id)) || !$this->documentVersionIsCurrent($document->filename))) {
            @unlink($this->documentVersionLocation());
            $this->available != self::not_available ? $this->available = self::not_available : '';
            empty($this->updated_by) ? $this->updated_by = Yii::$app->user->identity->id : '';
            empty($this->updated_at) ? $this->updated_at = StaticMethods::now() : '';

            if ($this->update(false, ['available', 'updated_by', 'updated_at']) && ($log = static::newLog(self::document_version_delete, is_object($document) ? "Deleted a version of document $document->name, id $document->id in " : "Deleted a version of document $this->further_narration, id $this->destination_id in " . (Documents::tableName() . "from " . static::tableName() . " dated $this->created_at"), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $this->further_narration, null, null, null, self::success))) {
                $log->available = $this->available;
                $log->update(false, ['available']);
            }
        }
    }

}
