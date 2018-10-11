<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'tournament statistics';
?>

<div class="container">
    <h3>Tournament statistics</h3>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary' => false,
            //'tableOptions' =>['class' => 'table table-bordered table-hover dataTable'],
            'columns' => [

                [
                    'attribute'=> 'name',
                    'label'=>'Tournament name',
                    'options' => ['width' => '180'],
                ],
                [
                    'attribute'=> 'game_id',
                    'label' => 'Game',
                    'options' => ['width' => '180'],
                    'content' => function($data) {
                        if (!is_object($data->game)) {
                            return 'Not game';
                        }
                        return $data->game->name;
                    },
                ],
              //   [
              //       'attribute'=>'title',
              //       'label'=>'Статья',
              //       'options' => ['width' => '500'],
              //       'filterInputOptions' => [ 
              //           'placeholder'  =>  'Введите название',
              //           'class'  =>  'form-control',
              //       ]
              //   ],
              //           //'material:ntext',
              //   [
              //       'attribute'=>'created_at',
              //       'label'=>'Дата создания',
              //       'format' => 'date',
              //       'options' => ['width' => '200'],
              //       'filterInputOptions' => [ 'type'  =>  'date','class'  =>  'form-control' ,],
              //   ],

              //   [
              //       'attribute'=>'category_id',
              //       'label'=>'Категория',
              //       'content'=>function($data) {
              //           if (!is_object($data->category)) {
              //               return 'Нет категории';
              //           }
              //           return $data->category->title;
              //       },
              //       'filter' => yii\helpers\ArrayHelper::map(common\models\Category::find()->all(),'id','title'),
              //       'filterInputOptions' => [ 'class'  =>  'form-control' , 'prompt' => 'Все категории',],
              //   ],

              //   [
              //       'attribute' => 'status',
              //       'format'=> 'raw',
              //       'filter' => [1 =>'Активный' ,0 =>'Не активный' ],
              //       'filterInputOptions' => [ 'class' => 'form-control' ,'prompt' => 'Статус',],
              //       'value' => function($data) {
              //           $src = Url::to(['materials/status','id' => $data->id]);
              //           if ($data->status) {
              //             return '<a href="'.$src.'" class="fa fa-toggle-on fa-2x status_toglle" ></a>';  
              //         }
              //         return '<a href="'.$src.'" class="fa fa-toggle-off fa-2x status_toglle" ></a>';
              //     }
              // ],

        ],
        ]); ?>
    </div>
</div>