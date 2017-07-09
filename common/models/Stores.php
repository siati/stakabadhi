<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%stores}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 */
class Stores extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%stores}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'reference_no', 'location', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_by'], 'integer'],
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
     * @return \common\activeQueries\StoresQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\StoresQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk store id
     * @return Stores model
     */
    public static function returnStore($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Stores models
     */
    public static function allStores() {
        return static::find()->allStores();
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Stores model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * 
     * @return Stores model
     */
    public static function newStore() {
        $model = new Stores;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id store id
     * @return Stores model
     */
    public static function storeToLoad($id) {
        return is_object($model = static::returnStore($id)) ? $model : static::newStore();
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

}
