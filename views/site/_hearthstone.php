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
                        [
                            'label'=>Yii::t('app','card'),
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4" style="margin-top: 25px;">
                            <div class="contener-card-img-autsid col-sm-5">
                                <?=$valuex->getImg() ?>
                            </div>
                            <div class="card-opis-block-auts col-sm-7" >
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