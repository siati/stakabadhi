<?php

namespace common\activeQueries;

use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return \common\models\User[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\User|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    
    /**
     * 
     * @return User ActiveRecord - all users
     */
    public function allUsers() {
        return $this->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param integer $profile user profile
     * @return User ActiveRecord
     */
    public function usersWithProfile($profile) {
        return $this->where("profile = '$profile'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @return User ActiveRecord - active users
     */
    public function activeUsers() {
        $status = User::STATUS_ACTIVE;
        return $this->where("status='$status'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @return User ActiveRecord - deleted users
     */
    public function deletedUsers() {
        $status = User::STATUS_DELETED;
        return $this->where("status='$status'")->orderBy('name asc')->all();
    }
    
    /**
     * 
     * @param string $username username or email
     * @param integer $status user status
     * @return User ActiveRecord
     */
    public function userForLogin($username, $status) {
        return $this->where("(username = '$username' || email = '$username') && profile > 0 && status = '$status'")->one();
    }
    
    /**
     * 
     * @param integer $status account status
     * @param string $email email
     * @return User ActiveRecord
     */
    public function userForPasswordResetRequest($status, $email) {
        return $this->where("status = '$status' && email = '$email'")->one();
    }

    
    /**
     * 
     * @param integer $id user id
     * @param integer $status account status
     * @return User ActiveRecord
     */
    public function findIdentity($id, $status) {
        return $this->where("id = '$id' && status = '$status'")->one();
    }
    
    /**
     * 
     * @param string $username username
     * @param integer $status account status
     * @return User ActiveRecord
     */
    public function findByUsername($username, $status) {
        return $this->where("username = '$username' && status = '$status'")->one();
    }
    
    /**
     * 
     * @param integer $profile user profile
     * @return User ActiveRecord
     */
    public function userWithProfile($profile) {
        return $this->where("profile = '$profile'")->one();
    }
    
    /**
     * 
     * @param string $token password reset token
     * @param integer $status account status
     * @return User ActiveRecord
     */
    public function findByPasswordResetToken($token, $status) {
        return $this->where("password_reset_token = '$token' && status = '$status'")->one();
    }
    
    /**
     * 
     * @param integer $logged_in 1 - logged in, 0 - not ,logged in
     * @return User ActiveRecords
     */
    public function onlineOfflineUsers($logged_in) {
        return $this->where("signed_in = '$logged_in'")->orderBy('name asc')->all();
    }

}
