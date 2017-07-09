<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shelves */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-shelf', 'enableAjaxValidation' => true]); ?>
    
    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= Html::activeHiddenInput($model, 'store') ?>

    <?= Html::activeHiddenInput($model, 'compartment') ?>

    <?= Html::activeHiddenInput($model, 'sub_compartment') ?>

    <?= Html::activeHiddenInput($model, 'sub_sub_compartment') ?>

    <?= $form->field($model, 'reference_no')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'style' => 'resize: none']) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="saveStorage('form-shelf')">Save</div>
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
    <div class="btn btn-primary pull-right" onclick="storage3(<?= $level = \common\models\StoreLevels::shelves ?>)" style="margin-right: 10px">New</div>
</div>
