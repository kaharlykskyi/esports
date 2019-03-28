<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\servises\FlagServis;
app\modules\admin\assets\GameAsset::register($this);

$this->title = 'Games';

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
                        <p style="margin-bottom: 30px;">
                            <a href="<?=Url::to(['/admin/games/create'])?>" class="btn btn-lg btn-info">
                                <i class="glyphicon glyphicon-pencil"></i>&nbsp; Create game
                            </a>
                        </p>                        
                        <table class="table table-borderless table-striped table-earning" >
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name game</th>
                                    <th>Alias game</th>
                                    <th>Enable / disable</th>
                                    <th>Edit / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($games as $game): ?>
                                <tr>
                                    <td>
                                        <img src="/images/game/<?=$game->logo?>" alt="logo" style="height: 50px;">
                                    </td>
                                    <td><?=$game->name?></td>
                                    <td><?=$game->alias?></td>
                                    <td>
                                        <?php $src = Url::to(['/admin/games/toglle','id' => $game->id]);
                                            if ($game->status):
                                        ?>
                                            <a href="<?=$src?>"  class="fa fa-toggle-on fa-2x status_toglle"></a>
                                        <?php else: ?>
                                            <a href="<?=$src?>" class="fa fa-toggle-off fa-2x status_toglle" ></a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?=Url::to(['/admin/games/update','id' => $game->id])?>" class="btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-pencil"></i>&nbsp; Edit
                                        </a>
                                        <span  class="delet-game-link btn btn-danger btn-sm"
                                            data-link="<?=Url::to(['/admin/games/delete','id' => $game->id])?>">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>