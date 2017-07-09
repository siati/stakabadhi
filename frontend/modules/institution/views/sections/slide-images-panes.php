<?php /* @var $images common\models\SlideImages */ ?>
<?php /* @var $inactive boolean */ ?>

<?php foreach ($images as $image): ?>
    <div img-hd="<?= $image->id ?>" class="img-hd">
        <div class="img-hd-pn" onclick="imageOntoForm($(this).parent().attr('img-hd'))">
            <div class="img-hd-pn-img" style="background-image: url('<?= $image->imageLocationUrl() ?>')"></div>

            <div class="img-hd-pn-nm"><small><?= "$image->name." . $image->imageExtesion() ?></small></div>
        </div>
    </div>
<?php endforeach; ?>

<style
    onload=
    "
    <?php if ($inactive): ?>
                $('#imgs-inactv').show();
                $('#imgs-actv').hide();
                $('#imgs-hdng').text('Currently Active Images');
    <?php else: ?>
                $('#imgs-inactv').hide();
                $('#imgs-actv').show();
                $('#imgs-hdng').text('Currently Inactive Images');
    <?php endif; ?>

            $(this).remove();
    "
></style>