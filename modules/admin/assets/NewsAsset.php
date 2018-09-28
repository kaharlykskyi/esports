<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class NewsAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/web';
   
    public $js = [
        'js/news.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}