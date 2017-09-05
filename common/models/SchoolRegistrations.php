<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%school_registrations}}".
 *
 * @property integer $id
 * @property string $level
 * @property string $code
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property integer $postal_no
 * @property string $postal_town
 * @property integer $county
 * @property integer $constituency
 * @property integer $ward
 * @property string $auth_key
 * @property string $ip_address
 * @property string $active
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class SchoolRegistrations extends \yii\db\ActiveRecord {

    const active = 'yes';
    const not_active = 'no';
    const primary = StaticMethods::primary;
    const secondary = StaticMethods::secondary;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%school_registrations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['level', 'code', 'name', 'county', 'constituency', 'ward', 'auth_key', 'ip_address', 'created_by'], 'required'],
            [['level', 'active'], 'string'],
            [['code', 'phone', 'postal_no', 'postal_town', 'county', 'constituency', 'ward'], 'integer'],
            [['phone'], 'kenyaPhoneNumber'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'phone'], 'string', 'min' => 9, 'max' => 15],
            [['postal_no'], 'string', 'min' => 1, 'max' => 6],
            [['name', 'email', 'auth_key'], 'string', 'min' => 10, 'max' => 128],
            [['ip_address', 'created_by', 'updated_by'], 'string', 'max' => 25],
            [['code', 'name', 'phone', 'email', 'auth_key'], 'unique'],
            [['email'], 'email'],
            [['name'], 'notNumerical']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'level' => Yii::t('app', 'School Level'),
            'code' => Yii::t('app', 'School Code'),
            'name' => Yii::t('app', 'Name of School'),
            'phone' => Yii::t('app', 'Phone No.'),
            'email' => Yii::t('app', 'Email Address'),
            'postal_no' => Yii::t('app', 'P.O. Box No.'),
            'postal_town' => Yii::t('app', 'Postal Town'),
            'county' => Yii::t('app', 'County/Province'),
            'constituency' => Yii::t('app', 'Constituency/District'),
            'ward' => Yii::t('app', 'Ward/Division'),
            'auth_key' => Yii::t('app', 'Authentication Key'),
            'ip_address' => Yii::t('app', 'IP Address'),
            'active' => Yii::t('app', 'Active'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\SchoolRegistrationsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SchoolRegistrationsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk code id
     * @return SchoolRegistrations model
     */
    public static function returnSchool($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @param string $active yes / no
     * @return SchoolRegistrations models
     */
    public static function allSchools($active) {
        return static::find()->allSchools($active);
    }

    /**
     * 
     * @param string $level level of school - primary / secondary etc
     * @param integer $county county id
     * @param integer $constituency constituency id
     * @param integer $ward ward id
     * @param string $active yes / no
     * @return SchoolRegistrations models
     */
    public static function searchSchools($level, $county, $constituency, $ward, $active) {
        return static::find()->searchSchools($level, $county, $constituency, $ward, $active);
    }

    /**
     * 
     * @param string $code school code
     * @return SchoolRegistrations model
     */
    public static function byCode($code) {
        return static::find()->byCode($code);
    }

    /**
     * 
     * @param string $phone school phone
     * @return SchoolRegistrations model
     */
    public static function byPhone($phone) {
        return static::find()->byPhone($phone);
    }

    /**
     * 
     * @param string $email school email
     * @return SchoolRegistrations model
     */
    public static function byEmail($email) {
        return static::find()->byEmail($email);
    }

    /**
     * 
     * @param string $auth_key school auth key
     * @return SchoolRegistrations model
     */
    public static function byAuthKey($auth_key) {
        return static::find()->byAuthKey($auth_key);
    }

    /**
     * 
     * @param string $level level of school - primary / secondary etc
     * @param string $code school code
     * @param string $name school name
     * @param string $created_by created by
     * @return SchoolRegistrations model
     */
    public static function newSchool($level, $code, $name, $created_by) {
        $model = new SchoolRegistrations;

        $model->level = $level;
        $model->code = $code;
        $model->name = $name;
        $model->created_by = $created_by;
        $model->active = self::not_active;

        return $model;
    }

    /**
     * 
     * @param integer $id school id
     * @param string $auth_key school auth key
     * @param string $level level of school - primary / secondary etc
     * @param string $code school code
     * @param string $name school name
     * @param string $created_by created by
     * @return SchoolRegistrations model
     */
    public static function schoolToLoad($id, $auth_key, $level, $code, $name, $created_by) {
        return is_object($model = static::returnSchool($id)) || is_object($model = static::byAuthKey($auth_key)) ? $model : static::newSchool($level, $code, $name, $created_by);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord) {
            $this->created_at = StaticMethods::now();
            $this->setAuthKey();
            $this->ip_address = Yii::$app->getRequest()->getUserIP();
        } else
            $this->updated_at = StaticMethods::now();

        return $this->save();
    }

    /**
     * generate for and set auth key to school
     */
    public function setAuthKey() {
        $this->auth_key = Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString());
    }
    
    /**
     * 
     * @return boolean true - request ip is trusted
     */
    public function verifyRequestIP() {
        return $this->ip_address == Yii::$app->getRequest()->getUserIP();
    }

}
