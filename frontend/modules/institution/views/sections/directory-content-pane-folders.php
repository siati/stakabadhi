<?php /* @var $dir_contents array */ ?>
<?php /* @var $rights array */ ?>
<?php /* @var $documents common\models\Documents */ ?>
<?php /* @var $is_admin boolean */ ?>

<?php

use common\models\Documents
?>

<?php foreach ($documents as $document): ?>

    <?php $addFolder = Documents::folderCanBeAddedFolder($dir_contents[$document->id]) ?>

    <?php $right = $rights[$document->id] ?>
    
    <?php $preferredRight = $preferredRights[$document->id] ?>

    <div class="fldr-in-ctnt-pn<?= $dropable = $dropable && $right == Documents::file_alter ? ' dropable' : '' ?><?= $addFolder = $addFolder && ($is_admin || $right == Documents::file_alter) ? ' add-fldr' : '' ?><?= empty($document->can_be_moved) ? '' : ' can-mv' ?><?= empty($document->can_be_deleted) ? '' : ' can-dlt' ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> id="<?= $uniqId = uniqId() ?>" rgt="<?= $right ?>" prfrgt="<?= $preferredRight ?>" dcl="<?= $document->id ?>" style="width: 25%" nm="<?= $document->justDbFileName() ?>" title="<?= $title = ucwords(strtolower(Documents::fileNameToDisplay($dir_contents[$document->id], $document->name))) ?>">

        <div class="fldr-in-ctnt-pn-icn is-dir<?= $dropable ?><?= $addFolder ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>" style="background-image: url('<?= $document->fileIcon(false) ?>')"></div>

        <div class="fldr-in-ctnt-pn-ttl<?= $dropable ?><?= $addFolder ?><?= $customMenu ? ' has-cstm-mn' : '' ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>"><?= $title ?></div>

    </div>

<?php endforeach; ?>