<?php /* @var $storeLevels common\models\StoreLevels */ ?>

<?php

use kartik\form\ActiveForm;
use common\models\User;
use common\models\StoreLevels;
use common\models\StaticMethods;

$is_admin = Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]);

$is_admin ? $cursor = null : $cursor = '; cursor: pointer';
?>

<?php foreach ($storeLevels as $storeLevel): ?>
    <?php if ($storeLevel->level < StoreLevels::files): ?>

        <?php
        $selected = null;
        
        foreach ($storages = $storeLevel->level == StoreLevels::stores ? StaticMethods::modelsToArray(StoreLevels::defaultStoragesToLoad($storeLevel->level, null, true), 'id', 'name') : [] as $level => $name)
            if (empty($selected))
                $selected = $level;
        ?>

        <?php $form = ActiveForm::begin(['id' => $form_id = uniqid(), 'enableAjaxValidation' => true]); ?>

        <?= $form->field($storeLevel, "[$storeLevel->level]name", ['template' => '{input}'])->textInput(['lvl' => $storeLevel->level, 'fm-id' => $form_id, 'readonly' => !$is_admin, 'onclick' => $is_admin ? null : "$('#storelevel-$storeLevel->level').focus()", 'style' => "background-color: inherit; margin-top: 17.5px; margin-bottom: 0; font-weight: bold; padding: 0$cursor; border: none"]) ?>

        <?php ActiveForm::end(); ?>

        <div class="input-group" style="margin-top: 0">
            <span class="input-group-addon kasa-pointa">
                <i class="glyphicon glyphicon-list"></i>
            </span>
            <select id="storelevel-<?= $storeLevel->level ?>" class="form-control" <?php if (!empty($selected)): ?> value="<?= $selected ?>" <?php endif; ?> lvl="<?= $storeLevel->level ?>" >
                <option class="all-optns" value="">-- Select --</option>
                <?php foreach ($storages as $level => $name): ?>
                    <option value="<?= $level ?>" <?php if (!empty($selected) && $level == $selected): ?> selected="selected" <?php endif; ?> ><?= $name ?></option>
                <?php endforeach; ?>
            </select>

        </div>
    <?php endif; ?>
<?php endforeach; ?>