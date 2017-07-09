<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use kartik\form\ActiveForm;

$this->title = 'Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    
    <div class="row">
        <div class="hd-sctn">
            <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="Password Reset" style="height: 100%" class="pull-left" />
            <h3>Password Reset</h3>
        </div>

        <div class="bd-sctn">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'enableAjaxValidation' => true]); ?>

            <?=
            $form->field($model, 'password', [
                'addon' => [
                    'prepend' => ['content' => '<i class="glyphicon glyphicon-lock"></i>'],
                    'append' => ['content' => '<button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"> </i> Save</button>', 'asButton' => true]
                ]
            ])->passwordInput(['autofocus' => true])->passwordInput()->label('Choose a new password')
            ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
