<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Logs;
use common\models\StaticMethods;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'User not found against this email'
            ],
        ];
    }

    /**
     * 
     * @return boolean|User model - user to be rest password for, else false
     */
    public function userForPasswordResetRequest() {
        /* @var $user User */
        if (!$user = User::userForPasswordResetRequest($this->email)) {
            return false;
        }

        $previousValue = $user->password_reset_token;
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if ($user->save())
                Logs::newLog(($isGuest = Yii::$app->user->isGuest) ? (Logs::new_password_reset_token) : ($user->id == Yii::$app->user->identity->id ? Logs::new_password_reset_token_by_self : Logs::new_password_reset_token_by_admin), "Generated new password reset token for username $user->username by email $user->email in " . User::tableName(), $isGuest ? '0' : Yii::$app->user->identity->id, $isGuest ? 'Guest' : Yii::$app->user->identity->username, $isGuest ? Yii::$app->getSession()->id : Yii::$app->user->identity->session_id, $isGuest ? Yii::$app->getRequest()->getUserIP() : Yii::$app->user->identity->signed_in_ip, $user->id, $previousValue, $user->id, $user->password_reset_token, 'For request for password reset', Logs::success);
            else
                return false;
            
        }

        return $user;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail() {

        if (!is_object($user = $this->userForPasswordResetRequest()))
            return false;
        
        if (is_array($sent = StaticMethods::sendMail('passwordResetToken-html', 'passwordResetToken-text', ['user' => $user], [Yii::$app->params['supportEmail'] => Yii::$app->name], [$this->email], [], [], 'Password reset for ' . Yii::$app->name, [])))
            $sent = false;
        
        Logs::newLog(($isGuest = Yii::$app->user->isGuest) ? (Logs::send_password_reset_token) : ($user->id == Yii::$app->user->identity->id ? Logs::send_password_reset_token_by_self : Logs::send_password_reset_token_by_admin), "Sent password reset token for username $user->username by email $user->email to $this->email in " . User::tableName(), $isGuest ? '0' : Yii::$app->user->identity->id, $isGuest ? 'Guest' : Yii::$app->user->identity->username, $isGuest ? Yii::$app->getSession()->id : Yii::$app->user->identity->session_id, $isGuest ? Yii::$app->getRequest()->getUserIP() : Yii::$app->user->identity->signed_in_ip, $user->id, $user->password_reset_token, $user->id, $user->password_reset_token, 'For request for password reset', empty($sent) ? Logs::failed : Logs::success);

        return !empty($sent);
    }

}
