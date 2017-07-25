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
 * @property integer $updated_by
 * @property string $updated_at
 */
class Stores extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%stores}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::stores;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'reference_no', 'location', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
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
     * @return integer no. of stores
     */
    public static function countStores() {
        foreach (static::find()->countStores() as $store)
            return $store->id;
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
        if ($this->isNewRecord) {
            $this->created_at = StaticMethods::now();
            $isNew = true;
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
            $previous = static::returnStore($this->id);
        }

        return $this->save() &&
                ((!empty($isNew) && Logs::newLog(Logs::create_store, "Created store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, '',  '', "$this->level,$this->id", $this->name, null, Logs::success)) || true) &&
                ((empty($isNew) && (($new = "$this->reference_no,$this->name,$this->location,$this->description") != ($old = "$previous->reference_no,$previous->name,$previous->location,$previous->description")) && Logs::newLog(Logs::update_store, "Updated store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $old, "$this->level,$this->id", $new, null, Logs::success)) || true);
    }
    
    /**
     * 
     * @return FilePermissions model
     */
    public function permission() {
        return FilePermissions::byStoreLevelAndId(StoreLevels::stores, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to store
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : FilePermissions::deny;
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to store
     */
    public function userSubjectiveRight($user) {
        return $this->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective logical right to compartment
     */
    public function userSubjectiveLogicalRight($user) {
        return $this->userSubjectiveRight($user);
    }

    /**
     * 
     * @return boolean true - store is deletable
     */
    public function isDeletable() {
        return !is_object(Compartments::compartmentsForStore($this->id, true, StoreLevels::one));
    }

    /**
     * 
     * @return boolean true - store deleted
     */
    public function deleteStore() {
        return $this->isDeletable() && $this->delete() && (Logs::newLog(Logs::delete_store, "Deleted store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $this->name, null, null, null, Logs::success) || true);
    }

}
