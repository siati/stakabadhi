
<div class="inst-prpt-pn-sub-pn-file-name-pr inst-prpt-pn-sub-pn-top" style="height: 15%">
    <div class="inst-prpt-pn-sub-pn-file-name" style="height: 100%">
        <div class="file-name-field<?= $updateMoveDrop ? ' contenteditable' : '' ?>" cdl="<?= $id ?>" stts="<?= $status ?>" type="text" <?php if ($updateMoveDrop): ?>contenteditable="true" <?php else: ?>style="background-color: inherit" <?php endif; ?>max="60" onblur="changeNameOfFile($(this))"><?= $filename ?></div>
    </div>
</div>

<div style="height: 85%; overflow-x: hidden">
    <table>
        <tr><td class="td-left">No. Of Items</td> <td class="td-cnter">:</td> <td class="td-left"><?= is_numeric($fileItems) ? ("$fileItems Item" . ($fileItems == 1 ? '' : 's')) : ('N/A') ?></td></tr>
        <?php if (!empty($description)): ?>
            <tr><td class="td-left">File Type</td> <td class="td-cnter">:</td> <td class="td-left"><?= empty($description) ? '' : $description ?></td></tr>
        <?php endif; ?>
        <tr><td class="td-left">File Size</td> <td class="td-cnter">:</td> <td class="td-left"><?= $fileSize ?></td></tr>
        <tr><td class="td-left">Directory</td> <td class="td-cnter">:</td> <td class="td-left"><small><?= $location ?></small></td></tr>
        <tr><td class="td-left">Description</td> <td class="td-cnter">:</td> <td class="td-left"><span class="btn btn-xs btn-default" style="background-color: inherit" onclick="updateDocDescription()">Click To View</span></td></tr>
        
        <?php if (!empty($versions)): ?>
            <tr><td class="td-left">Versions</td> <td class="td-cnter">:</td> <td class="td-left"><span class="btn btn-xs btn-default" style="background-color: inherit" onclick="loadVersions()">Document Versions</span></td></tr>
        <?php endif; ?>
        
        <tr><td colspan="3">&nbsp;</td></tr>

        <tr><td class="td-left">Updatable</td> <td class="td-cnter">:</td> <td class="td-left" style="padding: 2px"><div class="btn btn-xs btn-<?= $update ? 'success' : 'warning' ?>" cdl="<?= $id ?>" stts="<?= $status ?>" <?php if ($updateMoveDrop): ?>onclick="fileUpdatability($(this), 'can_be_updated')"<?php endif; ?>><?= $update ? 'Yes' : 'No' ?></div></td></tr>
        <tr><td class="td-left">Movable</td> <td class="td-cnter">:</td> <td class="td-left" style="padding: 2px"><div class="btn btn-xs btn-<?= $move ? 'success' : 'warning' ?>" cdl="<?= $id ?>" stts="<?= $status ?>" <?php if ($updateMoveDrop): ?>onclick="fileUpdatability($(this), 'can_be_moved')"<?php endif; ?>><?= $move ? 'Yes' : 'No' ?></div></td></tr>
        <tr><td class="td-left">Dropable</td> <td class="td-cnter">:</td> <td class="td-left" style="padding: 2px"><div class="btn btn-xs btn-<?= $drop ? 'success' : 'warning' ?>" cdl="<?= $id ?>" stts="<?= $status ?>" <?php if ($updateMoveDrop): ?>onclick="fileUpdatability($(this), 'can_be_deleted')"<?php endif; ?>><?= $drop ? 'Yes' : 'No' ?></div></td></tr>

        <?php if ($updateMoveDrop): ?>
            <tr><td colspan="3">&nbsp;</td></tr>

            <tr><td class="td-left">Uploaded By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $author ?></td></tr>
            <tr><td class="td-left">Uploaded On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $uploadedOn ?></td></tr>

            <?php if (!empty($updatedBy) && !empty($updatedOn)): ?>
                <tr><td class="td-left">Modified By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $updatedBy ?></td></tr>
                <tr><td class="td-left">Modified On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $updatedOn ?></td></tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($lockedBy) && !empty($lockedOn)): ?>
            <tr><td colspan="3">&nbsp;</td></tr>

            <tr><td class="td-left">Locked By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $lockedBy ?></td></tr>
            <tr><td class="td-left">Locked On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $lockedOn ?></td></tr>
        <?php endif; ?>

        <?php if (!empty($archived)): ?>
            <tr><td colspan="3">&nbsp;</td></tr>

            <tr><td class="td-left">File Status</td> <td class="td-cnter">:</td> <td class="td-left">Archived</td></tr>
            <tr><td class="td-left">Archived By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $archivedBy ?></td></tr>
            <tr><td class="td-left">Archived On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $archivedOn ?></td></tr>
        <?php endif; ?>

        <?php if (!empty($deleted)): ?>
            <tr><td colspan="3">&nbsp;</td></tr>

            <tr><td class="td-left">File Status</td> <td class="td-cnter">:</td> <td class="td-left">Recycled</td></tr>
            <tr><td class="td-left">Recycled By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $deletedBy ?></td></tr>
            <tr><td class="td-left">Recycled On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $deletedOn ?></td></tr>
        <?php endif; ?>

        <?php if (!empty($restored)): ?>
            <tr><td colspan="3">&nbsp;</td></tr>

            <tr><td class="td-left">Restored By</td> <td class="td-cnter">:</td> <td class="td-left"><?= $restoredBy ?></td></tr>
            <tr><td class="td-left">Restored On</td> <td class="td-cnter">:</td> <td class="td-left"><?= $restoredOn ?></td></tr>
            <?php endif; ?>
    </table>
</div>