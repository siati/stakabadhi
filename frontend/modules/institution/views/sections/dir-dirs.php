<?php /* @var $documents common\models\Documents */ ?>
<?php /* @var $parent common\models\Documents */ ?>
<?php /* @var $selected integer */ ?>

<?php $i = 0 ?>

<?php $is_admin = Yii::$app->user->identity->userStillHasRights([\common\models\User::USER_SUPER_ADMIN, \common\models\User::USER_ADMIN]) ?>

<?php $user = Yii::$app->user->identity->id ?>

<table>
    <?php foreach ($documents as $document): ?>
        <?php if ($is_admin || $document->userPreferredDocumentPrivilege($user, false, true, false, \common\models\Documents::file_deny) == common\models\Documents::file_alter): ?>
            <tr tr-dcmnt="<?= $document->id ?>" tr-fldr="<?= $document->filename ?>" tr-lvl="<?= $document->file_level ?>" tr-stts="<?= $document->status ?>">
                <td class="td-right td-pdg-rgt"><?= ++$i ?>.</td>
                <td class="dcmts-lst-td <?= $document->id == $selected ? 'doc-hr' : '' ?> has-cstm-mn" cstm-mn=".custom-menu-dcmnt-nvgtn" onclick="clickDocList($(this).parent().attr('tr-dcmnt'))">
                    <div class="pull-left has-cstm-mn" cstm-mn=".custom-menu-dcmnt-nvgtn"><?= ucwords(strtolower($document->name)) ?></div>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>