<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">

        <div class="hd-sctn">
            <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="SignIn" style="height: 100%" class="pull-left" />
            <h3>User Login</h3>
        </div>
        
        <div class="bd-sctn">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableAjaxValidation' => true]); ?>

            <?= $form->field($model, 'username', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-user"></i>']]])->textInput(['autofocus' => 'autofocus'])->label('Username or Email') ?>

            <?= $form->field($model, 'password', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-log-in"></i>']]])->passwordInput()->label('Password') ?>

            <div style="color:#999;margin:1em 0">
                <span class="btn btn-xs btn-info pull-right" onclick="$('.psw-rd-mn-btn').click()">Forgot Password?</span>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
