<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sub_compartments}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class SubCompartments extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%sub_compartments}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::subcompartments;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @return \common\activeQueries\SubCompartmentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SubCompartmentsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk sub-compartment id
     * @return SubCompartments model
     */
    public static function returnSubcompartment($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return SubCompartments models
     */
    public static function allSubcompartments() {
        return static::find()->allSubcompartments();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return SubCompartments models
     */
    public static function searchSubcompartments($store, $compartment, $whereStringAMust, $oneOrAll) {
        return static::find()->searchSubcompartments($store, $compartment, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of sub-compartments
     */
    public static function countSubcompartments($store, $compartment, $whereStringAMust) {
        foreach (static::find()->countSubcompartments($store, $compartment, $whereStringAMust) as $subcompartment)
            return $subcompartment->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return SubCompartments model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @return SubCompartments model
     */
    public static function newSubcompartment($store, $compartment) {
        $model = new SubCompartments;

        $model->store = $store;

        $model->compartment = $compartment;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id sub-compartment id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @return SubCompartments model
     */
    public static function subcompartmentToLoad($id, $store, $compartment) {
        return is_object($model = static::returnSubcompartment($id)) ? $model : static::newSubcompartment($store, $compartment);
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
        return FilePermissions::byStoreLevelAndId(StoreLevels::subcompartments, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to sub-compartment
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Compartments::returnCompartment($this->compartment)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to sub-compartment
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Compartments::returnCompartment($this->compartment)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent compartment
     * @return string user subjective logical right to sub-compartment
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Compartments::returnCompartment($this->compartment)->userSubjectiveRight($user) : $parentRight) : Compartments::returnCompartment($this->compartment)->userSubjectiveLogicalRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @return boolean true - sub-compartments moved
     */
    public static function subcompartmentsToMove($store, $compartment) {
        foreach (static::searchSubcompartments(null, $compartment, true, StoreLevels::all) as $subcompartment)
            if (!$subcompartment->moveSubcompartment($store, $compartment))
                return false;

        return true;
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @return boolean true - sub-compartment moved
     */
    public function moveSubcompartment($store, $compartment) {
        $this->store = $store;

        $this->compartment = $compartment;

        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && SubSubCompartments::subsubcompartmentsToMove($this->store, $this->compartment, $this->id)) {

                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }
    
    /**
     * 
     * @return boolean true - sub-compartment is deletable
     */
    public function isDeletable() {
        return !is_object(SubSubCompartments::searchSubsubcompartments(null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - sub-compartment deleted
     */
    public function deleteSubcompartment() {
        return $this->isDeletable() && $this->delete();
    }

}
