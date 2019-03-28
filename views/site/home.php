<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = "Esports";
    $i_count = 0;
    $url_this = $_SERVER['HTTP_HOST'];
?>


<div class="main-slider-section">
    <div class="main-slider">
        <div id="main-slider" class="carousel slide" data-ride="carousel" data-interval="4000" style="height: 540px;">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="img-slid" style="background-image: url(/images/slider/hearthstone/1.jpg);"></div> 
                    <?php if (!empty($matches[0])): ?>
                        <div class="main-slider-caption" >
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="match-date">
                                            <?=date('d M Y / H:m A ', strtotime($matches[0]->date))?>
                                        </div>
                                        <div class="team"> 
                                            <?=$matches[0]->teamF->name()?> 
                                            <div class="big-count">
                                                <?=$matches[0]->results1?? '&#8211';?>
                                                :
                                                <?=$matches[0]->results2?? '&#8211';?>
                                            </div>
                                            <?=$matches[0]->teamS->name()?>
                                        </div>                                    
                                        <div class="booking">
                                            <a href="/matches/public/<?=$matches[1]->id?>">
                                                Match Page
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="event-nav">
                        <p style="text-align: center;" >
                            <a href="http://hearthstone.<?=$url_this?>" class="btn booking" >
                                hearthstone
                            </a>
                        </p>
                    </div>
                </div>
                <div class="item">
                    <div class="img-slid" style="background-image: url(/images/slider/pokemon/1.jpg);"></div>
                    <?php if (!empty($matches[1])): ?>
                        <div class="main-slider-caption" >
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="match-date">
                                            <?=date('d M Y / H:m A ', strtotime($matches[1]->date))?>
                                        </div>
                                        <div class="team"> 
                                            <?=$matches[1]->teamF->name()?> 
                                            <div class="big-count">
                                                <?=$matches[1]->results1?? '&#8211';?>
                                                :
                                                <?=$matches[1]->results2?? '&#8211';?>
                                            </div>
                                            <?=$matches[1]->teamS->name()?>
                                        </div>                                    
                                        <div class="booking">
                                            <a href="/matches/public/<?=$matches[1]->id?>">
                                                Match Page
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="event-nav">
                        <p style="text-align: center;" >
                            <a href="http://pokemon.<?=$url_this?>" class="btn booking" >
                                pokemon
                            </a>
                        </p>
                    </div>
                </div>

                <div class="item">
                    <div class="img-slid" style="background-image: url(/images/slider/wow/3.jpg);"></div>
                    <?php if (!empty($matches[2])): ?>
                        <div class="main-slider-caption" >
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="match-date">
                                            <?=date('d M Y / H:m A ', strtotime($matches[2]->date))?>
                                        </div>
                                        <div class="team"> 
                                            <?=$matches[2]->teamF->name()?> 
                                            <div class="big-count">
                                                <?=$matches[2]->results1?? '&#8211';?>
                                                :
                                                <?=$matches[2]->results2?? '&#8211';?>
                                            </div>
                                            <?=$matches[2]->teamS->name()?>
                                        </div>                                    
                                        <div class="booking">
                                            <a href="/matches/public/<?=$matches[2]->id?>">
                                                Match Page
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="event-nav">
                        <p style="text-align: center;" >
                            <a href="http://wow.<?=$url_this?>" class="btn booking" >
                                wordcraft
                            </a>
                        </p>
                    </div>
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

<?php 
    $func = function($data) {
    ob_start();
?>

<div class="name-content">
    <div class="info-stage">
        <?php if($data->state == 1): ?>
        <span class="started" >Started</span>
        <?php elseif($data->state == null): ?>
        <span class="uncoming" >Uncoming</span>
        <?php elseif($data->state == 2): ?>
        <span class="finihed" >Finihed</span>
        <?php endif; ?>
        <a href="/tournaments/public/<?=$data->id?>"><span class="overwatch" >Overwatch</span></a>
    </div>
   <h6><?=$data->name?></h6>
   <div class="t-prize" >
        <span>Tournament Prizes</span>
        <span><?=$data->prize_pool ? $data->prize_pool.'$': '--'?></span>
    </div>
</div>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>

<?php 
    $func_stage = function($data) {
    ob_start();
?>
    <?php if($data->state == 1): ?>
    <div class="mach-content">
        <?php  
        $match = $data->matchNext;
        if(is_object($match)): ?>
            <a href="/matches/public/<?=$match->id?>">
            <div class="mach-content">
                <h6>Next Match</h6>
                <div class="mach-logo" >
                    <img src="<?=$match->teamS->logo()?>" >
                    <img src="/images/tournaments/vs_finished.png" style="height:40px">
                    <img src="<?=$match->teamF->logo()?>" >
                </div>
                <div class="date">
                    <span><?=date('dS F Y, H:m', strtotime($match->date))?></span>
                </div>
            </div>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>


<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>

<?php 
    $func_game = function($data) {
    ob_start();
?>
<div class="tyr-game">
    <img src="/images/game/<?=$data->logo?>" style="height: 50px;" >
    <p style="font-size: 13px;font-weight: normal;" >geme in <?=$data->name?></p>
</div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>

<div class="main-sponsor-slider-background">
    <div class="container">
        <?php Pjax::begin(); ?>
        <?php foreach ($models as $model): ?>
        <?php if(!$i_count): ?>
            <div class="row">
        <?php endif; ?>
        <?php $i_count++; ?>
        <div class="news-list col-xs-12 col-sm-4">
            <div class="item img-top">
                <div class="img-wrap">
                    <div class="bage">
                        <a href="/news/single/<?=$model->id?>"><?=yii::t('app','highlight')?></a>
                    </div>
                    <a href="/news/single/<?=$model->id?>">
                        <img src="<?=$model->logo?>" alt="post image">
                    </a>
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
    <h3 style="text-align: center;" ><?=Yii::t('app','Tournament statistics')?></h3>
    <div class="box-body">
        <div class="blok-headre-table">
            <?php if(!isset($params['state'])):?>
                <div class="lenk-sot active" style="margin-left: -10px; ">
                    <a href="/">All tournaments</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" style="margin-left: -10px; ">
                    <a href="/">All tournaments</a>
                </div>
            <?php endif; ?>
            <?php if(!empty($params['state'])&& $params['state']==1):?>
                <div class="lenk-sot active" ">
                    <a href="/?state=1">Tournaments started</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" ">
                    <a href="/?state=1">Tournaments started</a>
                </div>
            <?php endif; ?>
            <?php if(isset($params['state'])&& $params['state']==0):?>
                <div class="lenk-sot active" ">
                    <a href="/?state=0">Next tournaments</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot"">
                    <a href="/?state=0">Next tournaments</a>
                </div>
            <?php endif; ?>
            <?php if(!empty($params['state'])&& $params['state']==2):?>
                <div class="lenk-sot active" >
                    <a href="/?state=2">Tournaments finished</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" ">
                    <a href="/?state=2">Tournaments finished</a>
                </div>
            <?php endif; ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' =>['class' => 'table-statistic tournaments-table'],
            'showHeader'=> false,
             'pager' => [
                    'options' => [
                        'class' => 'pagination_new',
                    ],
                    'prevPageLabel' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            ],
            'columns' => [
                [
                    'attribute' => 'banner',
                    'content' => function($data) {
                        return "<img src='{$data->logo}' class='banner-logo'  alt='logo'>";
                    }
                ],
                [
                    'attribute'=> 'name',
                    'label'=> Yii::t('app','Tournament name'),
                    'content' => function($data) use ($func) {
                        return $func($data);
                    },
                ],
                [                
                    'content' => function($data) use ($func_stage) {
                        return $func_stage($data);
                    },
                ],
                [
                    'attribute'=> 'game_id',
                    'label' => Yii::t('app','Game'),
                    'content' => function($data) use ($func_game) {
                        if (!is_object($data->game)) {
                            return 'Not game';
                        }
                        return $func_game($data->game);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>

