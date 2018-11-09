<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use app\models\servises\FlagServis;
    $this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    $this->registerCssFile('css/team.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = $model->name;

    $user = false;
    if (Yii::$app->user->identity) {
        $user = Yii::$app->user->identity->id;
    }

?>

<section class="image-header" style="min-height: 450px; background: url(<?=$model->background()?>) no-repeat right;background-size: cover;">
    <div class="player-photo geme-foto" style="top:300px;">
        <img class="img-responsive" src="<?=FlagServis::getLinkFlag($model->country);?>" alt="flag">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="info">
                    <div class="wrap">
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>

<!-- end image-header -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="captain-bage">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Name</font>
                </font>
            </div>
            <h4 class="player-name">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;"><?=$model->name?></font>
                </font>
            </h4>
        </div>
        <div class="col-md-3">
            <div class="player-photo">
                <img class="img-responsive" src="<?=$model->avatar()?>" alt="игрок">
            </div>
        </div>
        <div class="col-md-9">
           <div class="summary">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Nationality:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <img src="<?=FlagServis::getLinkFlag($model->country);?>" style="height:15px;" alt="flag">
                        <?=$model->country?>
                    </div>
                </div>  
                <div class="row" style="margin-bottom: 15px;">  
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Sex:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=($model->sex == 1 )? 'Male': (($model->sex == 2 )?'Female': '----') ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Date of Birth:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=date('Sj F ',strtotime($model->birthday))?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Favorite game:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?php if ($model->gameF):?>
                            <img  style="height: 25px;" src="/images/game/<?=$model->gameF->logo;?>" alt="<?=$model->gameF->name;?>">
                            <?=$model->gameF->name;?>
                        <?php else: ?>
                            ----
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row player-hockey-wrap" style="margin-bottom: 15px;background-color: transparent;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Fair play:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9 ">
                            <div class="wrapper-circle">
                                <div class="circle-item" >
                                    <div class="circle-bar" id="circle_1" data-percent="<?=$model->fair_play?>">
                                    </div>
                                    <?php if($user && $capitan_tournament):?>
                                    <?php if($capitan_tournament->tournament->user_id == $user):?>
                                    <form action="/user/remove-rating/<?=$model->id?>" method="POST">
                                        <input type="text" name="tournament" hidden value="<?=$capitan_tournament->tournament->id ?>" >
                                        <?= Html::hiddenInput(
                                            \Yii::$app->getRequest()->csrfParam, 
                                            \Yii::$app->getRequest()->getCsrfToken(), 
                                            []
                                        );?>
                                        <?php
                                            $disabled = '';
                                            if($capitan_tournament->fair_play){
                                                $disabled = 'disabled';
                                            }
                                        ?>
                                        <button class="btn btn-red btn-sm" <?=$disabled?>
                                            style="margin-left:25px;" >
                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                            Remove rating
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Activities:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->activities)?$model->activities:'----' ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b>Interests:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->interests)?$model->interests:'----' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end image-header -->
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-12">
                <h6>team member</h6>
                <div class="overflow-scroll">
                    <table>
                        <tbody>
                            <tr>

                                <th class="club">Team</th>
                                <th>Game</th>
                                <th>Victories</th>
                                <th>Loss</th>
                                <th>W/L Rate</th>
                            </tr>
                            <?php foreach($statistic_team as $team ): ?>
                            <tr>
                                
                                <td class="club">
                                    <a href="<?=$team->team->links()?>">
                                        <span class="team">
                                            <img src="<?=$team->team->logo()?>" width="30" height="30" alt="trophy">
                                        </span> 
                                        <span style="margin: auto"><?=$team->team->name?></span>
                                    </a>
                                </td>
                                <td>
                                     <span class="team">
                                            <img src="/images/game/<?=$team->game->logo?>" width="30" height="30" alt="trophy">
                                        </span> 
                                    <span style="margin: auto"><?=$team->game->name?></span>
                                </td>
                                <td><?=$team->victories??'0'?></td>
                                <td><?=$team->loss??'0'?></td>
                                <td><span><?=$team->rate?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


