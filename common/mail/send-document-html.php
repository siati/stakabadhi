<?php
/* @var $mail common\models\DocumentsMailings */
?>

<div style="font-size: 12px; text-align: justify">
    <?= $mail->body ?>

    <?php if (!empty($mail->footer)): ?>
        <div class="divider"></div>

        <div style="font-size: 10px">
            <i><?= $mail->footer ?></i>
        </div>
    <?php endif; ?>

</div>