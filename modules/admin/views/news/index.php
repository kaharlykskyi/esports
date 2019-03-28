<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\admin\models\NewsCategory;

$this->title = 'News';

?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body-table">
                        <div class="card-title">
                            <h3 class="text-center title-2"><?=$this->title?></h3>
                        </div>
                        <hr>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' =>['class' => 'table table-borderless table-striped table-earning'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'title',
                                    'label'=>'News Title',
                                    //'options' => ['width' => '500']
                                ],

                                [
                                    'attribute' => 'category_id',
                                    'label'=>'Category',
                                    'filterInputOptions' => [ 'class'  =>  'form-control' ],
                                    'filter' => yii\helpers\ArrayHelper::map(NewsCategory::find()->all(),'id','title'),
                                    'filterInputOptions' => [ 'class'  =>  'form-control' , 'prompt' => 'Все категории',],
                                    'value' => function($data) {
                                        return $data->category->title;
                                    }
                                ],

                                [
                                    'attribute' => 'state',
                                    'format'=> 'raw',
                                    'filter' => [1 =>'Published' ,0 =>'Not Published' ],
                                    'filterInputOptions' => [ 'class' => 'form-control' ,'prompt' => 'State',],
                                    'value' => function($data) {
                                        $src = Url::to(['/admin/news/state','id' => $data->id]);
                                        if ($data->state) {
                                          return '<a href="'.$src.'" class="fa fa-toggle-on fa-2x status_toglle" ></a>';  
                                        }
                                            return '<a href="'.$src.'" class="fa fa-toggle-off fa-2x status_toglle" ></a>';
                                    }
                                ],

                                [
                                    'attribute' => 'created_at',
                                    'label'=>'Date of creation',
                                    'format' =>  ['date', 'dd-MM-Y'],
                                    'filterInputOptions' => [ 'type'  =>  'date','class'  =>  'form-control' ,],
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header'=>'Action',
                                    'class' => 'yii\grid\ActionColumn',
                                    'buttons'=>[
                                        'delete' => function ($url,$model) {
                                            return '&nbsp;&nbsp;'.Html::a(
                                                '<span style="color:red;"  class="glyphicon glyphicon glyphicon-trash"></span>', 
                                                $url);
                                        },
                                    ],
                                    'template'=>'{update}{delete}',
                                ],
                        ],
                        ]); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>