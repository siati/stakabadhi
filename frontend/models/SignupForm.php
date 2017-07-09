<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $name, $phone, $username, $email, $password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'username'], 'trim'],
            [['name', 'phone', 'username', 'email', 'password'], 'required'],
            [['name', 'email'], 'string', 'min' => 10, 'max' => 128],
            ['phone', 'kenyaPhoneNumber'],
            ['email', 'email'],
            ['username', 'string', 'min' => 5, 'max' => 25],
            [['name', 'username'], 'notNumerical'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This phone number has already been taken.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {

            $user = new User();

            $user->name = $this->name;
            $user->phone = $this->phone;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->profile = $user->defaultUserProfile();
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Signup successful. You may proceed to <span class="btn btn-xs btn-success" onclick="$(' . "'.sgn-in-mn-btn'" . ').click()">Sign In</span>');
                return $user;
            }

            Yii::$app->session->setFlash('info', 'Signup unsuccessful. Please try again. If this persists then notify your system administrator');
        } else
            Yii::$app->session->setFlash('error', 'Signup unsuccessful. Please correct the errors highlighted');

        return null;
    }

}
