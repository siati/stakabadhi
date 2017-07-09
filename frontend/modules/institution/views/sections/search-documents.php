<?php /* @var $documents common\models\Documents */ ?>

<table class="table-hover">
    <?php foreach ($documents as $criterion => $criteria): ?>

        <?php if (!empty($criteria)): ?>

            <tr class="doc-srch-tr"><td class="doc-srch-td-ttl"><?= $criterion ?></td></tr>

            <?php foreach ($criteria as $document): ?>
                <tr doc="<?= $document->id ?>" title="<?= $document->fileLocationToClient($document->status) . " \\ " . ($name = ucwords(strtolower($document->name))) . (($is_folder = $document->dir_or_file == common\models\Documents::FILE_IS_DIRECTORY) ? ('') : ('.' . $document->fileExtesion())); ?>" lvl="<?= $is_folder ? $document->file_level : ($document->file_level - 1) ?>" stts="<?= $document->status ?>" fldr="<?= $document->nearestFolderLocation() ?>" onclick="reloadNavigation3($(this))">
                    <td class="doc-srch-td"><i class="glyphicon glyphicon-<?= $is_folder ? 'folder-close' : 'file' ?>"></i> <?= substr($name, 0, 39); ?></td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    <?php endforeach; ?>

</table>