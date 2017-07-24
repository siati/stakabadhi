<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%drawers}}".
 *
 * @property integer $id
 * @property integer $store
 * @property integer $compartment
 * @property integer $sub_compartment
 * @property integer $sub_sub_compartment
 * @property integer $shelf
 * @property string $name
 * @property string $reference_no
 * @property string $location
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Drawers extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%drawers}}';
    }

    /**
     *
     * @var integer store level
     */
    public $level = StoreLevels::drawers;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'created_by', 'updated_by'], 'integer'],
            [['store', 'compartment', 'sub_compartment', 'sub_sub_compartment', 'shelf', 'name', 'reference_no', 'location', 'created_by'], 'required'],
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
            'sub_sub_compartment' => Yii::t('app', 'Sub Sub Compartment'),
            'shelf' => Yii::t('app', 'Shelf'),
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
     * @return \common\activeQueries\DrawersQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\DrawersQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk drawer id
     * @return Drawers model
     */
    public static function returnDrawer($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Drawers models
     */
    public static function allDrawers() {
        return static::find()->allDrawers();
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param boolean $whereStringAMust force where clause
     * @param string $oneOrAll one or all
     * @return Drawers models
     */
    public static function searchDrawers($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $whereStringAMust, $oneOrAll) {
        return static::find()->searchDrawers($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $whereStringAMust, $oneOrAll);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param boolean $whereStringAMust force where clause
     * @return integer no. of drawers
     */
    public static function countDrawers($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $whereStringAMust) {
        foreach (static::find()->countDrawers($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $whereStringAMust) as $drawer)
            return $drawer->id;
    }

    /**
     * 
     * @param string $reference_no reference no
     * @return Drawers model
     */
    public static function byReferenceNo($reference_no) {
        return static::find()->byReferenceNo($reference_no);
    }

    /**
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @return Drawers model
     */
    public static function newDrawer($store, $compartment, $subcompartment, $subsubcompartment, $shelf) {
        $model = new Drawers;
        
        $model->store = $store;
        
        $model->compartment = $compartment;
        
        $model->sub_compartment = $subcompartment;
        
        $model->sub_sub_compartment = $subsubcompartment;
        
        $model->shelf = $shelf;

        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id drawer id
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @return Drawers model
     */
    public static function drawerToLoad($id, $store, $compartment, $subcompartment, $subsubcompartment, $shelf) {
        return is_object($model = static::returnDrawer($id)) ? $model : static::newDrawer($store, $compartment, $subcompartment, $subsubcompartment, $shelf);
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
        }

        return $this->save() && ((!empty($isNew) && Logs::newLog(Logs::create_store, "Created store $this->id in " . static::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, '',  '', "$this->level,$this->id", $this->name, null, Logs::success)) || true);
    }
    
    /**
     * 
     * @return FilePermissions model
     */
    public function permission() {
        return FilePermissions::byStoreLevelAndId(StoreLevels::drawers, $this->id);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user right to drawer
     */
    public function userRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userRight($user) : Shelves::returnShelf($this->shelf)->userRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @return string user subjective right to drawer
     */
    public function userSubjectiveRight($user) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveRight($user) : Shelves::returnShelf($this->shelf)->userSubjectiveRight($user);
    }
    
    /**
     * 
     * @param integer $user user id
     * @param string $parentRight user subjective right to parent shelf
     * @return string user subjective logical right to drawer
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return is_object($permission = $this->permission()) && $permission->userRightExists($user) ? $permission->userSubjectiveLogicalRight($user, empty($parentRight) ? Shelves::returnShelf($this->shelf)->userSubjectiveRight($user) : $parentRight) : Shelves::returnShelf($this->shelf)->userSubjectiveLogicalRight($user, $parentRight);
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @return boolean true - drawers moved
     */
    public static function drawersToMove($store, $compartment, $subcompartment, $subsubcompartment, $shelf) {
        foreach (static::searchDrawers(null, null, null, null, $shelf, true, StoreLevels::all) as $drawer)
            if (!$drawer->moveDrawer($store, $compartment, $subcompartment, $subsubcompartment, $shelf))
                return false;

        return true;
    }
    
    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @return boolean true - drawer moved
     */
    public function moveDrawer($store, $compartment, $subcompartment, $subsubcompartment, $shelf) {
        $previous = static::returnDrawer($this->id);

        $old = "$previous->store,$previous->compartment,$previous->sub_compartment,$previous->sub_sub_compartment,$previous->shelf";

        $this->store = $store;

        $this->compartment = $compartment;

        $this->sub_compartment = $subcompartment;

        $this->sub_sub_compartment = $subsubcompartment;

        $this->shelf = $shelf;
        
        $new = "$this->store,$this->compartment,$this->sub_compartment,$this->sub_sub_compartment,$this->shelf";

        Yii::$app->db->transaction === null ? $transaction = Yii::$app->db->beginTransaction() : '';

        try {
            if ($this->modelSave() && Batches::batchesToMove($this->store, $this->compartment, $this->sub_compartment, $this->sub_sub_compartment, $this->shelf, $this->id)) {

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
     * @return boolean true - drawer is deletable
     */
    public function isDeletable() {
        return !is_object(Batches::searchBatches(null, null, null, null, null, $this->id, true, StoreLevels::one));
    }
    
    /**
     * 
     * @return boolean true - drawer deleted
     */
    public function deleteDrawer() {
        return $this->isDeletable() && $this->delete();
    }

}
