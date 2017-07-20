<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%file_permissions}}".
 *
 * @property integer $id
 * @property integer $store_level
 * @property integer $store_id
 * @property string $read_rights
 * @property string $write_rights
 * @property string $deny_rights
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class FilePermissions extends \yii\db\ActiveRecord {

    const read = 'read';
    const write = 'write';
    const deny = 'deny';
    const read_rights = 'read_rights';
    const write_rights = 'write_rights';
    const deny_rights = 'deny_rights';
    const comma = ',';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%file_permissions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['store_level', 'store_id', 'created_by'], 'required'],
            [['store_level', 'store_id', 'created_by', 'updated_by'], 'integer'],
            [['read_rights', 'write_rights', 'deny_rights'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_level' => Yii::t('app', 'Store Level'),
            'store_id' => Yii::t('app', 'Store ID'),
            'read_rights' => Yii::t('app', 'Users With Read Rights'),
            'write_rights' => Yii::t('app', 'Users With Write Rights'),
            'deny_rights' => Yii::t('app', 'Users Denied Rights'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\FilePermissionsQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\FilePermissionsQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk permission id
     * @return FilePermissions model
     */
    public static function returnPermission($pk) {
        return static::find()->byPk($pk);
    }

    /**
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @param array $read_users user ids
     * @param array $write_users user ids
     * @param array $deny_users user ids
     * @return FilePermissions models
     */
    public static function searchDrawers($store_level, $store_id, $read_users, $write_users, $deny_users) {
        return static::find()->searchDrawers($store_level, $store_id, $read_users, $write_users, $deny_users);
    }

    /**
     * 
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return  FilePermissions model
     */
    public static function byStoreLevelAndId($store_level, $store_id) {
        foreach (static::searchDrawers($store_level, $store_id, [], [], []) as $permission)
            return $permission;
    }

    /**
     * 
     * @param integer $store store id
     * @param integer $compartment compartment id
     * @param integer $subcompartment sub-compartment id
     * @param integer $subsubcompartment sub-sub-compartment id
     * @param integer $shelf shelf id
     * @param integer $drawer drawer id
     * @param integer $batch batch id
     * @param integer $folder folder id
     * @param integer $file file id
     * @param integer $level level id
     * @param integer $user user id
     * @param boolean $parentsOnly true - parents only
     * @param string $desiredRight desired right to storage
     * @return string user right to storage
     */
    public static function effectiveUserRightToStorage($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $file, $level, $user, $parentsOnly, $desiredRight) {
        foreach (static::find()->effectiveUserRightToStorage($store, $compartment, $subcompartment, $subsubcompartment, $shelf, $drawer, $batch, $folder, $file, $level, $user, $parentsOnly) as $permission)
            return $permission->deny_rights == $user ? (self::deny) : ($permission->read_rights == $user ? (self::read) : ($permission->write_rights == $user ? (self::write) : ($parentsOnly ? $desiredRight : self::deny)));

        return self::deny;
    }

    /**
     * 
     * @param Stores|Compartments|SubCompartments|SubSubCompartments|Shelves|Drawers|Batches|Folders|Files $storage store model object
     * @param integer $level store level id
     * @param integer $id store id
     * @param integer $user user id
     * @param boolean $parentsOnly true - parents only
     * @param string $desiredRight desired right to storage
     * @return string user right to `$storage`
     */
    public static function userRightToStorage($storage, $level, $id, $user, $parentsOnly, $desiredRight) {
        !is_object($storage) ? $storage = StoreLevels::storageByID($level, $id) : '';

        return is_object($storage) ? static::effectiveUserRightToStorage(
                        isset($storage->store) ? $storage->store : ''
                        , isset($storage->compartment) ? ($storage->compartment) : (isset($storage->store) ? $storage->id : '')
                        , isset($storage->sub_compartment) ? ($storage->sub_compartment) : (isset($storage->compartment) ? $storage->id : '')
                        , isset($storage->sub_sub_compartment) ? ($storage->sub_sub_compartment) : (isset($storage->sub_compartment) ? $storage->id : '')
                        , isset($storage->shelf) ? ($storage->shelf) : (isset($storage->sub_sub_compartment) ? $storage->id : '')
                        , isset($storage->drawer) ? ($storage->drawer) : (isset($storage->shelf) ? $storage->id : '')
                        , isset($storage->batch) ? ($storage->batch) : (isset($storage->drawer) ? $storage->id : '')
                        , isset($storage->folder) ? ($storage->folder) : (isset($storage->batch) ? $storage->id : '')
                        , isset($storage->folder) ? $storage->id : ''
                        , $level, $user, $parentsOnly, $desiredRight
                ) : self::deny;
    }

    /**
     * 
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return  FilePermissions model
     */
    public static function newPermission($store_level, $store_id) {
        $model = new FilePermissions;

        $model->store_level = $store_level;
        $model->store_id = $store_id;
        $model->created_by = Yii::$app->user->identity->id;

        return $model;
    }

    /**
     * 
     * @param integer $id permission id
     * @param integer $store_level store level
     * @param integer $store_id store id
     * @return  FilePermissions model
     */
    public static function permissionToLoad($id, $store_level, $store_id) {
        return is_object($model = static::returnPermission($id)) || is_object($model = static::byStoreLevelAndId($store_level, $store_id)) ? $model : static::newPermission($store_level, $store_id);
    }

    /**
     * 
     * @return boolean true - model saved
     */
    public function modelSave() {
        if ($this->isNewRecord)
            $this->created_at = StaticMethods::now();
        else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = StaticMethods::now();
        }

        empty($this->read_rights) ? $this->read_rights = null : '';
        empty($this->write_rights) ? $this->write_rights = null : '';
        empty($this->deny_rights) ? $this->deny_rights = null : '';

        return $this->save();
    }

    /**
     * 
     * @param string $attribute attribute of `$this` - read_rights, write_rights
     * @param integer $value user id
     * @return boolean true - permission transaction completed successfully
     */
    public function theRightsTransaction($attribute, $value) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->distinctUserPermission($attribute, $value)) {

                $transaction->commit();

                return true;
            }
        } catch (Exception $exc) {
            
        }

        $transaction->rollback();
    }

    /**
     * 
     * @param string $attribute attribute of `$this` - read_rights, write_rights
     * @param integer $value user id
     * @return boolean true - permission saved
     */
    public function distinctUserPermission($attribute, $value) {
        if ($attribute != self::read_rights && in_array($value, $read_rights = StaticMethods::stringExplode($this->read_rights, self::comma))) {
            unset($read_rights[array_search($value, $read_rights)]);
            $this->read_rights = StaticMethods::arrayImplode($read_rights, self::comma);
        }

        if ($attribute != self::write_rights && in_array($value, $write_rights = StaticMethods::stringExplode($this->write_rights, self::comma))) {
            unset($write_rights[array_search($value, $write_rights)]);
            $this->write_rights = StaticMethods::arrayImplode($write_rights, self::comma);
        }

        if ($attribute != self::deny_rights && in_array($value, $deny_rights = StaticMethods::stringExplode($this->deny_rights, self::comma))) {
            unset($deny_rights[array_search($value, $deny_rights)]);
            $this->deny_rights = StaticMethods::arrayImplode($deny_rights, self::comma);
        }

        if (!in_array($value, $rights = StaticMethods::stringExplode($this->$attribute, self::comma))) {
            array_push($rights, $value);
            $this->$attribute = StaticMethods::arrayImplode($rights, self::comma);
        }

        return $this->modelSave();
    }

    /**
     * 
     * @param string $parentRight parent right
     * @param string $childRight child right
     * @return array [attribute, right]
     */
    public static function useParentRights($parentRight, $childRight, $childAttribute) {
        return [
            $parentRight == self::deny ? (self::deny_rights) : ($parentRight == self::read && $childRight == self::write ? self::read_rights : $childAttribute),
            $parentRight == self::deny ? (self::deny) : ($parentRight == self::read && $childRight == self::write ? self::read : $childRight)
        ];
    }

    /**
     * 
     * @param string $parentRight parent right
     * @param string $childRight child right
     * @return string effective child right
     */
    public static function parentChildRight($parentRight, $childRight) {
        return $childRight == self::deny || $childRight == $parentRight || ($childRight == self::read && $parentRight == self::write) ? $childRight : $parentRight;
    }

    /**
     * 
     * @param integer $user user id
     * @return string user right to storage
     */
    public function userRight($user) {
        return in_array($user, StaticMethods::stringExplode($this->write_rights, self::comma)) ? (self::write) : (in_array($user, StaticMethods::stringExplode($this->read_rights, self::comma)) ? self::read : self::deny);
    }

    /**
     * 
     * @param integer $user user id
     * @return string user right to `$storage`
     */
    public function userSubjectiveRight($user) {
        return $this->subjectiveUserRight($user, false);
    }

    /**
     * 
     * @param integer $user user id
     * @return string user right to `$storage`
     */
    public function userSubjectiveLogicalRight($user, $parentRight) {
        return static::parentChildRight($parentRight, ($selfRight = $this->userRight($user)) != self::deny || is_object(static::byStoreLevelAndId($this->store_level, $this->store_id)) ? $selfRight : $parentRight);
    }

    /**
     * 
     * @param integer $user user id
     * @param boolean $parentsOnly true - parents only
     * @return string user right to `$storage`
     */
    public function subjectiveUserRight($user, $parentsOnly) {
        return static::userRightToStorage(null, $this->store_level, $this->store_id, $user, $parentsOnly, $this->userRight($user));
    }

}
