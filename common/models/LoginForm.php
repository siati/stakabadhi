<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['username'], 'notNumerical'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            [['username', 'password'], 'validatePassword']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {

        if (!$user = $this->getUser()) {
            $this->addError('username', 'There does not exist a user by that username or email');
            $this->addError('password', 'User not found');
        } else
        if ($user->signed_in == User::CURRENTLY_LOGGED_IN) {
            $this->addError('username', $err = "You seem to be already logged in from $user->signed_in_ip");
            $this->addError('password', $err);
        } else
        if (!$user->validatePassword($this->password))
            $this->addError('password', 'Incorrect password');
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate())
            return Yii::$app->user->login($user = $this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        else {
            Logs::newLog(Logs::login, "$this->username login through " . static::tableName() . ' failed because ' . (is_object($this->_user) ? ($this->_user->signed_in == User::CURRENTLY_LOGGED_IN ? ('already logged in from ' . $this->_user->signed_in_ip) : ('of wrong password')) : (' username or email not found')), '0', '', Yii::$app->getSession()->id, Yii::$app->getRequest()->getUserIP(), '0', null, '0', null, null, false);
            Yii::$app->session->setFlash('info', 'Signin failed. Please check your credentials');
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = User::userForLogin($this->username);
        }

        return $this->_user;
    }

}
