<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\servises\FlagServis;

$this->title = 'Users';

?>
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
                            'tableOptions' => [
                                'class' => 'table table-borderless table-striped table-earning'
                            ],
                            'columns' => [
                                [
                                   'label' => 'ID',
                                   'attribute' => 'id',
                                   'options' => ['width' => '50']
                                ],
                                [
                                   'label' => 'Logo',
                                   'content' => function($data) {
                                        return "<a href='/user/public/{$data->id}'>
                                        <img src='{$data->avatar()}' 
                                        style ='height:35px;'
                                        alt='logo'></a>";
                                    }
                                ],
                                [
                                   'label' => 'Country',
                                   'attribute' => 'country',
                                   'options' => ['width' => '50'],
                                   'content' => function($data) {
                                        $flag = FlagServis::getLinkFlag($data->country);
                                        return "<img src='{$flag}' 
                                        style ='height:20px;'
                                        alt='flag' title='{$data->country}'>";
                                    }
                                ],
                                [
                                   'attribute' => 'username',
                                   'label' => 'Ban',
                                   'content' => function($data) {
                                        $src = Url::to(['/admin/user/single','id' => $data->id]);
                                        return "<a href='{$src}'>{$data->username}</a>";
                                    }
                                ],
                                'email',
                                [
                                   
                                   'label' => 'Ban',
                                   'content' => function($data) {
                                        if ($data->isBaned()){
                                            return "<span class='label label-danger'>ban</span>";;
                                        } else {
                                            return "<span class='label label-success'>no ban</span>";
                                        }
                                    }
                                ],
                            ]
                        ,
                        ]); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>