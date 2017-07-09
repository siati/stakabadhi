<?php /* @var $dir_contents common\models\Sections */ ?>
<?php /* @var $rights array */ ?>
<?php /* @var $documents common\models\Documents */ ?>
<?php /* @var $is_admin boolean */ ?>

<?php

use common\models\Documents
?>

<?php foreach ($documents as $document): ?>

    <?php $right = $rights[$document->directory] ?>
    
    <?php $preferredRight = $preferredRights[$document->directory] ?>

    <?php $versions = $document->status > Documents::FILE_STATUS_DELETED && $document->hasVersions() && ($is_admin || $preferredRight == Documents::file_alter) ?>

    <div class="file-in-ctnt-pn<?= $dropable = $dropable && $right == Documents::file_alter ? ' dropable' : '' ?><?= $addFolder = $addFolder && ($is_admin || $right == Documents::file_alter) ? ' add-fldr' : '' ?><?= $document->opened_for_update == Documents::FILE_OPENED_FOR_UPDATE ? ' opn-4-updt' : '' ?><?= $document->opened_for_update_by == Yii::$app->user->identity->id ? ' lckd-by-usr' : '' ?><?= empty($versions) ? '' : ' has-vrsns' ?><?= empty($document->can_be_updated) ? '' : ' can-updt' ?><?= empty($document->can_be_moved) ? '' : ' can-mv' ?><?= empty($document->can_be_deleted) ? '' : ' can-dlt' ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> id="<?= $uniqId = uniqId() ?>" rgt="<?= $right ?>" prfrgt="<?= $preferredRight ?>" dcl="<?= $document->id ?>" style="width: <?= 100 / 7 ?>%" nm="<?= $document->justDbFileName() ?>" title="<?= $title = ucwords(strtolower(Documents::fileNameToDisplay($dir_contents[$document->id], $document->name))) ?>">

        <div class="file-in-ctnt-pn-icn<?= $dropable ?><?= $addFolder ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>" style="background-image: url('<?= $document->fileIcon(false) ?>')"></div>

        <div class="file-in-ctnt-pn-ttl<?= $dropable ?><?= $addFolder ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>"><?= $title ?></div>

    </div>

<?php endforeach; ?>