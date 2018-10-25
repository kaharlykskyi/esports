<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\servises\FlagServis;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = 'Users statistics';
?>

<div class="container">
    <h3 style="text-align: center;" >Users statistics</h3>
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
                    'attribute' => 'user_id',
                    'label' => 'User',
                    'content' => function($data) {
                        $flag_src = FlagServis::getLinkFlag($data->user->country);
                        return "<a href='/' ><img src= '{$flag_src}' style='height:28px;'>  {$data->user->name}</a>";
                    }
                ],

                [
                    'attribute' => 'team_id',
                    'label' => 'Team',
                    'content' => function($data) {
                        return "<a href='{$data->team->links()}' ><img src= '{$data->team->logo()}' style='height:28px;'>  {$data->team->name}</a>";
                    }
                ],

                [
                    'attribute' => 'victories',
                    'label' => 'victories',
                ],

                [
                    'attribute' => 'loss',
                    'label' => 'loss',
                ],

                [
                    'attribute' => 'rate',
                    'label'=>'W/L RATE',
                ],
            ],
        ]); ?>
    </div>
</div>
