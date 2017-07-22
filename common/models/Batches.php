<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%batches}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property integer $sub_sub_compartment
 * @property integer $shelf
 * @property integer $drawer
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Batches extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%batches}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::batches;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'drawer', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @return \common\activeQueries\BatchesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\BatchesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk batch id
     * @return Batches model
     */
    public static function returnBatch($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Batches models
     */
    public static function allBatches() {
        return static::find()->allBatches();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return Batches models
     */
    public static function searchBatches($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $whereStringAMust, $oneOrAll) {
        return static::find()->searchBatches($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of batches
     */
    public static function countBatches($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $whereStringAMust) {
        foreach (static::find()->countBatches($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $whereStringAMust) as $batch)
            return $batch->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Batches model
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
     * @return Batches model
     */
    public static function newBatch($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer) {
        $model = new Batches;
        
        $model->store = $store;
        
        $model->compartment = $compartment;
        
        $model->sub_compartment = $subcompartment;
        
        $model->sub_sub_compartment = $subsubcompartment;
        
        $model->shelf = $shelf;
        
        $model->drawer = $drawer;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id batch id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @return Batches model
     */
    public static function batchToLoad($id, $store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer) {
        return is_object($model = static::returnBatch($id)) ? $model : static::newBatch($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer);
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
        return FilePermissions::byStoreLevelAndId(StoreLevels::batches, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to batch
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Drawers::returnDrawer($this->drawer)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to batch
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Drawers::returnDrawer($this->drawer)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent drawer
     * @return string user subjective logical right to batch
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Drawers::returnDrawer($this->drawer)->userSubjectiveRight($user) : $parentRight) : Drawers::returnDrawer($this->drawer)->userSubjectiveLogicalRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @return boolean true - batches moved
     */
    public static function batchesToMove($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer) {
        foreach (static::searchBatches(null, null, null, null, null, $drawer, true, StoreLevels::all) as $batch)
            if (!$batch->moveBatch($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer))
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
     * @return boolean true - batch moved
     */
    public function moveBatch($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer) {
        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;

        $this->sub_sub_compartment = $subsubcompartment;

        $this->shelf = $shelf;

        $this->drawer = $drawer;
        
        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && Folders::foldersToMove($this->store, $this->compartment, $this->sub_compartment, $this->sub_sub_compartment, $this->shelf, $this->drawer, $this->id)) {

                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }
    
    /**
     * 
     * @return boolean true - batch is deletable
     */
    public function isDeletable() {
        return !is_object(Folders::searchFolders(null, null, null, null, null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - batch deleted
     */
    public function deleteBatch() {
        return $this->isDeletable() && $this->delete();
    }

}
