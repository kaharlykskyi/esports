<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = $news->title;
?>

<div class="container">
<section class="news-single col-xs-12 col-sm-12">
    <div class="item">
        <div class="top-info">
            <div class="date"><?=date('d M Y' ,strtotime($news->created_at))?> </div>
            <div class="comment-quantity"><?=Yii::t('app','Category')?> <?=$news->category->title?></div>
        </div>
        <div class="img-wrap row">
                <div class="col-md-6">
                    <div class="bage highlight"><?=Yii::t('app','highlight')?></div>
                    <img src="<?=$news->logo?>" alt="news-single">
                </div>
                <div class="col-md-6">
                    <h5><?=$news->title?></h5>
                </div>
        </div>
        <div class="post-text">
           <?=$news->description?>
        </div>
    </div>
</section>
</div>