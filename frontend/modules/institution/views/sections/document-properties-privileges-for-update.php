<?php /* @var $updateDocuments common\models\Documents */ ?>

<?php if (empty($updateDocuments)): ?>

    <div class="no-axn">
        <h4 class="no-axn-txt">No documents pending your action</h4>
    </div>

<?php else: ?>

    <div class="prmsn-pn-eda">
        Pending Your Action
    </div>

    <div class="prmsn-pn-bdy">
        <div class="prmsn-pn-bdy-pn">
            <table class="table-hover">
                <?php foreach ($updateDocuments as $document): ?>
                    <tr dok-id="<?= $document->id ?>" dok-lvl="<?= $document->file_level ?>" dok-fldr="<?= $document->nearestFolderLocation() ?>" dok-stts="<?= $document->status ?>" dok-name="<?= $name = ucwords(strtolower($document->name)) ?>" title="<?= $name ?>">
                        <td class="td-left kasa-pointa dok-nm" onclick="reloadNavigation2($(this).parent(), 1)"><?= substr($name, 0, 29) ?></td>
                        <td class="glyphicon glyphicon-stop dok-unlck pull-right" onclick="unlockFile($(this).parent())" title="Cancel"></td>
                        <td class="glyphicon glyphicon-cloud-download dok-dwnld pull-right" onclick="downloadFileToUpdate($(this).parent())" title="Download"></td>

                        <?php if (!empty($document->can_be_updated)): ?>
                            <td class="glyphicon glyphicon-edit dok-updt pull-right" onclick="bookFile2($(this).parent())" title="Update"></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>