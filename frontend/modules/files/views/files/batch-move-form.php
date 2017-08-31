<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\StaticMethods;
use common\models\StoreLevels;
use common\models\Stores;
use common\models\Compartments;
use common\models\SubCompartments;
use common\models\SubSubCompartments;
use common\models\Shelves;
use common\models\Drawers;


/* @var $this yii\web\View */
/* @var $model common\models\Batches */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $storeLevel = StoreLevels::stores; ?>
<?php $compartmentLevel = StoreLevels::compartments; ?>
<?php $subcompartmentLevel = StoreLevels::subcompartments; ?>
<?php $subsubcompartmentLevel = StoreLevels::subsubcompartments; ?>
<?php $shelfLevel = StoreLevels::shelves; ?>
<?php $drawerLevel = StoreLevels::drawers; ?>

<div class="files-form" style="height: 90%; overflow-x: hidden">
    
    <?php $form = ActiveForm::begin(['id' => 'form-batch-move', 'enableAjaxValidation' => true]); ?>
    
    <?= Html::activeHiddenInput($model, 'id') ?>
    
    <input name="mv" type="hidden" />
    
    <?= $form->field($model, 'store')->dropDownList(StaticMethods::modelsToArray(Stores::allStores(), 'id', 'name', false), ['onchange' => "dynamicStorages2('$compartmentLevel', $(this).val(), $('#batches-compartment').val(), null, 'batches-compartment', true)"]) ?>
    
    <?= $form->field($model, 'compartment')->dropDownList(StaticMethods::modelsToArray(Compartments::compartmentsForStore($model->store, true, StoreLevels::all), 'id', 'name', false), ['onchange' => "dynamicStorages2('$subcompartmentLevel', $(this).val(), $('#batches-sub_compartment').val(), null, 'batches-sub_compartment', true)"]) ?>
    
    <?= $form->field($model, 'sub_compartment')->dropDownList(StaticMethods::modelsToArray(SubCompartments::searchSubcompartments(null, $model->compartment, true, StoreLevels::all), 'id', 'name', false), ['onchange' => "dynamicStorages2('$subsubcompartmentLevel', $(this).val(), $('#batches-sub_sub_compartment').val(), null, 'batches-sub_sub_compartment', true)"]) ?>
    
    <?= $form->field($model, 'sub_sub_compartment')->dropDownList(StaticMethods::modelsToArray(SubSubCompartments::searchSubsubcompartments(null, null, $model->sub_compartment, true, StoreLevels::all), 'id', 'name', false), ['onchange' => "dynamicStorages2('$shelfLevel', $(this).val(), $('#batches-shelf').val(), null, 'batches-shelf', true)"]) ?>
    
    <?= $form->field($model, 'shelf')->dropDownList(StaticMethods::modelsToArray(Shelves::searchShelves(null, null, null, $model->sub_sub_compartment, true, StoreLevels::all), 'id', 'name', false), ['onchange' => "dynamicStorages2('$drawerLevel', $(this).val(), $('#batches-drawer').val(), null, 'batches-drawer', true)"]) ?>
    
    <?= $form->field($model, 'drawer')->dropDownList(StaticMethods::modelsToArray(Drawers::searchDrawers(null, null, null, null, $model->shelf, true, StoreLevels::all), 'id', 'name', false), []) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 10%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="moveStorage('form-batch-move', '<?= $drawerLevel ?>')">Save</div>
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>

<style onload="$('.yii-modal-head').html('Move ' + '<?= StoreLevels::returnLevel(StoreLevels::batches)->name ?>'); $(this).remove();"></style>