<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%documents_mailings_contacts}}".
 *
 * @property integer $id
 * @property string $names
 * @property string $email
 * @property string $description
 */
class DocumentsMailingsContacts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%documents_mailings_contacts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['names', 'email'], 'required'],
            [['description'], 'string'],
            [['names', 'description'], 'notNumerical'],
            [['names'], 'string', 'min' => 5, 'max' => 70],
            [['email'], 'string', 'max' => 70],
            [['email'], 'email'],
            [['names', 'email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'names' => Yii::t('app', 'Names'),
            'email' => Yii::t('app', 'Email'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\DocumentsMailingsContactsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\DocumentsMailingsContactsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk contact id
     * @return DocumentsMailingsContacts model
     */
    public static function returnContact($pk) {
        return static::findByPk($pk);
    }
    
    /**
     * 
     * @return DocumentsMailingsContacts models
     */
    public static function allContacts() {
        return static::find()->allContacts();
    }

    /**
     * 
     * @param string $email contact email
     * @return DocumentsMailingsContacts model
     */
    public static function contactByMail($email) {
        return static::find()->contactByMail($email);
    }

    /**
     * 
     * @param string $name contact name
     * @return DocumentsMailingsContacts model
     */
    public static function contactsByName($name) {
        return static::find()->contactsByName($name);
    }
    
    /**
     * 
     * @param string $email contact email
     * @param string $name contact name
     * @return DocumentsMailingsContacts model
     */
    public static function newContact($email, $name) {
        $model = new DocumentsMailingsContacts;
        
        $model->email = $email;
        $model->names = $name;
        
        return $model;
    }
    
    /**
     * 
     * @param integer $id contact id
     * @param string $email contact email
     * @param string $name contact name
     * @return DocumentsMailingsContacts model
     */
    public static function contactToLoad($id, $email, $name) {
        return is_object($model = static::returnContact($id)) ? $model : static::newContact($email, $name);
    }
    
    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        $previousModel = static::returnContact($this->id);
        return $this->save() &&
                (Logs::newLog(($exists = is_object($previousModel)) ? Logs::update_mail_contact : Logs::create_new_mail_contact, ($exists ?  "Updated mail contact $this->names in " : "Created mail contact $this->names in ") . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $exists ? $this->id : '', $exists ? "$previousModel->names, $previousModel->email" : '', $this->id, "$this->names, $this->email", null, Logs::success) || true);
    }
    
    /**
     * 
     * @return boolean true - model deleted
     */
    public function modelDelete() {
        return $this->delete() &&
                (Logs::newLog(Logs::delete_mail_contact, "Deletted mail contact $this->names from " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, "$this->names, $this->email", $this->id, "$this->names, $this->email", null, Logs::success) || true);
    }

}
