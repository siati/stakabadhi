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
 * @property integer $updated_by
 * @property string $updated_at
 */
class Compartments extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%compartments}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::compartments;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'created_by', 'updated_by'], 'integer'],
            [['store', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @param string $oneOrAll one or all
     * @return Compartments models
     */
    public static function compartmentsForStore($store, $whereStringAMust, $oneOrAll) {
        return static::find()->compartmentsForStore($store, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of compartments
     */
    public static function countCompartments($store, $whereStringAMust) {
        foreach (static::find()->countCompartments($store, $whereStringAMust) as $compartment)
            return $compartment->id;
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
    public static function compartmentToLoad($id, $store) {
        return is_object($model = static::returnCompartment($id)) ? $model : static::newCompartment($store);
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
            $previous = static::returnCompartment($this->id);
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
        return FilePermissions::byStoreLevelAndId(StoreLevels::compartments, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to compartment
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Stores::returnStore($this->store)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to compartment
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Stores::returnStore($this->store)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent store
     * @return string user subjective logical right to compartment
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Stores::returnStore($this->store)->userRight($user) : $parentRight) : Stores::returnStore($this->store)->userRight($user);
    }

    /**
     * 
     * @param integer $store store id
     * @return boolean true - compartment moved
     */
    public function moveCompartment($store) {

        $previous = static::returnCompartment($this->id);

        $old = "$previous->store";

        $this->store = $store;

        $new = "$this->store";

        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && SubCompartments::subcompartmentsToMove($this->store, $this->id)) {

                Logs::newLog(Logs::move_store, "Moved store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $old, "$this->level,$this->id", $new, null, Logs::success);
                
                empty($transaction) ? '' : $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        empty($transaction) ? '' : $transaction->rollback();
    }
    
    /**
     * 
     * @return boolean true - compartment is deletable
     */
    public function isDeletable() {
        return !is_object(SubCompartments::searchSubcompartments(null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - compartment deleted
     */
    public function deleteCompartment() {
        return $this->isDeletable() && $this->delete() && (Logs::newLog(Logs::delete_store, "Deleted store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $this->name, null, null, null, Logs::success) || true);
    }

}
