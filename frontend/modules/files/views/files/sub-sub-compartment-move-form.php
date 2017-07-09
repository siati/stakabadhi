<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\StaticMethods;
use common\models\StoreLevels;
use common\models\Stores;
use common\models\Compartments;
use common\models\SubCompartments;


/* @var $this yii\web\View */
/* @var $model common\models\SubSubCompartments */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $storeLevel = StoreLevels::stores; ?>
<?php $compartmentLevel = StoreLevels::compartments; ?>
<?php $subcompartmentLevel = StoreLevels::subcompartments; ?>

<div class="files-form" style="height: 90%; overflow-x: hidden">
    
    <?php $form = ActiveForm::begin(['id' => 'form-subsubcompartment-move', 'enableAjaxValidation' => true]); ?>
    
    <?= Html::activeHiddenInput($model, 'id') ?>
    
    <input name="mv" type="hidden" />
    
    <?= $form->field($model, 'store')->dropDownList(StaticMethods::modelsToArray(Stores::allStores(), 'id', 'name'), ['onchange' => "dynamicStorages2('$compartmentLevel', $(this).val(), $('#subsubcompartments-compartment').val(), null, 'subsubcompartments-compartment', true)"]) ?>
    
    <?= $form->field($model, 'compartment')->dropDownList(StaticMethods::modelsToArray(Compartments::compartmentsForStore($model->store, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$subcompartmentLevel', $(this).val(), $('#subsubcompartments-sub_compartment').val(), null, 'subsubcompartments-sub_compartment', true)"]) ?>
    
    <?= $form->field($model, 'sub_compartment')->dropDownList(StaticMethods::modelsToArray(SubCompartments::searchSubcompartments(null, $model->compartment, true), 'id', 'name'), []) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="moveStorage('form-subsubcompartment-move', '<?= $subcompartmentLevel ?>')">Save</div>
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>

<style onload="$('.yii-modal-head').html('Move ' + '<?= StoreLevels::returnLevel(StoreLevels::subsubcompartments)->name ?>'); $(this).remove();"></style>