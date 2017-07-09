<?php
/* @var $usersList mixed */
/* @var $profilesList mixed */
/* @var $profileEditor mixed */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-users">

    <div class="site-users-list"><?= $usersList ?></div>

    <div class="site-sep-pane">&nbsp;</div>

    <div class="site-prfls-list"><?= $profilesList ?></div>

    <div class="site-sep-pane">&nbsp;</div>

    <div class="row"><?= $profileEditor ?></div>

</div>
