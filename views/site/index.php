<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;
use Yii;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = mb_convert_case($alias, MB_CASE_TITLE);
    $i_count = 0;
?>

<div class="main-slider-section">
    <div class="main-slider">
        <div id="main-slider" class="carousel slide" 
            data-ride="carousel" data-interval="4000" style="height: 600px;">

            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="/images/slider/<?=$alias?>/1.jpg" alt="Los Angeles">
                </div>
                <div class="item">
                    <img src="/images/slider/<?=$alias?>/2.jpg" alt="Chicago">
                </div>
                <div class="item">
                    <img src="/images/slider/<?=$alias?>/3.jpg" alt="New York">
                </div>
            </div> 

            <!-- Controls -->
            <a class="nav-arrow left-arrow" href="#main-slider" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                <span class="sr-only"></span>
            </a>
            <a class="nav-arrow right-arrow" href="#main-slider" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span class="sr-only"></span>
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php Pjax::begin(); ?>
        <?php foreach ($models as $model): ?>
        <?php if(!$i_count): ?>
            <div class="row">
        <?php endif; ?>
        <?php $i_count++; ?>
        <div class="news-list col-xs-12 col-sm-4">
            <div class="item img-top">
                <div class="img-wrap">
                    <div class="bage"><a href="/news/single/<?=$model->id?>"><?=yii::t('app','highlight')?></a></div>
                    <a href="/news/single/<?=$model->id?>"><img src="<?=$model->logo?>" alt="post image"></a>
                </div>
                <div class="info">
                    <a href="/news/single/<?=$model->id?>" class="name"><?=$model->title?></a>  
                    <div class="wrap">
                        <a href="news-single.html">
                            <?=date('d M Y' ,strtotime($model->created_at))?>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php if($i_count == 3): ?>
            </div>
        <?php $i_count = 0; ?>
        <?php endif; ?> 
        <?php endforeach; ?>
        <?php if($i_count != 0): ?>
            </div>
        <?php endif; ?> 
        <div class="col-md-8 col-md-offset-2">
            <div class="pagination-wrap">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    
                    'options' => [
                        'class' => 'pagination_new',
                    ],
                    'prevPageLabel' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                ])?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>

<div class="container">
    <h3 style="text-align: center;" ><?=Yii::t('app', 'users statistics')?></h3>
    <div class="box-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' =>['class' => 'table-statistic'],
             'pager' => [
                    'options' => [
                        'class' => 'pagination_new',
                    ],
                    'prevPageLabel' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            ],
            'columns' => [
                [
                    'attribute' => 'user_id',
                    'label' => Yii::t('app','User'),
                    'content' => function($data) {
                        $flag_src = FlagServis::getLinkFlag($data->user->country);
                        return "<a href='/user/public/{$data->user->id}' ><img src= '{$flag_src}' 
                                style='height:28px;'>  {$data->user->name}</a>";
                    }
                ],
                [
                    'attribute' => 'team_id',
                    'label' => Yii::t('app','Team'),
                    'content' => function($data) {
                        if (!is_null($data->team->single_user)) {
                            return '----';
                        }
                        return "<a href='{$data->team->links()}' ><img src= '{$data->team->logo()}' style='height:28px;'>  {$data->team->name}</a>";
                    }
                ],
                [
                    'attribute' => 'victories',
                    'label' => Yii::t('app','Victories'),
                ],
                [
                    'attribute' => 'loss',
                    'label' => Yii::t('app','Loss'),
                ],
                [
                    'attribute' => 'rate',
                    'label'=>Yii::t('app','W/L RATE'),
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
