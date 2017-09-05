<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Classes;
use common\models\StaticMethods;

/* @var $this yii\web\View */
/* @var $models common\models\Classes */
/* @var $auth_key string */
/* @var $saved array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form" style="height: 95%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-school-classes', 'enableAjaxValidation' => true, 'fieldConfig' => ['options' => ['class' => 'form-group-sm']]]); ?>

    <input type="hidden" name="auth_key" value="<?= $auth_key ?>" />

    <table>
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 20%">Class</th>
            <th style="width: 15%">Stream</th>
            <th style="width: 15%">Symbol</th>
            <th style="width: 35%">Name</th>
            <th style="width: 10%">Active</th>
        </tr>

        <?php $no = 0 ?>

        <tbody>
            <?php foreach ($models as $model): ?>

                <?php $id = empty($model->id) ? '0' : $model->id ?>

                <?php
                $classes = [];

                foreach (StaticMethods::classesForDropdown($model->level) as $cls => $class)
                    if ($model->isNewRecord || $cls == $model->class)
                        $classes[$cls] = $class;
                ?>

                <tr>
                    <?= Html::activeHiddenInput($model, "[$id]created_by") ?>
                    <?= Html::activeHiddenInput($model, "[$id]updated_by") ?>
                    <td class="td-cnter td-pdg-vtc"><b><?= ++$no ?>.</b></td>
                    <td class="td-pdg-rgt-lft td-pdg-vtc"><?= $form->field($model, "[$id]class")->dropDownList(empty($classes) ? [] : $classes)->label(false) ?></td>
                    <td class="td-pdg-rgt-lft td-pdg-vtc"><?= $form->field($model, "[$id]stream")->textInput(['maxlength' => true, 'style' => 'text-align: center', 'placeholder' => 'E', 'readonly' => !$model->isNewRecord])->label(false) ?></td>
                    <td class="td-pdg-rgt-lft td-pdg-vtc"><?= $form->field($model, "[$id]symbol")->textInput(['maxlength' => true, 'style' => 'text-align: center', 'placeholder' => '1E'])->label(false) ?></td>
                    <td class="td-pdg-rgt-lft td-pdg-vtc"><?= $form->field($model, "[$id]name")->textInput(['maxlength' => true, 'style' => 'text-align: center', 'placeholder' => 'One East'])->label(false) ?></td>
                    <td class="td-pdg-rgt-lft td-pdg-vtc"><?= $form->field($model, "[$id]active")->dropDownList([$actv = Classes::active => ucfirst($actv), $actv = Classes::not_active => ucfirst($actv)])->label(false) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php ActiveForm::end(); ?>

</div>

<style onload="

<?php foreach ($saved as $id): ?>
            commitClass('<?= $models[$id]->level ?>', '<?= $models[$id]->class ?>', '<?= $models[$id]->stream ?>', '<?= $models[$id]->symbol ?>', '<?= $models[$id]->name ?>', '<?= $models[$id]->active ?>');
<?php endforeach; ?>

        $('#form-school-classes .help-block').hide();

        $(this).remove();
       "
></style>

<div style="height: 5%">
    <div class="btn btn-success pull-left" onclick="pushClasses()">Save</div>

    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>