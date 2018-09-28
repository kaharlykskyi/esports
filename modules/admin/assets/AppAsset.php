<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/web';
    public $css = [
       'css/font-face.css',
       'css/theme.css',
       'vendor/font-awesome-5/css/fontawesome-all.min.css',
       'vendor/animsition/animsition.min.css',
       'vendor/wow/animate.css',
       'vendor/css-hamburgers/hamburgers.min.css',
       'vendor/mdi-font/css/material-design-iconic-font.min.css',
       'vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css',
       'vendor/slick/slick.css',
       'vendor/perfect-scrollbar/perfect-scrollbar.css'

    ];
    public $js = [
        'vendor/slick/slick.min.js',
        'vendor/wow/wow.min.js',
        'vendor/animsition/animsition.min.js',
        'vendor/counter-up/jquery.waypoints.min.js',
        'vendor/counter-up/jquery.counterup.min.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
