<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class GameAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/web';
   
    public $css = [
        'css/custom-field.css'
    ];

    public $js = [
        'js/custom-field.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}