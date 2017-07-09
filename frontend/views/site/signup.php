<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">

        <div class="hd-sctn">
            <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="SignUp" style="height: 100%" class="pull-left" />
            <h3>User Signup</h3>
        </div>

        <div class="bd-sctn">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableAjaxValidation' => true]); ?>
            
            <?= $form->field($model, 'name', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-sunglasses"></i>']]])->textInput(['autofocus' => true])->label('Full Names') ?>

            <?= $form->field($model, 'phone', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-phone"></i>']]])->label('Phone Number') ?>

            <?= $form->field($model, 'email', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-envelope"></i>']]])->label('Email Address') ?>

            <?= $form->field($model, 'username', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-user"></i>']]])->label('Choose A Username') ?>

            <?= $form->field($model, 'password', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-lock"></i>']]])->passwordInput()->label('Choose A Password') ?>

            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button', 'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-lock"></i>']]]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
