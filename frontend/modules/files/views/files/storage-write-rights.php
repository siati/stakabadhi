<?php /* @var $permissions common\models\FilePermissions */ ?>

<?php use common\models\StoreLevels; ?>

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
                        <?php for ($i = 0; $i < 100; $i++): ?>
                        <tr str-id="<?= $storage->id ?>" str-lvl="<?= $permission->store_level ?>" title="<?= $name = ucwords(strtolower($storage->name)) ?>">
                            <td class="td-left kasa-pointa str-nm"><?= substr($name, 0, 49) ?></td>
                        </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php endif; ?>