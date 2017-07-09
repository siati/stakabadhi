<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%compartments}}".
 *
 * @property integer $id
 * @property integer $store
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 */
class Compartments extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%compartments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'created_by'], 'integer'],
            [['store', 'name', 'reference_no', 'location', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
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
            'name' => Yii::t('app', 'Name'),
            'reference_no' => Yii::t('app', 'Reference No.'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\CompartmentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\CompartmentsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk compartment id
     * @return Compartments model
     */
    public static function returnCompartment($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Compartments models
     */
    public static function allCompartments() {
        return static::find()->allCompartments();
    }

    /**
     * 
     * @param integer $store store id
     * @param boolean $whereStringAMust force where clause
     * @return Compartments models
     */
    public static function compartmentsForStore($store, $whereStringAMust) {
        return static::find()->compartmentsForStore($store, $whereStringAMust);
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Compartments model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @return Compartments model
     */
    public static function newCompartment($store) {
        $model = new Compartments;

        $model->store = $store;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id compartment id
     * @param integer $store store id
     * @return Compartments model
     */
    public static function CompartmentToLoad($id, $store) {
        return is_object($model = static::returnCompartment($id)) ? $model : static::newCompartment($store);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();

        return $this->save();
    }

    /**
     * 
     * @param integer $store store id
     * @return boolean true - compartment moved
     */
    public function moveCompartment($store) {

        $this->store = $store;

        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && SubCompartments::subcompartmentsToMove($this->store, $this->id)) {

                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }

}
