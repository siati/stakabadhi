<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
use kartik\date\DatePicker;

AppAsset::register($this);
?>

<?php
$search_layout = <<< HTML
    {input}
    <span id="srch-btn" class="btn btn-primary input-group-addon">
        <i class="glyphicon glyphicon-search"></i>
    </span>
HTML;

$searhField = DatePicker::widget([
            'id' => 'srch-fld',
            'name' => 'search-value',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => '',
            'options' => ['placeholder' => 'search documents', 'type' => 'text'],
            'layout' => $search_layout,
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => false,
                'format' => 'yyyy-mm-dd'
            ]
        ])
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <!-- sweet alerts begin -->
        <script type="text/javascript"><?php require Yii::$app->basePath . '\..\vendor\bower\sweetalerts\dist\sweetalert.min.js' ?></script>
        <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>../../vendor/bower/sweetalerts/dist/sweetalert.css">
        <!-- sweet alerts end -->

        <?php $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/png', 'href' => Yii::$app->homeUrl . '../../common/assets/icons/johnrays.png']); ?>

    </head>
    <body>

        <?php $this->beginBody() ?>

        <!-- floating sliding search div starts here -->
        <div id="slider-float-srch-div">
            <div id="header-float-srch-div">
                <div class="srch-ttl">
                    <div id="srch-hdg" class="srch-hdg">
                        <?= $searhField ?>
                    </div>
                </div>

                <div class="srch-bdy">
                    <div id="srch-bdy-pn" class="srch-bdy-pn">

                    </div>

                    <div id="srch-bdy-pn-prgrs" class="srch-bdy-pn-prgrs">
                        <div id="srch-bdy-pn-prgrs-pn" class="srch-bdy-pn-prgrs-pn">
                            Waiting...
                        </div>
                    </div>
                </div>

                <div class="srch-ftr" onclick="docSearchFormClose()">
                    <div id="srch-cls" class="btn btn-sm btn-default srch-cls"><b><i class="glyphicon glyphicon-menu-right"></i><i class="glyphicon glyphicon-menu-right"></i></b></div>
                </div>

            </div>
        </div>
        <!-- floating sliding search div ends here -->

        <?php Modal::begin(['header' => "<div style='font-size: 24px'><span class='yii-modal-head'><b>Yii Modal</b></span></div>", 'id' => 'yii-modal-pane', 'size' => 'modal-lg', 'clientOptions' => ['backdrop' => 'static', 'keyboard' => false], 'closeButton' => ['class' => 'btn btn-sm btn-danger pull-right', 'id' => 'the-modal-close', 'style' => 'font-weight: bold']]) ?>

        <div id="yii-modal-cnt"></div>

        <?php Modal::end() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'Stakabadhi',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];

            $menuItems[] = [
                'label' => Yii::$app->user->isGuest ? "You're Guest" : 'Welcome, ' . Yii::$app->user->identity->username . ',',
                'items' => Yii::$app->user->isGuest ? [
            NavBar::linkHelper('sgn-up', '/site/signup', 'post', '', 'Sign Up', ''),
            NavBar::linkHelper('sgn-in', '/site/login', 'post', '', 'Sign In', 'sgn-in-mn-btn'),
            '<li class="divider"></li>',
            NavBar::linkHelper('psw-rd', '/site/request-password-reset', 'post', '', 'Request Password Reset', 'psw-rd-mn-btn'),
                ] : [
            //admin to perform system settings
            ($admin = User::userHasRights(Yii::$app->user->identity->profile, [User::USER_SUPER_ADMIN, User::USER_ADMIN])) ? '<li class="divider"></li>' : '',
            $admin ? '<li class="dropdown-header">System Administration</li>' : '',
            $admin ? NavBar::linkHelper('usr-mg', '/site/user-management', 'post', '', 'User Management', 'usr-mg-mn-btn') : '',
            $admin ? NavBar::linkHelper('set-up', '/institution/', 'post', '', 'Our Documents', 'set-up-mn-btn') : '',
            $admin ? NavBar::linkHelper('set-up', '/files/', 'post', '', 'Our Files', 'th-fls-mn-btn') : '',
            //default account options
            $admin ? '<li class="divider"></li>' : '',
            NavBar::linkHelper('psw-rd', '/site/request-password-reset', 'post', '', 'Request Password Reset', 'psw-rd-mn-btn'),
            NavBar::linkHelper('sgn-ot', '/site/logout', 'post', '', 'Sign Out', ''),
                ],
            ];

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container">

                <div class="class-of-content" style="height: <?= $contentHeight = empty(Yii::$app->session->getAllFlashes(false)) ? 100 : 96 ?>%">
                    <?= $content ?>
                </div>

                <?php if ($contentHeight < 100): ?>
                    <div class="class-of-flash">
                        <?= Alert::widget() ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; we@ss <?= date('Y') ?></p>

                <p class="pull-right">Powered By <a href="https://kakamega.go.ke/" target="_blank">County Government of Kakamega</a></p>
            </div>
        </footer>

        <?php $this->endBody() ?>

        <?php
        $this->registerJs(
                "
                $('.class-of-content').css('margin-top', $('.wrap .navbar').css('height'));
                
                /* align floating menu div appropriately */
                    $('#header-float-srch-div').css('width', $(window).width() / 5.75 + 'px').css('height', $('.class-of-content').height() + 5 + 'px');
                    alignSliderDivSearchVertically();
                    $('#slider-float-srch-div').css('right', $('#header-float-srch-div').width() * -1 + 'px').children('#srch-cls').click();
                /* align floating menu div appropriately */

                "
                , \yii\web\VIEW::POS_READY
        )
        ?>

        <?php if (!Yii::$app->user->isGuest): ?>
            <?php $this->registerJs(file_get_contents(Yii::$app->basePath . '\web\js\idle-session-timeout.js'), \yii\web\VIEW::POS_READY) ?>
        <?php endif; ?>

    </body>
</html>
<?php $this->endPage() ?>
