<?php
/* @var $this yii\web\View */
/* @var $model common\models\Sections */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
?>

<div>
    <?php $form = ActiveForm::begin(['id' => 'form-sections', 'enableAjaxValidation' => true, 'validationUrl' => ['details?section='], 'fieldConfig' => ['options' => ['class' => 'form-group-sm']]]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <?= $form->field($model, 'name', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-pencil"></i>']]])->label('Group Name<small style="font-weight: normal"><i> - capitalize each word e.g. Finance Group</i></small>') ?>

    <?= $form->field($model, 'description', ['addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-align-justify"></i>']]])->textarea(['rows' => 2, 'style' => 'resize: none'])->label('Group Description<small style="font-weight: normal"><i> - sentence case e.g. Staff in the finance department</i></small>') ?>

    <?php ActiveForm::end(); ?>
</div>

<!-- ensure consistency between selected section status in section and in form here -->
<style
    onload="
            $('.rmv-sctn').children().removeClass((actv = '<?= $model->active == common\models\Sections::section_active ?>') ? 'glyphicon-ban-circle' : 'glyphicon-ok').addClass(actv ? 'glyphicon-ok' : 'glyphicon-ban-circle');
            $(this).remove();
    "
    >
</style>
<!-- ensure consistency between selected section status in section and in form here -->