<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use kartik\form\ActiveForm;

$this->title = 'Password Reset Request';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">

    <div class="row">
        <div class="hd-sctn">
            <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="Password Reset Request" style="height: 100%" class="pull-left" />
            <h3>Password Reset Request</h3>
        </div>

        <div class="bd-sctn">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'enableAjaxValidation' => true]); ?>

            <?=
            $form->field($model, 'email', [
                'addon' => [
                    'prepend' => ['content' => '<i class="glyphicon glyphicon-envelope"></i>'],
                    'append' => ['content' => '<button class="btn btn-primary"><i class="glyphicon glyphicon-send"> </i> Send</button>', 'asButton' => true]
                ]
            ])->textInput(['autofocus' => true])->label('Your email address as registered with us')
            ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
