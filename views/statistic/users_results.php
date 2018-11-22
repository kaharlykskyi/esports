<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\servises\FlagServis;
use yii\widgets\Pjax;
use Yii;

    $this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = 'News';
?>


<div class="container">
    <h3 style="text-align: center;" ><?=Yii::t('app','Users statistics') ?></h3>
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
                    'label' => 'User',
                    'content' => function($data) {
                        $flag_src = FlagServis::getLinkFlag($data->user->country);
                        return "<a href='/user/public/{$data->user->id}' ><img src= '{$flag_src}' 
                                style='height:28px;'>  {$data->user->name}</a>";
                    }
                ],
                [
                    'attribute' => 'team_id',
                    'label' => 'Team',
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
                    'label'=> Yii::t('app','W/L Rate'),
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
