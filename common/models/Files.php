<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property integer $sub_sub_compartment
 * @property integer $shelf
 * @property integer $drawer
 * @property integer $batch
 * @property integer $folder
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Files extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%files}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::files;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'batch', 'folder', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'batch', 'folder', 'name', 'reference_no', 'location', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'min' => 5, 'max' => 40],
            [['name', 'location', 'description'], 'notNumerical'],
            [['reference_no'], 'string', 'min' => 5, 'max' => 15],
            [['location'], 'string', 'max' => 128],
            [['name', 'reference_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'store' => Yii::t('app', 'Store'),
            'compartment' => Yii::t('app', 'Compartment'),
            'sub_compartment' => Yii::t('app', 'Sub Compartment'),
            'sub_sub_compartment' => Yii::t('app', 'Sub Sub Compartment'),
            'shelf' => Yii::t('app', 'Shelf'),
            'drawer' => Yii::t('app', 'Drawer'),
            'batch' => Yii::t('app', 'Batch'),
            'folder' => Yii::t('app', 'Folder'),
            'name' => Yii::t('app', 'Name'),
            'reference_no' => Yii::t('app', 'Reference No.'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\FilesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\FilesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk file id
     * @return Files model
     */
    public static function returnFile($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Files models
     */
    public static function allFiles() {
        return static::find()->allFiles();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return Files models
     */
    public static function searchFiles($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $whereStringAMust, $oneOrAll) {
        return static::find()->searchFiles($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of files
     */
    public static function countFiles($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $whereStringAMust) {
        foreach (static::find()->countFiles($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $whereStringAMust) as $file)
            return $file->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Files model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @return Files model
     */
    public static function newFile($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder) {
        $model = new Files;

        $model->store = $store;

        $model->compartment = $compartment;

        $model->sub_compartment = $subcompartment;

        $model->sub_sub_compartment = $subsubcompartment;

        $model->shelf = $shelf;

        $model->drawer = $drawer;

        $model->batch = $batch;

        $model->folder = $folder;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id file id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @return Files model
     */
    public static function fileToLoad($id, $store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder) {
        return is_object($model = static::returnFile($id)) ? $model : static::newFile($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord) {
            $this->created_at = StaticMethods::now();
            $isNew = true;
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
            $previous = static::returnFile($this->id);
        }

        return (Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]) || $this->userSubjectiveRight(Yii::$app->user->identity->id) == FilePermissions::write) &&
                $this->save() &&
                ((!empty($isNew) && Logs::newLog(Logs::create_store, "Created store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, '', '', "$this->level,$this->id", $this->name, null, Logs::success)) || true) &&
                ((empty($isNew) && (($new = "$this->reference_no,$this->name,$this->location,$this->description") != ($old = "$previous->reference_no,$previous->name,$previous->location,$previous->description")) && Logs::newLog(Logs::update_store, "Updated store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $old, "$this->level,$this->id", $new, null, Logs::success)) || true);
    }

    /**
     * 
     * @return FilePermissions model
     */
    public function permission() {
        return $this->isNewRecord ? Folders::returnFolder($this->folder)->permission() : FilePermissions::byStoreLevelAndId(StoreLevels::files, $this->id);
    }

    /**
     * 
     * @param integer $user user id
     * @return string user right to file
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Folders::returnFolder($this->folder)->userRight($user);
    }

    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to file
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Folders::returnFolder($this->folder)->userSubjectiveRight($user);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent folder
     * @return string user subjective logical right to file
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Folders::returnFolder($this->folder)->userSubjectiveRight($user) : $parentRight) : Folders::returnFolder($this->folder)->userSubjectiveLogicalRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @return boolean true - files moved
     */
    public static function filesToMove($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder) {
        foreach (static::searchFiles(null, null, null, null, null, null, null, $folder, true, StoreLevels::all) as $file)
            if (!$file->moveFile($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder))
                return false;

        return true;
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @return boolean true - file moved
     */
    public function moveFile($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder) {
        $previous = static::returnFile($this->id);

        $old = "$previous->store,$previous->compartment,$previous->sub_compartment,$previous->sub_sub_compartment,$previous->shelf,$previous->drawer,$previous->batch,$previous->folder";

        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;

        $this->sub_sub_compartment = $subsubcompartment;

        $this->shelf = $shelf;

        $this->drawer = $drawer;

        $this->batch = $batch;

        $this->folder = $folder;

        $new = "$this->store,$this->compartment,$this->sub_compartment,$this->sub_sub_compartment,$this->shelf,$this->drawer,$this->batch,$this->folder";

        return $this->modelSave() && (Logs::newLog(Logs::move_store, "Moved store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $old, "$this->level,$this->id", $new, null, Logs::success) || true);
    }

    /**
     * 
     * @return boolean true - file deleted
     */
    public function deleteFile() {
        return (Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]) || $this->userSubjectiveRight(Yii::$app->user->identity->id) == FilePermissions::write) && $this->delete() && (Logs::newLog(Logs::delete_store, "Deleted store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $this->name, null, null, null, Logs::success) || true);
    }

}
