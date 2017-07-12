<?php
/* @var $levelName string */
/* @var $storage common\models\Stores|common\models\Compartments|common\models\SubCompartments|common\models\SubSubCompartments|common\models\Shelves|common\models\Drawers|common\models\Batches|common\models\Folders|Files */
/* @var $permissions array */

use common\models\User;
use common\models\StaticMethods;
?>

<table class="table-striped">

    <tr><td colspan="3"><b><?= "$levelName: $storage->name" ?> Properties</b></td></tr>

    <tr><td>&nbsp;</td></tr>

    <?php foreach ($permissions as $level => $permission): ?>
        <tr>
            <td class="td-left"><b><?= $permission[0] ?></b></td>
            <td><b>:</b></td>
            <td><?= $permission[1] ?></td>
        </tr>
    <?php endforeach; ?>

        <tr><td colspan="3">&nbsp;</td></tr>

    <tr>
        <td class="td-left"><b>Created By</b></td>
        <td><b>:</b></td>
        <td class="td-left"><?= User::returnUser($storage->created_by)->name ?></td>
    </tr>

    <tr>
        <td class="td-left"><b>Created On</b></td>
        <td><b>:</b></td>
        <td class="td-left"><?= StaticMethods::dateString($storage->created_at, StaticMethods::longest) ?></td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>

    <tr>
        <td class="td-left"><b>Created By</b></td>
        <td><b>:</b></td>
        <td class="td-left"><?= User::returnUser($storage->created_by)->name ?></td>
    </tr>

    <tr>
        <td class="td-left"><b>Created On</b></td>
        <td><b>:</b></td>
        <td class="td-left"><?= StaticMethods::dateString($storage->created_at, StaticMethods::longest) ?></td>
    </tr>
</table>
