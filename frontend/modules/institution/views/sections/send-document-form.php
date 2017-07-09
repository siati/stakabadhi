<?php
/* @var $this yii\web\View */
/* @var $model common\models\DocumentsMailings */
/* @var $sent boolean */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
?>

<div id="to-cc-bcc" hidden="hidden">to</div>

<?php $form = ActiveForm::begin(['id' => 'form-send-documents', 'enableAjaxValidation' => true, 'validationUrl' => ['send-files'], 'fieldConfig' => ['options' => ['class' => 'form-group-sm']]]); ?>

<?= Html::activeHiddenInput($model, 'id') ?>

<?= $form->field($model, 'from')->textInput(['disabled' => true])->label('From<small style="font-weight: normal"><i> - Admin Support Email</i></small>') ?>

<?= $form->field($model, 'to')->textarea(['readonly' => true, 'rows' => 1, 'style' => 'resize: none', 'onclick' => "$('#to-cc-bcc').html('to')"])->label('To<small style="font-weight: normal"><i> - Primary Recipients</i></small>') ?>

<?= $form->field($model, 'cc')->textarea(['readonly' => true, 'rows' => 1, 'style' => 'resize: none', 'onclick' => "$('#to-cc-bcc').html('cc')"])->label('Cc<small style="font-weight: normal"><i> - Secondary Recipients</i></small>') ?>

<?= $form->field($model, 'bcc')->textarea(['readonly' => true, 'rows' => 1, 'style' => 'resize: none', 'onclick' => "$('#to-cc-bcc').html('bcc')"])->label('Bcc<small style="font-weight: normal"><i> - Tertiary Recipients</i></small>') ?>

<?= $form->field($model, 'documents')->textarea(['readonly' => true, 'rows' => 2, 'style' => 'resize: vertical'])->label('Attachments<small style="font-weight: normal"><i> - Documents selected for sending</i></small>') ?>

<?= $form->field($model, 'subject')->textInput()->label('Subject') ?>

<?= $form->field($model, 'body')->textarea(['rows' => 6, 'style' => 'resize: vertical'])->label('Message<small style="font-weight: normal"><i> - Email body</i></small>') ?>

<?= $form->field($model, 'footer')->textarea(['rows' => 4, 'style' => 'resize: vertical'])->label('Footer<small style="font-weight: normal"><i> - e.g. signature or disclaimer</i></small>') ?>

<?php ActiveForm::end(); ?>

<?php if ($sent): ?>
    <style onload="customErrorSwal('Done', 'Documents sent successfully', '5000', 'success'); $(this).remove()"></style>
<?php endif; ?>
