<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use Yii;

$this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
$this->title = Yii::t('app','Tournament statistics');
?>

<div class="container">
    <h3 style="text-align: center;" ><?=Yii::t('app','Tournament statistics')?></h3>
    <form  method="GET">
        <!--  //Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(),[]); -->
    <div class="col-md-10 col-md-offset-1 search_tournament" style="margin-top:20px;margin-bottom:20px;">
        <div class="col-md-10">
            <input type="text" placeholder="Tournament name" name="SerchTournaments[name]" autocomplete="off" >
        </div>
        <div class="col-md-2">
            <button class="btn" ><span class="glyphicon glyphicon-search"></span> 
                <?=Yii::t('app','Search')?>
            </button>
        </div>
    </div>
    </form>
    <div class="box-body">
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
                    'attribute' => 'banner',
                   // 'label'=>'Tournament logo',
                    'header' => Yii::t('app','Tournament logo'),
                    'content' => function($data) {
                        return "<img src='{$data->logo}' alt='logo'>";
                    }
                ],

                [
                    'attribute'=> 'name',
                    'label'=> Yii::t('app','Tournament name'),
                ],

                [
                    'attribute'=> 'game_id',
                    'label' => Yii::t('app','Game'),
                    'content' => function($data) {
                        if (!is_object($data->game)) {
                            return 'Not game';
                        }
                        return $data->game->name;
                    },
                ],

                [
                    'attribute'=> 'prize_pool',
                    'label' => Yii::t('app','Prize pool'),
                    'content' => function($data) {
                        return $data->prize_pool ? '$'.$data->prize_pool: '--';
                    },
                ],

                [  
                    'attribute'=> 'created_at',
                    'label' => Yii::t('app','Date start'),
                    'format' => ['date', 'php:Y-m-d'],
                ],
            ],
        ]); ?>
    </div>
</div>
