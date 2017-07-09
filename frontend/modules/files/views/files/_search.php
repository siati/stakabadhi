<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\searchModels\FilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'store') ?>

    <?= $form->field($model, 'compartment') ?>

    <?= $form->field($model, 'sub_compartment') ?>

    <?= $form->field($model, 'sub_sub_compartment') ?>

    <?php // echo $form->field($model, 'shelf') ?>

    <?php // echo $form->field($model, 'drawer') ?>

    <?php // echo $form->field($model, 'batch') ?>

    <?php // echo $form->field($model, 'folder') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'reference_no') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
