<?php

use yii\helpers\Html;
use app\assets\AppAsset;
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <header class="edgtf-page-header" >
		<div class="edgtf-menu-area" style="height: 40px; opacity: 1;background-color: #17161a;">	
		</div>
    </header>	
    <?= $content ?>
    <?php $this->endBody() ?>
    <footer style="height: 40px; background-color: #13518e;">
    </footer>
</body>
</html>
<?php $this->endPage() ?>
