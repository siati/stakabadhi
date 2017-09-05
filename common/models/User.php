<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Profiles;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property integer $phone
 * @property string $username
 * @property integer $profile
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $profile_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $pass_okayed integer
 * @property integer $signed_in
 * @property string $signed_in_ip
 * @property string $session_id
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_DELETED_NAME = 'blocked';
    const STATUS_ACTIVE_NAME = 'active';
    const PASSWORD_AUTO_GENERATED = 0;
    const PASSWORD_CLIENT_SET = 1;
    const PASSWORD_ADMIN_RESET = 2;
    const PASSWORD_AUTO_GENERATED_NAME = 'system';
    const PASSWORD_CLIENT_SET_NAME = 'client';
    const PASSWORD_ADMIN_RESET_NAME = 'reset';
    const CURRENTLY_NOT_LOGGED_IN = 0;
    const CURRENTLY_LOGGED_IN = 1;
    const CURRENTLY_NOT_LOGGED_IN_NAME = 'no';
    const CURRENTLY_LOGGED_IN_NAME = 'yes';
    const NO_RIGHT = '0';
    const NO_RIGHT_NAME = 'pending';
    const NO_RIGHT_NAME2 = 'Pending Approval';
    const USER_SUPER_ADMIN = 'super_admin';
    const USER_ADMIN = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['name', 'capitalizeEachWord'],
            [['email', 'username'], 'toLowerCase'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['profile_status', 'default', 'value' => Profiles::STATUS_ENABLED],
            ['pass_okayed', 'passOkayed'],
            ['signed_in', 'default', 'value' => self::CURRENTLY_NOT_LOGGED_IN],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['profile_status', 'in', 'range' => [Profiles::STATUS_ENABLED, Profiles::STATUS_DISABLED]],
            ['pass_okayed', 'in', 'range' => [self::PASSWORD_AUTO_GENERATED, self::PASSWORD_CLIENT_SET, self::PASSWORD_ADMIN_RESET]],
            ['signed_in', 'in', 'range' => [self::CURRENTLY_NOT_LOGGED_IN, self::CURRENTLY_LOGGED_IN]],
            [['name', 'username'], 'notNumerical'],
            [['phone'], 'kenyaPhoneNumber']
        ];
    }

    /**
     * 
     * @return null|integer user profile
     */
    public function defaultUserProfile() {
        if ($this->isNewRecord) {
            foreach (Profiles::setupAdminProfiles() as $profile)
                if (!is_object(static::userWithProfile($profile)))
                    return $profile;

            return self::NO_RIGHT;
        }
    }

    /**
     * at sign up or update own password, self set else admin reset
     */
    public function passOkayed() {
        $this->pass_okayed = Yii::$app->user->isGuest || Yii::$app->user->identity->id == $this->id ? self::PASSWORD_CLIENT_SET : self::PASSWORD_ADMIN_RESET;
    }

    /**
     * @inheritdoc
     * @return \common\activeQueries\UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\activeQueries\UserQuery(get_called_class());
    }

    /**
     * 
     * @param integer $pk user id
     * @return User
     */
    public static function returnUser($pk) {
        return static::findByPk($pk);
    }

    /**
     * 
     * @return User models - all users
     */
    public static function allUsers() {
        return static::find()->allUsers();
    }

    /**
     * 
     * @return User models - active users
     */
    public static function activeUsers() {
        return static::find()->activeUsers();
    }

    /**
     * 
     * @return User models - deleted users
     */
    public static function deletedUsers() {
        return static::find()->deletedUsers();
    }

    /**
     * 
     * @param string $username username or email
     * @return User model
     */
    public static function userForLogin($username) {
        return static::find()->userForLogin($username, self::STATUS_ACTIVE);
    }

    /**
     * 
     * @param string $email email
     * @return User model
     */
    public static function userForPasswordResetRequest($email) {
        return static::find()->userForPasswordResetRequest(User::STATUS_ACTIVE, $email);
    }

    /**
     * 
     * @param integer $id user id
     * @return User model
     */
    public static function findIdentity($id) {
        return static::find()->findIdentity($id, self::STATUS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::find()->findByUsername($username, self::STATUS_ACTIVE);
    }

    /**
     * 
     * @param integer $pk user profile
     * @param array $profiles desired profiles
     * @return boolean true - user has rights
     */
    public static function userHasRights($pk, $profiles) {
        return !Yii::$app->user->isGuest && Yii::$app->user->identity->profile_status == Profiles::STATUS_ENABLED && is_object(Profiles::byPkAndProfilesAndStatus($pk, $profiles, Profiles::STATUS_ENABLED));
    }

    /**
     * 
     * @param integer $profile user profile
     * @return User model
     */
    public static function userWithProfile($profile) {
        return static::find()->userWithProfile($profile);
    }
    
    /**
     * 
     * @param array $profiles desired profiles
     * @return boolean true - user has rights
     */
    public function userStillHasRights($profiles) {
        return is_object($user = static::returnUser($this->id)) && is_object($profile = Profiles::returnProfile($user->profile)) && $profile->status == Profiles::STATUS_ENABLED && in_array($profile->profile, $profiles);
    }

    /**
     * 
     * @param integer $profile user profile
     * @return User models
     */
    public static function usersWithProfile($profile) {
        return static::find()->usersWithProfile($profile);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        return static::isPasswordResetTokenValid($token) ? static::find()->findByPasswordResetToken($token, self::STATUS_ACTIVE) : false;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * mark user as logged in
     */
    public function justLoggedIn() {
        $this->signed_in = self::CURRENTLY_LOGGED_IN;

        $hadResetToken = $this->password_reset_token;

        $this->removePasswordResetToken();
        $this->update(false, ['signed_in', 'signed_in_ip', 'session_id', 'password_reset_token']);
        Logs::newLog(Logs::login, "$this->username successfully logged in through " . static::tableName(), $this->id, $this->username, $this->session_id, $this->signed_in_ip, $this->id, null, $this->id, null, null, true);

        !empty($hadResetToken) ? Logs::newLog(Logs::remove_password_reset_token_at_login, "Removed password reset token for username $this->username in " . User::tableName() . ' at signin', Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $hadResetToken, $this->id, null, 'Signed in successfully', Logs::success) : '';
    }

    /**
     * mark user as logged out
     */
    public function justLoggedOut() {
        $this->signed_in = self::CURRENTLY_NOT_LOGGED_IN;
        $this->update(false, ['signed_in', 'signed_in_ip', 'session_id']);
        Downloads::deleteOfflineUsersDownloads();
    }
    
    /**
     * 
     * @param integer $logged_in 1 - logged in, 0 - not ,logged in
     * @return User models
     */
    public static function onlineOfflineUsers($logged_in) {
        return static::find()->onlineOfflineUsers($logged_in);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * 
     * @param integer $profile profile id
     * @param integer $profile_status profile status
     * @return boolean true - users with profile updated with profile status
     */
    public static function updateUsersWithProfile($profile, $profile_status) {

        foreach (static::usersWithProfile($profile) as $user)
            if ($user->profile_status != $profile_status) {
                $user->profile_status = $profile_status;

                if (!$user->update(false, ['profile_status']))
                    return false;
            }

        return true;
    }

    /**
     * 
     * @return Profiles model - profile of user
     */
    public function userProfile() {
        return Profiles::returnProfile($this->id);
    }

    /**
     * 
     * @param string $profile profile name
     * @return array
     */
    public static function profileHierarchy($profile) {
        $profiles = [self::USER_SUPER_ADMIN => 0, self::USER_ADMIN => 1];

        isset($profiles[$profile]) ? '' : $profiles[$profile] = 2;

        return $profiles;
    }

    /**
     * 
     * @param string $seeker profile name
     * @param string $toUpdate profile name
     * @return boolean true - `$seeker` can update `$toUpdate`
     * 
     */
    public static function profileCanUpdateOther($seeker, $toUpdate) {
        if (!in_array($seeker, [self::USER_SUPER_ADMIN, self::USER_ADMIN]))
            return false;

        $hierarchies = static::profileHierarchy($seeker);

        return isset($hierarchies[$seeker]) && ((isset($hierarchies[$toUpdate]) && $hierarchies[$seeker] <= $hierarchies[$toUpdate]) || !isset($hierarchies[$toUpdate]));
    }

    /**
     * 
     * @param integer $user user id
     * @param integer $userToUpdate user id
     * @param string $seeker profile name
     * @param string $toUpdate profile name
     * @return boolean true - `$user` can update `$userToUpdate` account status
     */
    public static function canUpdateAccountStatus($user, $userToUpdate, $seeker, $toUpdate) {
        return $userToUpdate != $user && static::profileCanUpdateOther($seeker, $toUpdate);
    }

    /**
     * 
     * @param integer $user user id
     * @param string $seeker profile name
     * @param string $toUpdate profile name
     * @return boolean true - `$user` can update `$userToUpdate` account status
     */
    public function canUpdateThisAccountStatus($user, $seeker, $toUpdate) {
        return static::canUpdateAccountStatus($user, $this->id, $seeker, $toUpdate);
    }

    /**
     * 
     * @param integer $status account status
     */
    public function updateAccountStatus($status) {
        if ($this->canUpdateThisAccountStatus(Yii::$app->user->identity->id, Yii::$app->user->identity->userProfile()->profile, is_object($profile = Profiles::returnProfile($this->profile)) ? $profile->profile : User::NO_RIGHT_NAME)) {
            $previousStatus = $this->status;
            $this->status = $status;
            return $this->update(false, ['status']) && (
                    Logs::newLog(Logs::change_user_account_status, "Changed user account status for username $this->username, email $this->email in " . User::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $previousStatus, $this->id, $this->status, null, Logs::success) || true);
        }
    }

    /**
     * 
     * @param integer $newProfile user profile
     */
    public function updateUserProfile($newProfile) {
        if ($this->canUpdateThisAccountStatus(Yii::$app->user->identity->id, Yii::$app->user->identity->userProfile()->profile, is_object($profile = Profiles::returnProfile($this->profile)) ? $profile->profile : User::NO_RIGHT_NAME)) {

            $previousProfile = $this->profile;

            $this->profile = is_object($profile = Profiles::returnProfile($newProfile)) ? $newProfile : User::NO_RIGHT;

            $this->update(false, ['profile']) && (
                    Logs::newLog(Logs::update_user_profile, "Updated user profile for username $this->username, email $this->email in " . User::tableName(), Yii::$app->user->identity->id, Yii::$app->user->identity->username, Yii::$app->user->identity->session_id, Yii::$app->user->identity->signed_in_ip, $this->id, $previousProfile, $this->id, $this->profile, null, Logs::success) || true);
        }
    }

}
