<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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
                                    'options' => ['width' => '500']
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
                                'options' => ['width' => '100'],
                                'filterInputOptions' => [ 'type'  =>  'date','class'  =>  'form-control' ,],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=>'Action', 
                                'headerOptions' => ['width' => '80'],
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