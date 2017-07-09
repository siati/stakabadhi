<?php /* @var $profiles \common\models\Profiles */ ?>

<div class="hd-sctn">
    <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="Profile Edit" style="height: 100%" class="pull-left" />
    <h3>Profiles</h3>
</div>

<div class="bd-sctn">
    <div>
        <table class="table-striped">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name of Role</th>
                    <th>Symbol</th>
                </tr>
            </thead>

            <?php $i = 0 ?>
            <tbody>

                <?php foreach ($profiles as $profile): ?>

                    <tr class="prfl-2-updt kasa-pointa" prfl="<?= $profile->id ?>">
                        <td class="td-right"><?= ++$i ?>.</td>
                        <td class="td-left"><?= $profile->name ?></td>
                        <td><?= $profile->profile ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</div>

<?php
$this->registerJs(
        "
            $('.prfl-2-updt').unbind('click').click(
                function () {
                    jsonJQueryHtml('profile-to-update', {'id': $(this).attr('prfl')});
                }
            );
    "
        , \yii\web\VIEW::POS_READY
);
?>