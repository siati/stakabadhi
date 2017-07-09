<?php /* @var $sections common\models\Sections */ ?>
<?php /* @var $document common\models\Documents */ ?>
<?php /* @var $user integer */ ?>
<?php /* @var $selected integer */ ?>

<?php

use common\models\Sections;
use common\models\DocumentsPermissions;
?>

<?php $is_admin = Yii::$app->user->identity->userStillHasRights([\common\models\User::USER_SUPER_ADMIN, \common\models\User::USER_ADMIN]) ?>

<?php $i = 0 ?>

<table>
    <?php foreach ($sections as $section): ?>
        <?php if (($privilege = $document->userSectionDocumentPrivilege($section->id, $user, true, !$is_admin && !$section->userHasPreAlterRights($user), false, Sections::remove_user)) == DocumentsPermissions::file_alter || $is_admin): ?>
            <tr tr-sctn="<?= $section->id ?>">
                <td class="td-right td-pdg-rgt"><?= ++$i ?>.</td>
                <td class="sctns-lst-td <?= $privilege ?> <?= ($active = $section->active == Sections::section_active) ? 'sctns-lst-td-tck' : 'sctns-lst-td-crs' ?> <?= ($isSelected = $section->id == $selected) ? 'sct-hr' : '' ?> <?= $isSelected ? 'has-cstm-mn' : '' ?>" <?php if ($isSelected): ?>cstm-mn=".custom-menu-dcmnt-rgts"<?php endif; ?> onclick="clickSection($(this).parent().attr('tr-sctn'), false, false)">
                    <div class="pull-left sct-nm <?= $isSelected ? 'has-cstm-mn' : '' ?>" <?php if ($isSelected): ?>cstm-mn=".custom-menu-dcmnt-rgts"<?php endif; ?>><?= ucwords(strtolower($section->name)) ?></div>
                    <div class="pull-right sct-actv" onclick="clickSection($(this).parent().parent().attr('tr-sctn'), true, false)"><div class="glyphicon <?= $active ? 'glyphicon-ok' : 'glyphicon-ban-circle' ?>"></div></div>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>