<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\searchModels\SchemesOfWorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schemes-of-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'school') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'term') ?>

    <?= $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'stream') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'submitted_as') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'subject_teacher') ?>

    <?php // echo $form->field($model, 'subject_teacher_tsc_no') ?>

    <?php // echo $form->field($model, 'subject_head') ?>

    <?php // echo $form->field($model, 'subject_head_tsc_no') ?>

    <?php // echo $form->field($model, 'dept_head') ?>

    <?php // echo $form->field($model, 'dept_head_tsc_no') ?>

    <?php // echo $form->field($model, 'school_head') ?>

    <?php // echo $form->field($model, 'school_head_tsc_no') ?>

    <?php // echo $form->field($model, 'submitted_by') ?>

    <?php // echo $form->field($model, 'submitted_at') ?>

    <?php // echo $form->field($model, 'received') ?>

    <?php // echo $form->field($model, 'received_by') ?>

    <?php // echo $form->field($model, 'received_at') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
