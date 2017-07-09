<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\StaticMethods;
use common\models\StoreLevels;
use common\models\Stores;


/* @var $this yii\web\View */
/* @var $model common\models\Compartments */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $storeLevel = StoreLevels::stores; ?>

<div class="files-form" style="height: 90%; overflow-x: hidden">
    
    <?php $form = ActiveForm::begin(['id' => 'form-compartment-move', 'enableAjaxValidation' => true]); ?>
    
    <?= Html::activeHiddenInput($model, 'id') ?>
    
    <input name="mv" type="hidden" />
    
    <?= $form->field($model, 'store')->dropDownList(StaticMethods::modelsToArray(Stores::allStores(), 'id', 'name'), []) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="moveStorage('form-compartment-move', '<?= $storeLevel ?>')">Save</div>
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>

<style onload="$('.yii-modal-head').html('Move ' + '<?= StoreLevels::returnLevel(StoreLevels::compartments)->name ?>'); $(this).remove();"></style>