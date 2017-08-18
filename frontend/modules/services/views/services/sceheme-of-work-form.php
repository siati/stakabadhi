<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-sceheme-of-work', 'enableAjaxValidation' => true]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= Html::activeHiddenInput($model, 'school') ?>

    <?= Html::activeHiddenInput($model, 'location') ?>

    <?= Html::activeHiddenInput($model, 'submitted_by') ?>

    <?= Html::activeHiddenInput($model, 'submitted_as') ?>
    
    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'year')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'term')->textInput() ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'class')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'stream')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject')->textInput() ?></td>
        </tr>
    </table>

    <?= $form->field($model, 'notes')->textArea() ?>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 65%"><?= $form->field($model, 'subject_teacher')->textInput() ?></td>
            <td class="td-pdg-rgt-lft" style="width: 35%"><?= $form->field($model, 'subject_teacher_tsc_no')->textInput() ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'subject_head')->textInput() ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'subject_head_tsc_no')->textInput() ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'dept_head')->textInput() ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'dept_head_tsc_no')->textInput() ?></td>
        </tr>

        <tr>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'school_head')->textInput() ?></td>
            <td class="td-pdg-rgt-lft"><?= $form->field($model, 'school_head_tsc_no')->textInput() ?></td>
        </tr>
    </table>
    
    <?= $form->errorSummary($model) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="pushShemeOfWork()">Save</div>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>
