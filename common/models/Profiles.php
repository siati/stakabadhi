<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%profiles}}".
 *
 * @property integer $id
 * @property string $profile
 * @property string $name
 * @property string $description
 * @property integer $status
 */
class Profiles extends \yii\db\ActiveRecord {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED_NAME = 'Enabled';
    const STATUS_DISABLED_NAME = 'Disabled';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%profiles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['profile', 'name'], 'required'],
            [['description'], 'string'],
            [['profile'], 'string', 'min' => 5, 'max' => 15],
            ['profile', 'adminsAndPendingUnalterable'],
            [['name'], 'string', 'min' => 5, 'max' => 30],
            ['profile', 'toLowerCase'],
            ['name', 'capitalizeEachWord'],
            ['description', 'paragraphCase'],
            [['profile', 'name', 'description'], 'notNumerical'],
            [['profile', 'name', 'description'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ENABLED],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
            ['status', 'newProfileMustBeEnabled']
        ];
    }

    /**
     * system generated profiles cannot be changed
     */
    public function adminsAndPendingUnalterable() {
        if (
                is_object($compare = static::returnProfile($this->id)) &&
                in_array($compare->profile, [User::USER_SUPER_ADMIN, User::USER_ADMIN, User::NO_RIGHT_NAME]) &&
                $this->profile != $compare->profile
        )
            $this->addError('profile', 'This role symbol cannot be changed');
    }

    /**
     * new status must be enabled
     */
    public function newProfileMustBeEnabled() {
        if ($this->profile == User::NO_RIGHT_NAME)
            $this->status = self::STATUS_DISABLED;
        else
        if ($this->isNewRecord && $this->status == self::STATUS_DISABLED)
            $this->addError('status', 'New status must be enabled');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile' => Yii::t('app', 'Profile / Role'),
            'name' => Yii::t('app', 'Name Of Role'),
            'description' => Yii::t('app', 'Description Of Role'),
            'status' => Yii::t('app', 'Profile Status')
        ];
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\ProfilesQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\ProfilesQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk profile id
     * @return Profiles model
     */
    public static function returnProfile($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return Profiles models
     */
    public static function allProfiles() {
        return static::find()->allProfiles();
    }

    /**
     * 
     * @return Profiles models
     */
    public static function enabledProfiles() {
        return static::find()->byStatus(self::STATUS_ENABLED);
    }

    /**
     * 
     * @return Profiles models
     */
    public static function disabledProfiles() {
        return static::find()->byStatus(self::STATUS_DISABLED);
    }

    /**
     * 
     * @param string $profile profile
     * @return Profiles model
     */
    public static function byProfile($profile) {
        return static::find()->byProfile($profile);
    }

    /**
     * 
     * @param integer $pk profile id
     * @param array $profiles profile names
     * @return Profiles model
     */
    public static function byPkAndProfiles($pk, $profiles) {
        return static::find()->byPkAndProfiles($pk, $profiles);
    }

    /**
     * 
     * @param integer $pk profile id
     * @param array $profiles profile names
     * @param integer $status profile status
     * @return Profiles model
     */
    public static function byPkAndProfilesAndStatus($pk, $profiles, $status) {
        return static::find()->byPkAndProfilesAndStatus($pk, $profiles, $status);
    }

    /**
     * 
     * @param string $profile profile
     * @return \common\models\Profiles model
     */
    public static function newProfile($profile) {
        $model = new Profiles;

        $model->profile = $profile;

        return $model;
    }

    /**
     * 
     * @param integer $id profile id
     * @param string $profile profile
     * @return \common\models\Profiles model
     */
    public static function profileToLoad($id, $profile) {
        return is_object($model = static::findByPk($id)) || is_object($model = static::byProfile($profile)) ? $model : static::newProfile($profile);
    }

    /**
     * initial system admin profiles on initial signups
     * @return array super admin and admin profile ids
     */
    public static function setupAdminProfiles() {
        if (!is_object($superadmin = static::byProfile(User::USER_SUPER_ADMIN))) {
            $superadmin = static::profileToLoad(null, User::USER_SUPER_ADMIN);
            $superadmin->name = 'Vendor Administrator';
            $superadmin->description = 'User related to product vendor';
            $superadmin->modelSave();
        }

        if (!is_object($admin = static::byProfile(User::USER_ADMIN))) {
            $admin = static::profileToLoad(null, User::USER_ADMIN);
            $admin->name = 'Client Administrator';
            $admin->description = 'Client system administarator';
            $admin->modelSave();
        }

        if (!is_object($pending = static::byProfile(User::NO_RIGHT_NAME))) {
            $pending = static::profileToLoad(null, User::NO_RIGHT_NAME);
            $pending->name = User::NO_RIGHT_NAME2;
            $pending->description = 'User just signed up awaiting approval by system administrator';
            $pending->modelSave();
        }

        return [User::USER_SUPER_ADMIN => $superadmin->id, User::USER_ADMIN => $admin->id, User::NO_RIGHT_NAME => $pending->id];
    }

    /**
     * 
     * @return boolean true model saved and respective users updated
     */
    public function modelSave() {

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (User::updateUsersWithProfile($this->id, $this->status) && $this->save()) {
                $transaction->commit();
                return true;
            }

            $transaction->rollback();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    /**
     * 
     * @return array profile statuses
     */
    public static function statusEnableds() {
        return [
            self::STATUS_ENABLED => self::STATUS_ENABLED_NAME,
            self::STATUS_DISABLED => self::STATUS_DISABLED_NAME
        ];
    }

}
