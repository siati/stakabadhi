<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Profiles */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use common\models\Profiles;
?>

<div class="hd-sctn">
    <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="Profile Edit" style="height: 100%" class="pull-left" />
    <h3>Profile Editor</h3>
</div>

<div class="bd-sctn">
    <div>
        <?php $form = ActiveForm::begin(['id' => 'form-profiles', 'enableAjaxValidation' => true, 'validationUrl' => ['profile']]); ?>

        <?= Html::activeHiddenInput($model, 'id') ?>

        <?= $form->field($model, 'profile', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-adjust"></i>']]])->label('Role Symbol<small style="font-weight: normal"><i> - in lower case e.g. admin</i></small>') ?>

        <?= $form->field($model, 'name', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-pencil"></i>']]])->label('Role Name<small style="font-weight: normal"><i> - capitalize each word e.g. System Administrator</i></small>') ?>

        <?= $form->field($model, 'status', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-check"></i>']]])->dropDownList(Profiles::statusEnableds())->label('Select A Status<small style="font-weight: normal"><i> - new role, if disabled, will not be saved</i></small>') ?>

        <?= $form->field($model, 'description', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-align-justify"></i>']]])->textarea(['rows' => 13, 'style' => 'resize: vertical'])->label('Role Description<small style="font-weight: normal"><i> - use sentence case to describe the role in prose</i></small>') ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
            <?= Html::button('New', ['class' => 'btn btn-info pull-right', 'onclick' => "$('.usr-mg-mn-btn').click()"]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>