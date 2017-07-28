<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $storage common\models\Stores|common\models\Compartments|common\models\SubCompartments|common\models\SubSubCompartments|common\models\Shelves|common\models\Drawers|common\models\Batches|common\models\Folders|common\models\Files */
/* @var $editor boolean */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trck-nts-prpts pull-left">

    <div class="trck-nts-prpts-pn">
        <div class="trck-nts-prpts-pn-pn">
            Contacts
        </div>
    </div>

    <div class="trck-nts-prpts-fm">
        <div class="trck-nts-prpts-fm-pn">
            <div class="notes-form" style="height: 100%; overflow-x: hidden">

                <?php $form = ActiveForm::begin(['id' => 'form-notes', 'enableAjaxValidation' => true]); ?>

                <?= Html::activeHiddenInput($model, 'id') ?>

                <?= Html::activeHiddenInput($model, 'store_level') ?>

                <?= Html::activeHiddenInput($model, 'store_id') ?>

                <?= $form->field($model, 'notes')->textarea(['rows' => 7, 'style' => 'margin-top:10px; resize: none'])->label(false) ?>

                <?php ActiveForm::end(); ?>

                <div class="btn btn-sm btn-success pull-right" onclick="saveTrackingNotes('form-notes')">Save</div>

            </div>
        </div>
    </div>

</div>

<div class="trck-nts-tmln pull-right">
    <div class="trck-nts-tmln-fm">
        <div class="trck-nts-tmln-fm-pn">
            <?= $notes_timeline ?>
        </div>

        <div class="trck-nts-tmln-btns">
            <div class="btn btn-primary pull-left rfrs-nts" onclick="storeTimeline($('#filetrackingnotes-store_level').val(), $('#filetrackingnotes-store_id').val())"><i class="glyphicon glyphicon-refresh"> </i> Refresh</div>
            <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
        </div>
    </div>
</div>