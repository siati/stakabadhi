<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;
use common\models\Logs;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model {

    public $password;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword() {
        $user = $this->_user;
        
        $user->setPassword($this->password);
        
        $token = $user->password_reset_token;
        
        $user->removePasswordResetToken();

        return $user->save(false) && (Logs::newLog(($isGuest = Yii::$app->user->isGuest) ? (Logs::password_reset) : ($user->id == Yii::$app->user->identity->id ? Logs::password_reset_by_self : Logs::password_reset_by_admin), "Reset password for username $user->username, email $user->email in " . User::tableName() . " by token $token", $isGuest ? '0' : Yii::$app->user->identity->id, $isGuest ? 'Guest' : Yii::$app->user->identity->username, $isGuest ? Yii::$app->getSession()->id : Yii::$app->user->identity->session_id, $isGuest ? Yii::$app->getRequest()->getUserIP() : Yii::$app->user->identity->signed_in_ip, $user->id, $token, $user->id, null, 'Reset password successfully', Logs::success) || true);
    }

}
