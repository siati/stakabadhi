<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 */
class Countries extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'code'], 'required'],
            [['code'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Country Name'),
            'code' => Yii::t('app', 'Call Code'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\CountriesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\CountriesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk country id
     * @return Countries model
     */
    public static function returnCountry($pk) {
        return static::findByPk($pk);
    }
    
    /**
     * 
     * @return Countries models
     */
    public static function allCountries() {
        return static::find()->allCountries();
    }

}
