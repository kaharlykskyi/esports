<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = mb_convert_case($alias, MB_CASE_TITLE);
    $i_count = 0;
?>

<div class="main-slider-section">
    <div class="main-slider">
        <div id="main-slider" class="carousel slide" data-ride="carousel" data-interval="4000" style="height: 540px;">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="img-slid" style="background-image: url(/images/slider/<?=$alias?>/1.jpg);"></div> 
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
                </div>
                <div class="item">
                    <div class="img-slid" style="background-image: url(/images/slider/<?=$alias?>/2.jpg);"></div>
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
                </div>

                <div class="item">
                    <div class="img-slid" style="background-image: url(/images/slider/<?=$alias?>/3.jpg);"></div>
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
<?php if($alias == 'hearthstone'): ?>
    <?=$this->render(
            '_hearthstone',
            compact('dataProvider','searchModel','models','pages','alias','params')
    ); ?>
<?php else: ?>
    <div class="container">
        <h3 style="text-align: center;" ><?=Yii::t('app', 'users statistics')?></h3>
        <div class="box-body" id='onloads' >
            <?php Pjax::begin(); ?>
                <div class="blok-headre-table">
                    <?php if(!isset($params['sort'])): ?>
                         <div class="lenk-sot active" style="margin-left: -10px; ">
                            <a href="/?sort=user_id">User</a>
                        </div>
                    <?php elseif((isset($params['sort'])&&($params['sort']=='user_id'|| $params['sort']=='-user_id'))):?>
                        <div class="lenk-sot active" style="margin-left: -10px; ">
                            <a href="<?= $params['sort'] == 'user_id'?'/?sort=-user_id':'/?sort=user_id'?>" >User</a>
                        </div>
                    <?php else: ?>
                        <div class="lenk-sot" style="margin-left: -10px; ">
                            <a href="/?sort=user_id">User</a>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($params['sort'])&& ($params['sort']=='team_id'|| $params['sort']=='-team_id')):?>
                        <div class="lenk-sot active" ">
                            <a href="<?= $params['sort'] == 'team_id'?'/?sort=-team_id':'/?sort=team_id'?>">Team</a>
                        </div>
                    <?php else: ?>
                        <div class="lenk-sot" ">
                            <a href="/?sort=team_id">Team</a>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($params['sort'])&& ($params['sort']=='victories'|| $params['sort']=='-victories')):?>
                        <div class="lenk-sot active" ">
                            <a href="<?= $params['sort'] == 'victories'?'/?sort=-victories':'/?sort=victories'?>">Victories</a>
                        </div>
                    <?php else: ?>
                        <div class="lenk-sot"">
                            <a href="/?sort=victories">Victories</a>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($params['sort'])&& ($params['sort']=='loss'|| $params['sort']=='-loss')):?>
                        <div class="lenk-sot active" >
                            <a href="<?= $params['sort'] == 'loss'?'/?sort=-loss':'/?sort=loss'?>">Loss</a>
                        </div>
                    <?php else: ?>
                        <div class="lenk-sot" ">
                            <a href="/?sort=loss">Loss</a>
                        </div>
                    <?php endif; ?>
                     <?php if(!empty($params['sort'])&& ($params['sort']=='rate'|| $params['sort']=='-rate')):?>
                        <div class="lenk-sot active" >
                            <a href="<?= $params['sort'] == 'rate'?'/?sort=-rate':'/?sort=rate'?>">W/L Rate</a>
                        </div>
                    <?php else: ?>
                        <div class="lenk-sot" ">
                            <a href="/?sort=rate">W/L Rate</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'showHeader'=> false,
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

<?php endif; ?>
