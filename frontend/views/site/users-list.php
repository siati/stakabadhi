<?php /* @var $this yii\web\View */ ?>
<?php /* @var $users \common\models\User */ ?>

<?php

use yii\web\View;
use common\models\Profiles;
use common\models\User;

$userProfile = Yii::$app->user->identity->userProfile();
?>



<div class="hd-sctn">
    <image src="<?= Yii::$app->urlManager->baseUrl ?>/../../common/assets/icons/dazit.png" alt="Profile Edit" style="height: 100%" class="pull-left" />
    <h3>User Management</h3>
    <div class="input-group">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </span>
        <input id="user-search" class="form-control" autofocus="autofocus" type="text">
    </div>
</div>

<div class="bd-sctn">
    <div>
        <table id="usrs-tbl" class="table-striped">

            <thead>
                <tr>
                    <th>#</th>
                    <th class="td-left">Name of User</th>
                    <th class="td-left">Email</th>
                    <th>Phone No.</th>
                    <th>Username</th>
                    <th class="fltr-by-prf has-cstm-mn" cstm-mn=".custom-menu-usr-prf-fltr">Profile <small><i class="glyphicon glyphicon-sort has-cstm-mn" cstm-mn=".custom-menu-usr-prf-fltr"></i></small></th>
                    <th class="fltr-by-sts has-cstm-mn" cstm-mn=".custom-menu-usr-sts-fltr">Status <small><i class="glyphicon glyphicon-sort has-cstm-mn" cstm-mn=".custom-menu-usr-sts-fltr"></i></small></th>
                    <th class="fltr-by-rst has-cstm-mn" cstm-mn=".custom-menu-usr-rst-fltr">Pswd <small><i class="glyphicon glyphicon-sort has-cstm-mn" cstm-mn=".custom-menu-usr-rst-fltr"></i></small></th>
                    <th class="fltr-by-lgn has-cstm-mn" cstm-mn=".custom-menu-usr-lgn-fltr">Login <small><i class="glyphicon glyphicon-sort has-cstm-mn" cstm-mn=".custom-menu-usr-lgn-fltr"></i></small></th>
                </tr>
            </thead>

            <?php $i = 0 ?>
            <tbody>

                <?php foreach ($users as $user): ?>

                    <?php $profile = Profiles::returnProfile($user->profile) ?>

                    <tr class="tr-usr tr-usr-<?= $user->id ?>" usr="<?= $user->id ?>">
                        <td class="td-right"><?= ++$i ?>.</td>
                        <td class="td-left nm"><span><?= $user->name ?></span></td>
                        <td class="td-left ml"><span class="cntct-trgr" onclick="mailTrigger($(this))" to="<?= $user->email ?>"><?= $user->email ?></span></td>
                        <td><span class="cntct-trgr" onclick="callTrigger('<?= $user->phone ?>')"><?= $user->phone ?></span></td>
                        <td class="usr-nm"><span><?= $user->username ?></span></td>
                        <td class="td-span-btn usr-prf"><span class="btn btn-xs btn-<?= $profile->profile == User::USER_SUPER_ADMIN ? ('success') : ($profile->profile == User::USER_ADMIN ? ('primary') : (empty($profile->profile) ? 'warning' : 'info')) ?> <?= $canUpdate = User::canUpdateAccountStatus(Yii::$app->user->identity->id, $user->id, $userProfile->profile, $profile->profile) ? 'has-cstm-mn' : '' ?>" <?php if ($canUpdate): ?>cstm-mn=".custom-menu-usr-prfl"<?php endif; ?>><?= empty($profile->profile) ? User::NO_RIGHT_NAME : $profile->profile ?></span></td>
                        <td class="td-span-btn act-sts"><span class="btn btn-xs btn-<?= ($userActive = $user->status == User::STATUS_ACTIVE) ? 'success' : 'warning' ?> <?= $canUpdate ? 'has-cstm-mn' : '' ?>" <?php if ($canUpdate): ?>cstm-mn=".custom-menu-act-stts"<?php endif; ?>><?= $userActive ? ($isActive = User::STATUS_ACTIVE_NAME) : User::STATUS_DELETED_NAME ?></span></td>
                        <td class="td-span-btn psw-rst"><span class="btn btn-xs btn-<?= $user->pass_okayed == User::PASSWORD_CLIENT_SET ? ('success') : ($user->pass_okayed == User::PASSWORD_ADMIN_RESET ? 'primary' : 'info') ?> <?= $canUpdate = User::profileCanUpdateOther($userProfile->profile, $profile->profile) ? 'has-cstm-mn' : '' ?>" <?php if ($canUpdate): ?>cstm-mn=".custom-menu-pswd-rst"<?php endif; ?>><?= $user->pass_okayed == User::PASSWORD_CLIENT_SET ? (User::PASSWORD_CLIENT_SET_NAME) : ($user->pass_okayed == User::PASSWORD_ADMIN_RESET ? User::PASSWORD_ADMIN_RESET_NAME : User::PASSWORD_AUTO_GENERATED_NAME) ?></span></td>
                        <td class="td-span-btn usr-lgn"><span class="btn btn-xs btn-<?= $user->signed_in == User::CURRENTLY_LOGGED_IN ? 'success' : 'warning' ?>" style="border-radius: 100%"><?= $user->signed_in == User::CURRENTLY_LOGGED_IN ? User::CURRENTLY_LOGGED_IN_NAME : User::CURRENTLY_NOT_LOGGED_IN_NAME ?></span></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</div>


<!-- custom context menu for user profile -->
<ul class="custom-menu custom-menu-usr-prfl">
    <li class="custom-sub-menu custom-sub-menu-title usr-nm" usr-id="">No User Selected</li>

    <?php foreach ($profiles = Profiles::allProfiles() as $profile): ?>
        <?php if (User::profileCanUpdateOther($userProfile->profile, $profile->profile)): ?>
            <li class="custom-sub-menu" onclick="userProfile(usr = $('.custom-menu-usr-prfl .usr-nm').attr('usr-id'), '<?= $profile->id ?>', $('.tr-usr-' + usr + ' .usr-prf span'))" prf="<?= $profile->profile ?>"><?= "$profile->name, $profile->profile" ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
<!-- custom context menu for user profile -->

<!-- custom context menu for account status -->
<ul class="custom-menu custom-menu-act-stts">
    <li class="custom-sub-menu custom-sub-menu-title usr-nm" usr-id="">No User Selected</li>
    <li class="custom-sub-menu" onclick="accountStatus(usr = $('.custom-menu-act-stts .usr-nm').attr('usr-id'), '<?= User::STATUS_ACTIVE ?>', $('.tr-usr-' + usr + ' .act-sts span'))"><?= User::STATUS_ACTIVE_NAME ?></li>
    <li class="custom-sub-menu" onclick="accountStatus(usr = $('.custom-menu-act-stts .usr-nm').attr('usr-id'), '<?= User::STATUS_DELETED ?>', $('.tr-usr-' + usr + ' .act-sts span'))"><?= User::STATUS_DELETED_NAME ?></li>
</ul>
<!-- custom context menu for account status -->

<!-- custom context menu for password reset -->
<ul class="custom-menu custom-menu-pswd-rst">
    <li class="custom-sub-menu custom-sub-menu-title usr-nm" usr-ml="">No User Selected</li>
    <li class="custom-sub-menu usr-ml" onclick="passwordResetRequest($('.custom-menu-pswd-rst .usr-nm').attr('usr-ml'), $('.custom-menu-pswd-rst .usr-nm').attr('usr-pw'), 'ml')">No Email Selected</li>
    <li class="custom-sub-menu usr-pw" onclick="passwordResetRequest($('.custom-menu-pswd-rst .usr-nm').attr('usr-ml'), $('.custom-menu-pswd-rst .usr-nm').attr('usr-pw'), 'pw')">No Email Selected</li>
</ul>
<!-- custom context menu for password reset -->

<!-- custom context menu for filter users by profile -->
<ul class="custom-menu custom-menu-usr-prf-fltr">
    <li class="custom-sub-menu custom-sub-menu-title">User Role:</li>

    <?php foreach ($profiles as $profile): ?>
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'usr-prf')"><?= $profile->profile ?></li>
    <?php endforeach; ?>
    <li class="custom-sub-menu" onclick="userFilterBy('', 'usr-prf')">Remove Filter</li>
</ul>
<!-- custom context menu for filter users by profile -->

<!-- custom context menu for filter users by status -->
<ul class="custom-menu custom-menu-usr-sts-fltr">
    <li class="custom-sub-menu custom-sub-menu-title">Account Status:</li>
    
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'act-sts')"><?= ucwords(User::STATUS_ACTIVE_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'act-sts')"><?= ucwords(User::STATUS_DELETED_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy('', 'act-sts')">Remove Filter</li>
</ul>
<!-- custom context menu for filter users by status -->

<!-- custom context menu for filter users by password source -->
<ul class="custom-menu custom-menu-usr-rst-fltr">
    <li class="custom-sub-menu custom-sub-menu-title">Generated By:</li>
    
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'psw-rst')"><?= ucwords(User::PASSWORD_CLIENT_SET_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'psw-rst')"><?= ucwords(User::PASSWORD_ADMIN_RESET_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'psw-rst')"><?= ucwords(User::PASSWORD_AUTO_GENERATED_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy('', 'psw-rst')">Remove Filter</li>
</ul>
<!-- custom context menu for filter users by password source -->

<!-- custom context menu for filter users by login status -->
<ul class="custom-menu custom-menu-usr-lgn-fltr">
    <li class="custom-sub-menu custom-sub-menu-title">Logged In:</li>
    
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'usr-lgn')"><?= ucwords(User::CURRENTLY_LOGGED_IN_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy($(this).html(), 'usr-lgn')"><?= ucwords(User::CURRENTLY_NOT_LOGGED_IN_NAME) ?></li>
    <li class="custom-sub-menu" onclick="userFilterBy('', 'usr-lgn')">Remove Filter</li>
</ul>
<!-- custom context menu for filter users by login status -->

<?php
$superAdmin = User::USER_SUPER_ADMIN;
$admin = User::USER_ADMIN;
$noRight = User::NO_RIGHT_NAME;

$this->registerJs(
        "
            function userProfile(user, profile, elmnt) {
                $.post('user-profile', {'User[id]': user, 'User[profile]': profile},
                        function (profile) {
                            elmnt.removeClass('btn-success').removeClass('btn-primary').removeClass('btn-warning').removeClass('btn-info').addClass(profile === '$superAdmin' ? ('btn-success') : (profile === '$admin' ? ('btn-primary') : (profile === '$noRight' ? 'btn-warning' : 'btn-info'))).html(profile);
                        }
                );
            }
    
            function accountStatus(user, status, elmnt) {
                $.post('account-status', {'User[id]': user, 'User[status]': status},
                        function (status) {
                            elmnt.removeClass(status === '$isActive' ? 'btn-warning' : 'btn-success').addClass(status === '$isActive' ? 'btn-success' : 'btn-warning').html(status);
                        }
                );
            }
            
            function passwordResetRequest(mail, pass, type) {
                $.post(type == 'pw' ? 'reset-password-via-admin' : 'request-password-reset-via-admin', {'PasswordResetRequestForm[email]': mail, 'ResetPasswordForm[password]': pass},
                        function (sent) {
                        if (type == 'pw')
                            customErrorSwal(sent ? 'Password Reset Successfully' : 'Password Not Reset', sent ? 'User can sign in with the new password' : 'Please try again<br/><br/>User account may be blocked<br/><br/>If this persits then seek for relevant assistance', 2000, sent ? 'success' : 'error');
                        else
                            customErrorSwal(sent ? 'Email Sent Successfully' : 'Email Sending Failed', sent ? 'User can check their email for further instruction' : 'Please try again<br/><br/>User account may be blocked<br/><br/>If this persits then seek for relevant assistance', 2000, sent ? 'success' : 'error');
                        }
                );
            }
            
            function userFilterBy(val, tdClass) {
                        
                search = val.toLowerCase();

                $('#usrs-tbl tbody').find('tr').each(
                        function () {

                            show = false;

                            $(this).find('.' + tdClass).each(
                                    function () {
                                        compare = $(this).html().toLowerCase();

                                        if (compare.indexOf(search) > -1) //compare.substr(0, search.length) === search
                                            show = true;
                                    }
                            );

                            show ? $(this).show() : $(this).hide();

                        }
                );
            }
        "
        , View::POS_HEAD
);

$this->registerJs(
        "
            /* select user by clicking on the users table view */
            
            $('.tr-usr').click(
                    function () {
                    
                        var row = $(this);
                        
                        /* select user as one scrolls through the users table view */
                        $('.custom-menu-usr-prfl .usr-nm').attr('usr-id', row.attr('usr')).html('<b>' + row.find('.nm').html() + ', ' + row.find('.usr-nm').html() + '</b> Role change:');
                        $('.custom-menu-act-stts .usr-nm').attr('usr-id', row.attr('usr')).html('<b>' + row.find('.nm').html() + ', ' + row.find('.usr-nm').html() + '</b> Account Status change:');
                        $('.custom-menu-pswd-rst .usr-nm').attr('usr-ml', ml = row.find('.ml span').text()).attr('usr-pw', pw = row.find('.cntct-trgr').text().substr(row.find('.cntct-trgr').text().length - 6)).html('<b>' + row.find('.nm').html() + ', ' + row.find('.usr-nm').html() + '</b> Password Reset Request:');
                        $('.custom-menu-pswd-rst .usr-ml').html('Send reset link to <b>' + ml + '</b>');
                        $('.custom-menu-pswd-rst .usr-pw').html('Reset password to <b>' + pw + '</b>');
                        
                        /* hide user's profile from profile options */
                        $('.custom-menu-usr-prfl').find('.custom-sub-menu').each(
                            function () {
                                $(this).attr('prf') === row.find('.usr-prf span').html() ? $(this).hide() : $(this).show();
                            }
                        );
                        
                        /* hide user's account status from account status options */
                        $('.custom-menu-act-stts').find('.custom-sub-menu').each(
                            function () {
                                $(this).html() === row.find('.act-sts span').html() ? $(this).hide() : $(this).show();
                            }
                        );
                        
                    }
            );
            
            /* select user by clicking on the users table view */
            
            /* search through users table */

            $('#user-search').keyup(
                    function () {
                        
                        search = $(this).val().toLowerCase();

                        $('#usrs-tbl tbody').find('tr').each(
                                function () {

                                    show = false;

                                    $(this).find('td span').each(
                                            function () {
                                                compare = $(this).html().toLowerCase();
                                                
                                                if (compare.indexOf(search) > -1) //compare.substr(0, search.length) === search
                                                    show = true;
                                            }
                                    );

                                    show ? $(this).show() : $(this).hide();

                                }
                        );
                    }
            );

            /* search through users table */
        "
        , View::POS_READY
);
?>