<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use app\models\servises\FlagServis;
    use app\models\StatisticCardsHearthstone;

    $this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    $this->registerCssFile('css/team.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = $model->name;

    $user = false;
    if (Yii::$app->user->identity) {
        $user = Yii::$app->user->identity->id;
    }
    if(!empty($user_points_month)){
        $sum = json_encode(ArrayHelper::getColumn($user_points_month, 'sum'));
        $y_m = json_encode(ArrayHelper::getColumn($user_points_month, 'y_m'));
        $js_cod ="
            $(document).ready(function(){
                if ($('#bonus-bal').length > 0) {
                    let sum = {$sum};
                    let y_m = {$y_m};
                    $('#bonus-bal').teamGraphTimeseries(y_m,[sum],[0, 50, 100, 150],
                    '250px',true,);
                }
            });
        ";
        $this->registerJs($js_cod, yii\web\View::POS_END);
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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="captain-bage">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        <?=Yii::t('app','Name')?>
                    </font>
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
                        <div class="item">
                            <b><?=Yii::t('app','Nationality')?>:</b>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <img src="<?=FlagServis::getLinkFlag($model->country);?>" style="height:15px;" alt="flag">
                        <?=$model->country?>
                    </div>
                </div>  
                <div class="row" style="margin-bottom: 15px;">  
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Sex')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=($model->sex == 1 )? Yii::t('app','Male'): (($model->sex == 2 )?Yii::t('app','Female'): '----') ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Date of Birth')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=date('Sj F ',strtotime($model->birthday))?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Favorite game')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?php if ($model->gameF):?>
                            <img  style="height: 25px;" src="/images/game/<?=$model->gameF->logo;?>" 
                            alt="<?=$model->gameF->name;?>">
                            <?=$model->gameF->name;?>
                        <?php else: ?>
                            ----
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Favorite card in game Hearthstone')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?php 
                            $favorite_card = StatisticCardsHearthstone::cardsStatisticOne($model->id); 
                            if (is_object($favorite_card)) {
                                echo "<p class='card-f-herst'>{$favorite_card->img}</p>";
                            } else {
                                echo "----";
                            }
                        ?>
                    </div>
                </div>

                <div class="row player-hockey-wrap" style="margin-bottom: 15px;background-color: transparent;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Fair play')?>:</b></div>
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
                                            <?=Yii::t('app','Remove rating')?>
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
                        <div class="item"><b><?=Yii::t('app','Activities')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->activities)?$model->activities:'----' ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Interests')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->interests)?$model->interests:'----' ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item">
                            <b><?=Yii::t('app','Link to social networks')?>:</b>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9 social-links">
                        <?php $links = $model->social_links; 
                            foreach ($links as $link) {
                                echo "<a href='{$link->link}'>{$link->icon}</a>  ";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="broadcast-list" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="broadcast-item">
            <div class="item-header" id="headingOne">
                <div class="row">
                    <div class="col-md-1 col-sm-2">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="arrow collapsed" aria-expanded="false"><i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col-md-7 col-sm-10">
                        <div class="item-head-body">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="item">
                                    <b><?=Yii::t('app','Sum of balls')?>:</b>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8"> 
                                <?=$model->ball?> 
                                <?=Yii::t('app','ball')?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <?php $cup_arry = $model->cup ?>
                        <div class="channel">
                            <p><span> 
                            <?php 
                                if(empty($cup_arry[0])) {
                                    echo Yii::t('app','No awards'); 
                                } else {
                                    echo $cup_arry[0]; 
                                }
                            ?>
                            </span></p>
                                <p>  
                                    <?= $cup_arry[1]; ?>
                                </p>
                        </div>
                    </div>
                </div>  
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="timeline-bar">
                            <div class="cup_img cup_img1" >
                                <p>
                                    <img src="/images/profile/cup/bronze.svg" alt="bronze" title="1000 balls">
                                </p>
                                <p><span><?=Yii::t('app','Вronze cup')?> </span></p>
                            </div>
                            <div class="cup_img cup_img2" >
                                 <p>
                                    <img src="/images/profile/cup/silver.svg" alt="silver" title="2000 balls">
                                </p>
                                <p><span><?=Yii::t('app','Silver cup')?></span></p>
                            </div>
                            <div class="cup_img cup_img3" >
                                <p>
                                    <img src="/images/profile/cup/gold.svg" alt="gold" title="3000 balls">
                                </p>
                                <p><span><?=Yii::t('app','Gold cup')?></span></p>
                            </div>
                            <div class="cup_img cup_img4" >
                                <p>
                                    <img src="/images/profile/cup/epic.svg" alt="epic" title="4000 balls">
                                </p>
                                <p><span><?=Yii::t('app','Epic cup')?></span></p>
                            </div>
                            <div class="cup_img cup_img5" >
                                <p>
                                    <img src="/images/profile/cup/legendary.svg" alt="legendary" title="6000 balls">
                                </p>
                                <p><span><?=Yii::t('app','Legendary cup')?></span></p>
                            </div>
                            <div class="bar">
                                <div class="date date-1" ></div>
                                <div class="date date-2" ></div>
                                <div class="date date-3" ></div>
                                <div class="date date-4" ></div>
                                <div class="date date-5" ></div>
                            </div>
                            <?php 
                                $result_persent = $model->ball/60;
                                if ($result_persent>100) {
                                    $result_persent = 100;
                                }
                            ?>
                            <div class="bar bar-result" style="width:<?=$result_persent?>%;">
                                <div class="date date-i" ></div>
                                <div class="my-result" >
                                    <p><?=Yii::t('app','My ball')?></p>
                                    <p><?=$model->ball?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!empty($user_points)):?>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <table>
                            <tbody>
                                <tr>
                                    <th class="club">
                                        <?=Yii::t('app','Name')?>
                                    </th>
                                    <th>
                                        <?=Yii::t('app','Ball')?>
                                    </th>
                                    <th><?=Yii::t('app','Date')?></th>
                                </tr>
                                <?php foreach($user_points as $user_point ): ?>
                                <tr>
                                    <td class="club">
                                        <?=$user_point->nameBonus?>
                                    </td>
                                    <td><span><?=$user_point->appraisal?></span></td>
                                    <td><?=$user_point->created_at?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($user_points_month)):?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h6><?=Yii::t('app','amount of points by months')?></h6>
            <div class="ct-chart" id="bonus-bal"></div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($statistic_team)): ?>
                <h6><?=Yii::t('app','team member')?></h6>
                <div class="overflow-scroll">
                    <table>
                        <tbody>
                            <tr>
                                <th class="club"><?=Yii::t('app','Team')?></th>
                                <th><?=Yii::t('app','Game')?></th>
                                <th><?=Yii::t('app','Victories')?></th>
                                <th><?=Yii::t('app','Loss')?></th>
                                <th><?=Yii::t('app','W/L Rate')?></th>
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
                                    <span style="margin: auto">
                                        <?=$team->game->name?>
                                    </span>
                                </td>
                                <td><?=$team->victories??'0'?></td>
                                <td><?=$team->loss??'0'?></td>
                                <td><span><?=$team->rate?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


