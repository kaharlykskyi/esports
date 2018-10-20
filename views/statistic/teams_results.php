<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = 'Tournament statistics';
?>

<div class="container">
    <h3 style="text-align: center;" >Teams statistics</h3>
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
                    'label'=>'K/D Rate',
                ],
            ],
        ]); ?>
    </div>
</div>
