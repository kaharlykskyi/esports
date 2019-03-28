<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;
use app\models\StatisticCardsHearthstone;

?>
<div class="container" style="margin-top: 25px;">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-9">
            <ul class="tab-filters">
                <li class="active"><a href="#users_statistics"><?=Yii::t('app', 'users statistics')?></a></li>
                <li><a href="#cards_statistics"><?=Yii::t('app', 'cards statistics')?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="tab-content">
        <div class="tab-pane active" id="users_statistics" >
            <div class="box-body">
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
                    'tableOptions' =>['class' => 'table-statistic games'],
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
                        [
                            //'label'=>Yii::t('app','card'),
                            'contentOptions' => ['class' => 'column-img-game'],
                            'content' => function($data) {
                                $model = StatisticCardsHearthstone::cardsStatisticOne($data->user->id);
                                if (is_object($model)) {
                                    return $model->getImg();
                                }
                                return '------';
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
     <div class="tab-pane" id="cards_statistics" >
        <div class="col-sm-12 " style="margin-bottom: 30px;">
            <?php $array_model = StatisticCardsHearthstone::getCardsStatistic(); ?>
            <?php if(!empty($array_model)):?>
            <div class="stats-title"><span>MOST PICKED CLASSES</span></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-xs-4 card-her-lider">
                            <?php 
                                $first_cart = array_shift($array_model);
                            ?>
                            <div class="contener-card-img">
                                <?=$first_cart->getImg() ?>
                            </div>
                            <div class="card-opis-block">
                                <div class="title" >
                                    <span > <?=$first_cart->getNameCard()?> </span>
                                </div> 
                                <div class="players" >
                                    <span > <?=$first_cart->c?>  Times selected</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 card-her-lider">
                            <?php 
                                $first_cart = array_shift($array_model);
                            ?>
                            <div class="contener-card-img">
                                <?=$first_cart->getImg() ?>
                            </div>
                            <div class="card-opis-block">
                               <div class="title" ><span > <?=$first_cart->getNameCard()?> </span></div> 
                                <div class="players" ><span > <?=$first_cart->c?>  Times selected</span></div>
                            </div>
                        </div>
                        <div class="col-xs-4 card-her-lider">
                            <?php 
                                $first_cart = array_shift($array_model);
                            ?>
                            <div class="contener-card-img">
                                <?=$first_cart->getImg() ?>
                            </div>
                            <div class="card-opis-block">
                               <div class="title" ><span > <?=$first_cart->getNameCard()?> </span></div> 
                                <div class="players" ><span > <?=$first_cart->c?>  Times selected</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stats-title"><span>LESS POPULAR CLASSES</span></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                    <?php foreach ($array_model as $keyx => $valuex): ?>
                        <div class="col-xs-4" style="margin-top: 25px;">
                            <div class="contener-card-img-autsid col-md-5">
                                <?=$valuex->getImg() ?>
                            </div>
                            <div class="card-opis-block-auts col-md-7" >
                               <div class="title" ><span > <?=$valuex->getNameCard()?> </span></div> 
                                <div class="players" ><span > <?=$valuex->c?>  Times selected</span></div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
     </div>
</div>
</div>