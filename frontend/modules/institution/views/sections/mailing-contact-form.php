<?php

/* @var $this yii\web\View */
/* @var $model common\models\DocumentsMailingsContacts */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'form-documents-mail-contacts', 'enableAjaxValidation' => false, 'validationUrl' => ['mailing-contact'], 'fieldConfig' => ['options' => ['class' => 'form-group-sm']]]); ?>

<?= Html::activeHiddenInput($model, 'id') ?>

<?= $form->field($model, 'names')->textInput(['onchange' => 'saveContactDetail()'])->label('Contact Name') ?>

<?= $form->field($model, 'email')->textInput(['onchange' => 'saveContactDetail()'])->label('Email Address') ?>

<?= $form->field($model, 'description')->textarea(['onchange' => 'saveContactDetail()', 'rows' => 2, 'style' => 'resize: none'])->label('Contact Description') ?>

<?php ActiveForm::end(); ?>