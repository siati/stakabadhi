<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shelves}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property integer $sub_sub_compartment
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Shelves extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shelves}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @return \common\activeQueries\ShelvesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\ShelvesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk shelf id
     * @return Shelves model
     */
    public static function returnShelf($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Shelves models
     */
    public static function allShelves() {
        return static::find()->allShelves();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return Shelves models
     */
    public static function searchShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust, $oneOrAll) {
        return static::find()->searchShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of shelves
     */
    public static function countShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust) {
        foreach (static::find()->countShelves($store, $compartment, $subcompartment, $subsubcompartment, $whereStringAMust) as $shelf)
            return $shelf->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Shelves model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @return Shelves model
     */
    public static function newShelf($store, $compartment, $subcompartment, $subsubcompartment) {
        $model = new Shelves;
        
        $model->store = $store;
        
        $model->compartment = $compartment;
        
        $model->sub_compartment = $subcompartment;
        
        $model->sub_sub_compartment = $subsubcompartment;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id shelf id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @return Shelves model
     */
    public static function shelfToLoad($id, $store, $compartment, $subcompartment, $subsubcompartment) {
        return is_object($model = static::returnShelf($id)) ? $model : static::newShelf($store, $compartment, $subcompartment, $subsubcompartment);
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
        return FilePermissions::byStoreLevelAndId(StoreLevels::shelves, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to shelf
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) ? $permission->userRight($user) : SubSubCompartments::returnSubsubcompartment($this->sub_sub_compartment)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to shelf
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) ? $permission->userSubjectiveRight($user) : SubSubCompartments::returnSubsubcompartment($this->sub_sub_compartment)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent sub-sub-compartment
     * @return string user subjective logical right to shelf
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? SubSubCompartments::returnSubsubcompartment($this->sub_sub_compartment)->userSubjectiveRight($user) : $parentRight) : SubSubCompartments::returnSubsubcompartment($this->sub_sub_compartment)->userSubjectiveRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @return boolean true - shelves moved
     */
    public static function shelvesToMove($store, $compartment, $subcompartment, $subsubcompartment) {
        foreach (static::searchShelves(null, null, null, $subsubcompartment, true, StoreLevels::all) as $shelf)
            if (!$shelf->moveShelf($store, $compartment, $subcompartment, $subsubcompartment))
                return false;

        return true;
    }
    
    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @return boolean true - shelf moved
     */
    public function moveShelf($store, $compartment, $subcompartment, $subsubcompartment) {
        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;

        $this->sub_sub_compartment = $subsubcompartment;
        
        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && Drawers::drawersToMove($this->store, $this->compartment, $this->sub_compartment, $this->sub_sub_compartment, $this->id)) {

                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }
    
    /**
     * 
     * @return boolean true - shelf is deletable
     */
    public function isDeletable() {
        return !is_object(Drawers::searchDrawers(null, null, null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - shelf deleted
     */
    public function deleteShelf() {
        return $this->isDeletable() && $this->delete();
    }

}
