<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%folders}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property integer $sub_sub_compartment
 * @property integer $shelf
 * @property integer $drawer
 * @property integer $batch
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Folders extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%folders}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'batch', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'batch', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @return \common\activeQueries\FoldersQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\FoldersQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk folder id
     * @return Folders model
     */
    public static function returnFolder($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Folders models
     */
    public static function allFolders() {
        return static::find()->allFolders();
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
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return Folders models
     */
    public static function searchFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust, $oneOrAll) {
        return static::find()->searchFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust, $oneOrAll);
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
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of folders
     */
    public static function countFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust) {
        foreach (static::find()->countFolders($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $whereStringAMust) as $folder)
            return $folder->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Folders model
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
     * @return Folders model
     */
    public static function newFolder($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch) {
        $model = new Folders;

        $model->store = $store;

        $model->compartment = $compartment;

        $model->sub_compartment = $subcompartment;

        $model->sub_sub_compartment = $subsubcompartment;

        $model->shelf = $shelf;

        $model->drawer = $drawer;

        $model->batch = $batch;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id folder id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @return Folders model
     */
    public static function folderToLoad($id, $store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch) {
        return is_object($model = static::returnFolder($id)) ? $model : static::newFolder($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();
        else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        return $this->save();
    }
    
    /**
     * 
     * @return FilePermissions model
     */
    public function permission() {
        return FilePermissions::byStoreLevelAndId(StoreLevels::folders, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to folder
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Batches::returnBatch($this->batch)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to folder
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Batches::returnBatch($this->batch)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent batch
     * @return string user subjective logical right to folder
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Batches::returnBatch($this->batch)->userSubjectiveRight($user) : $parentRight) : Batches::returnBatch($this->batch)->userSubjectiveLogicalRight($user, $parentRight);
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
     * @return boolean true - folders moved
     */
    public static function foldersToMove($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch) {
        foreach (static::searchFolders(null, null, null, null, null, null, $batch, true, StoreLevels::all) as $folder)
            if (!$folder->moveFolder($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch))
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
     * @return boolean true - folder moved
     */
    public function moveFolder($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch) {
        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;

        $this->sub_sub_compartment = $subsubcompartment;

        $this->shelf = $shelf;

        $this->drawer = $drawer;

        $this->batch = $batch;
        
        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && Files::filesToMove($this->store, $this->compartment, $this->sub_compartment, $this->sub_sub_compartment, $this->shelf, $this->drawer, $this->batch, $this->id)) {

                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }
    
    /**
     * 
     * @return boolean true - folder is deletable
     */
    public function isDeletable() {
        return !is_object(Files::searchFiles(null, null, null, null, null, null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - folder deleted
     */
    public function deleteFolder() {
        return $this->isDeletable() && $this->delete();
    }

}
