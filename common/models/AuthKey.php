<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth_key}}".
 *
 * @property string $auth_key
 */
class AuthKey extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%auth_key}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['auth_key'], 'required'],
            [['auth_key'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\AuthKeyQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\AuthKeyQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk auth key
     * @return AuthKey model
     */
    public static function returnKey($pk) {
        return static::findByPk($pk);
    }
    
    /**
     * 
     * @param string $auth_key auth key
     * @return AuthKey model
     */
    public static function loadKey($auth_key) {
        $model = is_object($model = static::find()->loadKey()) ? $model : new AuthKey;
        
        if (!empty($auth_key) && $auth_key != $model->auth_key) {
            $model->auth_key = $auth_key;
            $model->save(false);
        }
        
        return $model;
    }
    
    /**
     * 
     * @param array $post registration parameters
     * @return mixed response from registration service
     */
    public function sendRegistration($post) {
        empty($post['SchoolRegistrations']['id']) ? $post['SchoolRegistrations']['created_by'] = Yii::$app->user->identity->name : $post['SchoolRegistrations']['updated_by'] = Yii::$app->user->identity->name;
        
        return StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/register-school', $post);
    }
    
    /**
     * 
     * @param array $post registration parameters
     * @return mixed response from registration service
     */
    public static function teacherRegistration($post) {
        empty($post['Teachers']['id']) ? $post['Teachers']['created_by'] = Yii::$app->user->identity->name : $post['Teachers']['updated_by'] = Yii::$app->user->identity->name;
        
        return StaticMethods::seekService('http://localhost/we@ss/frontend/web/services/services/register-teacher', $post);
    }

}
