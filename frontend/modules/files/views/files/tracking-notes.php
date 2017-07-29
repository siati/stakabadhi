<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FileTrackingNotes */
/* @var $level common\models\StoreLevels */
/* @var $storage common\models\Stores|common\models\Compartments|common\models\SubCompartments|common\models\SubSubCompartments|common\models\Shelves|common\models\Drawers|common\models\Batches|common\models\Folders|common\models\Files */
/* @var $editor boolean */
/* @var $notes_timeline mixed|string */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trck-nts-prpts pull-left">

    <div class="trck-nts-prpts-pn">
        <div class="trck-nts-prpts-pn-pn">

            <div style="height: 5%"><h4><i><?= $level->name ?></i></h4></div>

            <div class="fl-icn-img" style="background-image: url('<?= Yii::$app->homeUrl . '../../common/assets/icons/doc-icons/document.png' ?>')"></div>

            <div style="height: 12.5%; padding-top: 20px">
                <table>
                    <tr><td class="td-left" style="width:22.5%"><b>Ref. No.</b></td><td class="td-left" style="width: 5%"><b>:</b></td><td class="td-justify"><?= $storage->reference_no ?></td></tr>
                    <tr><td class="td-left"><b>Name</b></td><td class="td-left"><b>:</b></td><td class="td-justify"><?= $storage->name ?></td></tr>
                </table>
            </div>

            <div class="strg-dscp-tbl"><div class="strg-dscp-cell"><i><?= $storage->description ?></i></div></div>

        </div>
    </div>

    <div class="trck-nts-prpts-fm">
        <div class="trck-nts-prpts-fm-pn">
            <div class="notes-form" style="height: 100%; overflow-x: hidden">

                <?php $form = ActiveForm::begin(['id' => 'form-notes', 'enableAjaxValidation' => true]); ?>

                <?= Html::activeHiddenInput($model, 'id') ?>

                <?= Html::activeHiddenInput($model, 'store_level') ?>

                <?= Html::activeHiddenInput($model, 'store_id') ?>

                <?= $form->field($model, 'notes')->textarea(['rows' => empty($editor) ? 9 : 7, 'disabled' => empty($editor), 'style' => 'margin-top:10px; resize: none'])->label(false) ?>

                <?php ActiveForm::end(); ?>

                <?php if (!empty($editor)): ?>
                    <div class="btn btn-sm btn-success pull-right" onclick="saveTrackingNotes('form-notes')">Save</div>
                <?php endif; ?>

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