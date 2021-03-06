<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sub_sub_compartments}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class SubSubCompartments extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%sub_sub_compartments}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::subsubcompartments;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
     * @return \common\activeQueries\SubSubCompartmentsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\SubSubCompartmentsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk sub-sub-compartment id
     * @return SubSubCompartments model
     */
    public static function returnSubsubcompartment($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return SubSubCompartments models
     */
    public static function allSubsubcompartments() {
        return static::find()->allSubsubcompartments();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return SubSubCompartments models
     */
    public static function searchSubsubcompartments($store, $compartment, $subcompartment, $whereStringAMust, $oneOrAll) {
        return static::find()->searchSubsubcompartments($store, $compartment, $subcompartment, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of sub-sub-compartment
     */
    public static function countSubsubcompartments($store, $compartment, $subcompartment, $whereStringAMust) {
        foreach (static::find()->countSubsubcompartments($store, $compartment, $subcompartment, $whereStringAMust) as $subsubcompartment)
            return $subsubcompartment->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return SubSubCompartments model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @return SubSubCompartments model
     */
    public static function newSubsubcompartment($store, $compartment, $subcompartment) {
        $model = new SubSubCompartments;
        
        $model->store = $store;
        
        $model->compartment = $compartment;
        
        $model->sub_compartment = $subcompartment;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id sub-sub-compartment id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @return SubSubCompartments model
     */
    public static function subsubcompartmentToLoad($id, $store, $compartment, $subcompartment) {
        return is_object($model = static::returnSubsubcompartment($id)) ? $model : static::newSubsubcompartment($store, $compartment, $subcompartment);
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
            $previous = static::returnSubsubcompartment($this->id);
        }

        return (Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]) || $this->userSubjectiveRight(Yii::$app->user->identity->id) == FilePermissions::write) &&
                $this->save() &&
                ((!empty($isNew) && Logs::newLog(Logs::create_store, "Created store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, '',  '', "$this->level,$this->id", $this->name, null, Logs::success)) || true) &&
                ((empty($isNew) && (($new = "$this->reference_no,$this->name,$this->location,$this->description") != ($old = "$previous->reference_no,$previous->name,$previous->location,$previous->description")) && Logs::newLog(Logs::update_store, "Updated store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $old, "$this->level,$this->id", $new, null, Logs::success)) || true);
    }
    
    /**
     * 
     * @return FilePermissions model
     */
    public function permission() {
        return $this->isNewRecord ? SubCompartments::returnSubcompartment($this->sub_compartment)->permission() : FilePermissions::byStoreLevelAndId(StoreLevels::subsubcompartments, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to sub-sub-compartment
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : SubCompartments::returnSubcompartment($this->sub_compartment)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to sub-sub-compartment
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : SubCompartments::returnSubcompartment($this->sub_compartment)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent sub-compartment
     * @return string user subjective logical right to sub-sub-compartment
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? SubCompartments::returnSubcompartment($this->sub_compartment)->userSubjectiveRight($user) : $parentRight) : SubCompartments::returnSubcompartment($this->sub_compartment)->userSubjectiveLogicalRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @return boolean true - sub-sub-compartments moved
     */
    public static function subsubcompartmentsToMove($store, $compartment, $subcompartment) {
        foreach (static::searchSubsubcompartments(null, null, $subcompartment, true, StoreLevels::all) as $subsubcompartment)
            if (!$subsubcompartment->moveSubsubcompartment($store, $compartment, $subcompartment))
                return false;

        return true;
    }
    
    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @return boolean true - sub-sub-compartment moved
     */
    public function moveSubsubcompartment($store, $compartment, $subcompartment) {
        $previous = static::returnSubsubcompartment($this->id);

        $old = "$previous->store,$previous->compartment,$previous->sub_compartment";

        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;
        
        $new = "$this->store,$this->compartment,$this->sub_compartment";

        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && Shelves::shelvesToMove($this->store, $this->compartment, $this->sub_compartment, $this->id)) {

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
     * @return boolean true - sub-sub-compartment is deletable
     */
    public function isDeletable() {
        return !is_object(Shelves::searchShelves(null, null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - sub-sub-compartment deleted
     */
    public function deleteSubsubcompartment() {
        return (Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]) || $this->userSubjectiveRight(Yii::$app->user->identity->id) == FilePermissions::write) && $this->isDeletable() && $this->delete() && (Logs::newLog(Logs::delete_store, "Deleted store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, "$this->level,$this->id", $this->name, null, null, null, Logs::success) || true);
    }

}
