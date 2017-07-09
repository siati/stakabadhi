<?php /* @var $writeDocuments common\models\Documents */ ?>

<?php if (empty($writeDocuments)): ?>

    <div class="no-axn">
        <h4 class="no-axn-txt">No files under your administration</h4>
    </div>

<?php else: ?>

    <div class="prmsn-pn-eda">
        Under Your Administration
    </div>

    <div class="prmsn-pn-bdy">
        <div class="prmsn-pn-bdy-pn">
            <table class="table-hover">
                <?php foreach ($writeDocuments as $document): ?>
                    <tr dok-id="<?= $document->id ?>" dok-lvl="<?= $document->file_level ?>" dok-fldr="<?= $document->nearestFolderLocation() ?>" dok-stts="<?= $document->status ?>" title="<?= $name = ucwords(strtolower($document->name)) ?>">
                        <td class="td-left kasa-pointa dok-nm" onclick="reloadNavigation2($(this).parent(), 0)"><?= substr($name, 0, 49) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php endif; ?>