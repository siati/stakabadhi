<?php /* @var $users common\models\User */ ?>
<?php /* @var $section common\models\Sections */ ?>

<?php $i = 0 ?>

<table>
    <?php foreach ($users as $user): ?>
        <tr tr-usr="<?= $user->id ?>">
            <td class="td-right td-pdg-rgt"><?= ++$i ?>.</td>
            <td class="usrs-lst-td <?= $section->userSectionClientClass($user->id) ?> has-cstm-mn" cstm-mn=".custom-menu-sctn-rgts" onclick="selectSectionUser($(this).parent().attr('tr-usr'))" >
                <div class="pull-left usr-nm has-cstm-mn" cstm-mn=".custom-menu-sctn-rgts"><?= ucwords(strtolower($user->name)) ?></div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
