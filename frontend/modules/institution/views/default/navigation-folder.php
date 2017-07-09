<div class="nvgtn-fldr-ctnr <?= $terminal ? 'u-ia' : '' ?> <?= $node ?>" id="<?= $uniqId = uniqid() ?>" lvl="<?= $level ?>" nm="<?= $folder ?>" rgt="<?= $right ?>" jih="<?= $node ?>" cld="<?= $id ?>" stts="<?= $status ?>" is-fl="<?= $dir_or_file ?>" yuu="<?= $parNode ?>" style="padding-left: <?= 15 * $level ?>px" title="<?= $folder_name ?>">
    <span class="glyphicon glyphicon-<?= $level === common\models\Documents::min_root_document_level ? ('briefcase') : ($open ? 'folder-open' : 'folder-close') ?> is-dir nvgtn-fldr-ctnr-glyph-lft <?php if ($dropable): ?>dropable<?php endif; ?> <?php if ($addFolder): ?>add-fldr<?php endif; ?> <?php if ($customMenu): ?>has-cstm-mn<?php endif; ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>">&nbsp;</span>
    <span class="nvgtn-fldr-ctnr-nm-txt <?php if ($dropable): ?>dropable<?php endif; ?> <?php if ($addFolder): ?>add-fldr<?php endif; ?> <?php if ($customMenu): ?>has-cstm-mn<?php endif; ?>" <?php if ($customMenu): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?> prnt="<?= $uniqId ?>"><?= $folder_name ?></span>
    <span class="glyphicon glyphicon-<?= $open ? 'minus' : 'plus' ?> nvgtn-fldr-ctnr-glyph-rgt" prnt="<?= $uniqId ?>">&nbsp;</span>
</div>