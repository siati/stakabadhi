<?php
/* @var $mail common\models\DocumentsMailings */
?>

<div class="mail-body">
    <?= $mail->body ?>

    <?php if (!empty($mail->footer)): ?>

        <div class="mail-footer">

            <i><?= $mail->footer ?></i>

        </div>

    <?php endif; ?>

</div>