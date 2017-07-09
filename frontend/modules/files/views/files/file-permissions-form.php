<?php /* @var $model common\models\FilePermissions */ ?>
<?php /* @var $users common\models\User */ ?>

<?php

use common\models\FilePermissions
?>

<div style="height: 95%; overflow-x: hidden">
    <table str-lvl="<?= $model->store_level ?>"  str-id="<?= $model->store_id ?>"  prm-id="<?= $model->id ?>">
        <?php foreach ($users as $user): ?>
        <tr class="fl-prmsn-tr" usr-id="<?= $user->id ?>">
                <td class="td-center"><span class="btn btn-xs btn-<?= ($rgt = $model->userSubjectiveRight($user->id)) == FilePermissions::write ? ('success') : ($rgt == FilePermissions::read ? 'info' : 'default') ?> fl-prmsn-eff"></span></td>
                <td class="td-left" style="padding: 2px"><?= $user->name ?></td>
                <td class="td-right" style="padding: 2px">
                    <div class="btn btn-xs btn-<?= ($rgt = $model->userRight($user->id)) == FilePermissions::write ? ('success') : ($rgt == FilePermissions::read ? 'info' : 'default') ?>" onclick="rotatePermissionButton($(this), true, true)"><?= $rgt ?></div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div style="height: 5%; padding-top: 10px">
    <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
</div>