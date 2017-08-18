<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schemes-of-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'school')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'term')->textInput() ?>

    <?= $form->field($model, 'class')->textInput() ?>

    <?= $form->field($model, 'stream')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput() ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'submitted_as')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject_teacher')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject_teacher_tsc_no')->textInput() ?>

    <?= $form->field($model, 'subject_head')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject_head_tsc_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dept_head')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dept_head_tsc_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'school_head')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'school_head_tsc_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'submitted_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'submitted_at')->textInput() ?>

    <?= $form->field($model, 'received')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'received_by')->textInput() ?>

    <?= $form->field($model, 'received_at')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
