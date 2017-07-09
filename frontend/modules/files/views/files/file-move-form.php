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
use common\models\Batches;
use common\models\Folders;

/* @var $this yii\web\View */
/* @var $model common\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $storeLevel = StoreLevels::stores; ?>
<?php $compartmentLevel = StoreLevels::compartments; ?>
<?php $subcompartmentLevel = StoreLevels::subcompartments; ?>
<?php $subsubcompartmentLevel = StoreLevels::subsubcompartments; ?>
<?php $shelfLevel = StoreLevels::shelves; ?>
<?php $drawerLevel = StoreLevels::drawers; ?>
<?php $batchLevel = StoreLevels::batches; ?>
<?php $folderLevel = StoreLevels::folders; ?>

<div class="files-form" style="height: 92.5%; overflow-x: hidden">

    <?php $form = ActiveForm::begin(['id' => 'form-file-move', 'enableAjaxValidation' => true]); ?>

    <?= Html::activeHiddenInput($model, 'id') ?>

    <input name="mv" type="hidden" />

    <?= $form->field($model, 'store')->dropDownList(StaticMethods::modelsToArray(Stores::allStores(), 'id', 'name'), ['onchange' => "dynamicStorages2('$compartmentLevel', $(this).val(), $('#files-compartment').val(), null, 'files-compartment', true)"]) ?>

    <?= $form->field($model, 'compartment')->dropDownList(StaticMethods::modelsToArray(Compartments::compartmentsForStore($model->store, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$subcompartmentLevel', $(this).val(), $('#files-sub_compartment').val(), null, 'files-sub_compartment', true)"]) ?>

    <?= $form->field($model, 'sub_compartment')->dropDownList(StaticMethods::modelsToArray(SubCompartments::searchSubcompartments(null, $model->compartment, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$subsubcompartmentLevel', $(this).val(), $('#files-sub_sub_compartment').val(), null, 'files-sub_sub_compartment', true)"]) ?>

    <?= $form->field($model, 'sub_sub_compartment')->dropDownList(StaticMethods::modelsToArray(SubSubCompartments::searchSubsubcompartments(null, null, $model->sub_compartment, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$shelfLevel', $(this).val(), $('#files-shelf').val(), null, 'files-shelf', true)"]) ?>

    <?= $form->field($model, 'shelf')->dropDownList(StaticMethods::modelsToArray(Shelves::searchShelves(null, null, null, $model->sub_sub_compartment, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$drawerLevel', $(this).val(), $('#files-drawer').val(), null, 'files-drawer', true)"]) ?>

    <?= $form->field($model, 'drawer')->dropDownList(StaticMethods::modelsToArray(Drawers::searchDrawers(null, null, null, null, $model->shelf, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$batchLevel', $(this).val(), $('#files-batch').val(), null, 'files-batch', true)"]) ?>

    <?= $form->field($model, 'batch')->dropDownList(StaticMethods::modelsToArray(Batches::searchBatches(null, null, null, null, null, $model->drawer, true), 'id', 'name'), ['onchange' => "dynamicStorages2('$folderLevel', $(this).val(), $('#files-folder').val(), null, 'files-folder', true)"]) ?>

    <?= $form->field($model, 'folder')->dropDownList(StaticMethods::modelsToArray(Folders::searchFolders(null, null, null, null, null, null, $model->batch, true), 'id', 'name'), []) ?>

    <?php ActiveForm::end(); ?>

</div>

<div style="height: 7.5%; padding-top: 15px">
    <div class="btn btn-success pull-left" onclick="moveStorage('form-file-move', '<?= $folderLevel ?>')">Save</div>
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>

<style onload="$('.yii-modal-head').html('Move ' + '<?= StoreLevels::returnLevel(StoreLevels::files)->name ?>'); $(this).remove();"></style>