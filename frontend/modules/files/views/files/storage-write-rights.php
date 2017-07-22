<?php /* @var $permissions common\models\FilePermissions */ ?>

<?php

use common\models\StoreLevels; ?>

<?php if (empty($permissions)): ?>

    <div class="no-axn">
        <h4 class="no-axn-txt">No files under your administration</h4>
    </div>

<?php else: ?>

    <?php $user = Yii::$app->user->identity->id ?>

    <div class="prmsn-pn-eda" style="height: 10%">
        Under Your Administration
    </div>

    <div class="prmsn-pn-bdy" style="height: 90%">
        <div class="prmsn-pn-bdy-pn">
            <table class="table-hover">
                <?php foreach ($permissions as $permission): ?>
                    <?php if ($permission->userSubjectiveRight($user) == common\models\FilePermissions::write): ?>

                        <?php $storage = StoreLevels::storageByID($permission->store_level, $permission->store_id) ?>

                        <tr str-id="<?= $storage->id ?>" str-lvl="<?= $permission->store_level ?>" title="<?= $name = ucwords(strtolower($storage->name)) ?>"
                            <?php if (isset($storage->store)): ?>str-lvl-<?= StoreLevels::stores ?>="<?= $storage->store ?>" <?php endif; ?>
                            <?php if (isset($storage->compartment)): ?>str-lvl-<?= StoreLevels::compartments ?>="<?= $storage->compartment ?>" <?php endif; ?>
                            <?php if (isset($storage->sub_compartment)): ?>str-lvl-<?= StoreLevels::subcompartments ?>="<?= $storage->sub_compartment ?>" <?php endif; ?>
                            <?php if (isset($storage->sub_sub_compartment)): ?>str-lvl-<?= StoreLevels::subsubcompartments ?>="<?= $storage->sub_sub_compartment ?>" <?php endif; ?>
                            <?php if (isset($storage->shelf)): ?>str-lvl-<?= StoreLevels::shelves ?>="<?= $storage->shelf ?>" <?php endif; ?>
                            <?php if (isset($storage->drawer)): ?>str-lvl-<?= StoreLevels::drawers ?>="<?= $storage->drawer ?>" <?php endif; ?>
                            <?php if (isset($storage->batch)): ?>str-lvl-<?= StoreLevels::batches ?>="<?= $storage->batch ?>" <?php endif; ?>
                            <?php if (isset($storage->folder)): ?>str-lvl-<?= StoreLevels::folders ?>="<?= $storage->folder ?>" <?php endif; ?>
                            onclick="customStoreNavigator($(this))">
                            <td class="td-left kasa-pointa str-nm"><?= substr($name, 0, 49) ?></td>
                        </tr>

                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php endif; ?>