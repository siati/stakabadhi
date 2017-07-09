<?php /* @var $folders mixed */ ?>
<?php /* @var $files mixed */ ?>

<div class="inst-ctnt-pn-dr">
    <div class="inst-ctnt-pn-dr-pn<?= empty($addFolder) ? '' : ' add-fldr' ?><?= empty($customMenu) ? '' : ' has-cstm-mn' ?>" <?php if (!empty($customMenu)): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?>>
        <?= $folders ?>
    </div>
</div>

<div class="inst-ctnt-pn-fl">
    <div class="inst-ctnt-pn-fl-pn<?= empty($dropable) ? '' : ' dropable' ?><?= empty($addFolder) ? '' : ' add-fldr' ?><?= empty($customMenu) ? '' : ' has-cstm-mn' ?>" <?php if (!empty($customMenu)): ?>cstm-mn=".custom-menu-nav-fldr-nds"<?php endif; ?>>
        <?= $files ?>
    </div>
</div>