<?php
/* @var $levelName string */
/* @var $storage common\models\Stores|common\models\Compartments|common\models\SubCompartments|common\models\SubSubCompartments|common\models\Shelves|common\models\Drawers|common\models\Batches|common\models\Folders|common\models\Files */
/* @var $permissions array */

use common\models\User;
use common\models\StaticMethods;
?>

<?php if (is_object($storage)): ?>

    <table class="table-striped">

        <?php if (empty($storage->folder)): ?>
            <tr><td colspan="3"><b><?= "$levelName: $storage->name" ?> Properties</b></td></tr>

            <tr><td>&nbsp;</td></tr>
        <?php endif; ?>

        <?php foreach ($permissions as $level => $permission): ?>
            <tr>
                <td class="td-left"><b><?= $permission[0] ?></b></td>
                <td><b>:</b></td>
                <td><?= $permission[1] ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (is_object($user = User::returnUser($storage->created_by))): ?>

            <?php if (empty($storage->folder)): ?>
                <tr><td colspan="3">&nbsp;</td></tr>
            <?php endif; ?>

            <tr>
                <td class="td-left"><b>Created By</b></td>
                <td><b>:</b></td>
                <td class="td-left"><?= $user->name ?></td>
            </tr>

            <tr>
                <td class="td-left"><b>Created On</b></td>
                <td><b>:</b></td>
                <td class="td-left"><?= StaticMethods::dateString($storage->created_at, StaticMethods::longest) ?></td>
            </tr>

        <?php endif; ?>

        <?php if (is_object($user = User::returnUser($storage->updated_by))): ?>

            <tr><td colspan="3">&nbsp;</td></tr>

            <tr>
                <td class="td-left"><b>Modified By</b></td>
                <td><b>:</b></td>
                <td class="td-left"><?= $user->name ?></td>
            </tr>

            <tr>
                <td class="td-left"><b>Modified On</b></td>
                <td><b>:</b></td>
                <td class="td-left"><?= StaticMethods::dateString($storage->updated_at, StaticMethods::longest) ?></td>
            </tr>

        <?php endif; ?>
    </table>

<?php else: ?>

    <div class="no-axn">
        <h4 class="no-axn-txt">No Properties To Display Here</h4>
    </div>

<?php endif; ?>
