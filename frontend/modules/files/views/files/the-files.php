<?php /* @var $files common\models\Files */ ?>
<?php /* @var $inactive boolean */ ?>

<?php $icon = \common\models\StaticMethods::documentVersionIcon('unknown', false); ?>

<?php foreach ($files as $file): ?>
    <div fl-hd="<?= $file->id ?>" class="fl-hd">
        <div class="fl-hd-pn">
            <div class="fl-hd-pn-img has-cstm-mn" cstm-mn=".custom-menu-strg-unts" onclick="selectedFileItem('<?= $file->id ?>')" style="background-image: url('<?= $icon ?>')"></div>
            
            <div class="fl-hd-pn-nm"><small><?= $file->name ?></small></div>
        </div>
    </div>
<?php endforeach; ?>