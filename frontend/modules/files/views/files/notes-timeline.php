<?php
/* @var $notes common\models\FileTrackingNotes */
?>
<?php if (empty($notes)): ?>
    <div style="height: 100%; width: 100%; display: table">
        <div style="height: 100%; width: 100%; display: table-cell; text-align: center; vertical-align: middle">
            <h3>There are no notes for this item</h3>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($notes as $note): ?>
        <div style="border-bottom: 2px solid #ddd; padding: 1px 2px 3px 2px; margin-bottom: 15px">
            <div class="pull-left"><smll><b><?= $note->created_by ?></b></smll></div>
            <div class="pull-right"><small><b><?= $note->created_at ?></b></small></div>

            <div style="clear: both"><?= $note->notes ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
