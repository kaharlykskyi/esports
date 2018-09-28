<?php

use app\widgets\Alert;
use yii\helpers\Html;
use app\modules\admin\assets\AppAsset;
use \yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="au theme template">
    <?= Html::csrfMetaTags() ?>
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>

<body class="animsition">
<?php $this->beginBody() ?>
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <?= $content ?>
            </div>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<!-- end document-->