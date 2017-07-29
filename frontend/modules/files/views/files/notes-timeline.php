<?php /* @var $notes common\models\FileTrackingNotes */ ?>

<?php

use common\models\User;
use common\models\StaticMethods;
?>

<?php if (empty($notes)): ?>
    <div class="no-note-tbl">
        <div class="no-note-cell">
            <h3><i>There are no notes for this item</i></h3>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($notes as $note): ?>
        <div class="note-ctnr">

            <div class="td-left"><small><u><?= StaticMethods::dateString($note->created_at, StaticMethods::longest) . ' @' . substr($note->created_at, 11) ?>&nbsp;</u></small></div>

            <div class="td-justify"><small><b><i><?= $note->notes ?></i></b></small></div>

            <div class="td-right"><small><?= User::returnUser($note->created_by)->name ?></small></div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>
