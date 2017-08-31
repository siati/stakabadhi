<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Classes;
use common\models\StaticMethods;
use common\models\Subjects;

/* @var $this yii\web\View */
/* @var $model common\models\SchemesOfWork */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
foreach (Classes::distinctSchoolClassesWithoutStreams($model->school, $level, Classes::active) as $class)
    $classes[$class->class] = StaticMethods::schoolLevelClassTitle($level) . ' ' . StaticMethods::classes($level)[$class->class][StaticMethods::name];

$model->isNewRecord ? $model->class = StaticMethods::form_one : '';

$active = Classes::active;
    ?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-sceheme-of-work', 'enableAjaxValidation' => true]); ?>

    <input type="hidden" name="auth_key" value="<?= $auth_key ?>" />

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= Html::activeHiddenInput($model, 'school') ?>

    <?= Html::activeHiddenInput($model, 'location') ?>

    <?= Html::activeHiddenInput($model, 'submitted_by') ?>

    <?= Html::activeHiddenInput($model, 'submitted_as') ?>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'year')->dropDownList([$yr = date('Y') - 1 => $yr, ++$yr => $yr, ++$yr => $yr]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'term')->dropDownList(StaticMethods::terms($level)) ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'class')->dropDownList(empty($classes) ? [] : $classes, ['onchange' => "serverClassChanged($(this).val(), $('#schemesofwork-stream').val(), $('#schemesofwork-subject').val(), '$active')"]) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 25%"><?= $form->field($model, 'stream')->dropDownList(StaticMethods::modelsToArray(Classes::forSchoolLevelAndClass($model->school, $level, $model->class, $active), 'id', 'name', false)) ?></td>
            <td class="td-pdg-rgt-lft" style="width: 50%"><?= $form->field($model, 'subject')->dropDownList(StaticMethods::modelsToArray(Subjects::forSchoolLevelDeptAndClass($model->school, $level, null, $model->class, $active), 'id', 'name', true)) ?></td>
        </tr>
    </table>

    <?= $form->field($model, 'notes')->textArea(['maxlength' => true, 'style' => 'text-align: justify; resize: none']) ?>

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

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="pushSchemeOfWork()">Save</div>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>
