<?php
/* @var $versions common\models\Logs */
/* @var $filename string */
?>

<div style="width: 100%; height: 100%; overflow: hidden">
    <div style="width: 100%; height: 100%; overflow-x: hidden">

        <?php foreach ($versions as $version): ?>
            <div vrsn-hd="<?= $version->id ?>" class="vrsn-hd has-cstm-mn" cstm-mn=".custom-menu-vrsn-fls" aut="<?= $version->logAuthorName() ?>" typ="<?= $version->documentVersionType() ?>" doc="<?= $version->origin_id ?>" sz="<?= $version->documentVersionSize() ?>" dt="<?= $version->created_at ?>" onclick="versionWorkingOn($(this))">
                <div class="vrsn-hd-pn has-cstm-mn <?= $version->documentVersionIsCurrent($filename) ? 'crnt-vrsn' : '' ?>" cstm-mn=".custom-menu-vrsn-fls">
                    <div class="vrsn-hd-pn-img has-cstm-mn" cstm-mn=".custom-menu-vrsn-fls" style="background-image: url('<?= $version->documentVersionIcon(false) ?>')">
                        <h4><small><?= common\models\StaticMethods::dateString($version->created_at, common\models\StaticMethods::short) ?></small></h4>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>