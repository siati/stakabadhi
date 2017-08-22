<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/custom.css',
        'css/custom-menu.css',
        'css/user-management-form.css',
        'css/sign-up-form.css',
        'css/sign-in-form.css',
        'css/request-password-reset-form.css',
        'css/reset-password-form.css',
        'css/inst-set-up.css',
        'css/files.css'
    ];
    public $js = [
        'js/jsonJQueryHtml.js',
        'js/yii-modal-and-pop-window.js',
        'js/mseto.js',
        'js/swals.js',
        'js/custom-menu.js',
        'js/file-up-down-load.js',
        'js/mail-trigger.js',
        'js/dynamic-regions.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
