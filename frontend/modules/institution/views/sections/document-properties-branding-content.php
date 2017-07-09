<?php /* @var $url string */ ?>
<?php /* @var $link string */ ?>
<?php /* @var $name string */ ?>

<div class="brnd-ctnt-tbl" <?php if (!empty($link)): ?> onclick="popWindow('<?= $link ?>', '<?= $name ?>')" <?php endif; ?> >
    <div class="brnd-ctnt-tbl-pn" style="background-image: url('<?= $url ?>')"></div>
</div>