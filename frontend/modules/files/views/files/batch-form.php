<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Batches */
/* @var $editor boolean */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-batch', 'enableAjaxValidation' => true]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= Html::activeHiddenInput($model, 'store') ?>

    <?= Html::activeHiddenInput($model, 'compartment') ?>

    <?= Html::activeHiddenInput($model, 'sub_compartment') ?>

    <?= Html::activeHiddenInput($model, 'sub_sub_compartment') ?>

    <?= Html::activeHiddenInput($model, 'shelf') ?>

    <?= Html::activeHiddenInput($model, 'drawer') ?>

    <?= $form->field($model, 'reference_no')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'style' => 'resize: none']) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <?php if (!empty($editor)): ?>
        <div class="btn btn-success pull-left" onclick="saveStorage('form-batch')">Save</div>
    <?php endif; ?>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>

    <?php if (!empty($editor)): ?>
        <div class="btn btn-primary pull-right" onclick="storage3(<?= $level = \common\models\StoreLevels::batches ?>)" style="margin-right: 10px">New</div>
    <?php endif; ?>
</div>

<?php if (empty($editor)): ?>
    <style onload="$('#form-batch input, #form-batch textarea').attr('disabled', 'disabled'); $(this).remove()"></style>
<?php endif; ?>
