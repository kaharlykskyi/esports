<?php

use yii\helpers\Html;
use app\models\Tournaments;

$this->title = Yii::t('app','Match');

$userMatchs = $model->userMatch;
$count_round = 1;
foreach ($userMatchs as $userMatchi) {
    if ($count_round < $userMatchi->round) {
        $count_round = $userMatchi->round;
    }
}
$count_round--;

$time_start = (strtotime($model->date)+(3600*$count_round))-time();

$script = "$.matchDate = ".$time_start.";";
$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile(
    'css/tournament-public.css', 
    ['depends' => ['app\assets\AppAsset']]
);
$this->registerCssFile(
    'css/match.css', 
    ['depends' => ['app\assets\AppAsset']]
);
$this->registerJsFile(
    '/js/profile/match.js',
    ['depends' => 'yii\web\JqueryAsset',
    'position' => yii\web\View::POS_END
]);
     
$team1 = $model->teamF;
$team2 = $model->teamS;
$tournament = $model->tournament;
$second = (time() - strtotime($model->date))-(3600*$count_round);
$user_id = false;
    if (!\Yii::$app->user->isGuest){
        $user_id = \Yii::$app->user->identity->id;
    }
    //$user_id =12;
?>

    <div class="time-match" >
        <h3 style="color: #2e7ad2;"> <?=Yii::t('app','date of the match')?> </h3> 
        <span><?=date(' d \of F, H:i ',strtotime($model->date))?></span>
    </div>
    <!--MATCH PAGE TOP BEGIN-->
    <div class="match-page-top" style="margin-top: 35px; background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="upcoming-match-info">
                        <div class="team">
                            <div class="avatar"><a href="<?=$team1->links() ?>"><img src="<?=$team1->logo()?>" alt="match-list-team-img"></a></div>
                            <div class="text">
                                <a href="<?=$team1->links() ?>">
                                    <?=$team1->name() ?>
                                </a>
                                <span><?= $team1->game->name ?></span>
                                <div class="latest">
                                    <div class="latest-title"><?=Yii::t('app','Latest Results')?></div>
                                    <?php $res = $model->getFiveResult();?> 
                                    <?php foreach ($res['result1'] as $int){
                                        if ($int == 1) {
                                           echo "<span class='win' >w</span>";
                                        }
                                        if ($int == 2) {
                                            echo "<span class='lose'>l</span>";
                                        }
                                        if ($int == 3) {
                                           echo "<span class='drawn'>d</span>";
                                        }
                                    } ?>
                                </div>
                            </div> 
                        </div>
                        <div class="counter">
                            <ul>
                                <li>
                                    <div class="digit digit_h">0</div>
                                </li>
                                <li>
                                    <div class="digit digit_m">0</div>
                                </li>
                                <li>
                                    <div class="digit digit_s">0</div>
                                </li>
                            </ul>
                            <div class="clearfix results" >
                                <div class="result-left" >
                                    <?php if($model->results1>$model->results2):?>
                                        <span class="winner">VICTORY</span>
                                    <?php endif; ?>
                                    <?php if($model->results2>$model->results1):?>
                                        <span class="loser">DEFEATED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="result-right" >
                                    <?php if($model->results2>$model->results1):?>
                                        <span class="winner">VICTORY</span>
                                    <?php endif; ?>
                                    <?php if($model->results1>$model->results2):?>
                                        <span class="loser">DEFEATED</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="team ">
                            <div class="avatar">
                                <a href="<?=$team2->links() ?>">
                                    <img src="<?=$team2->logo()?>" alt="match-list-team-img">
                                </a>
                            </div>
                            <div class="text">
                                <a href="<?=$team2->links() ?>">
                                    <?=$team2->name() ?> 
                                </a>
                                <span><?= $team2->game->name ?></span>
                                <div class="latest">
                                    <div class="latest-title"><?=Yii::t('app','Latest Results')?></div>
                                    <?php foreach ($res['result2'] as $int){
                                        if ($int == 1) {
                                           echo "<span class='win' >w</span>";
                                        }
                                        if ($int == 2) {
                                            echo "<span class='lose'>l</span>";
                                        }
                                        if ($int == 3) {
                                           echo "<span class='drawn'>d</span>";
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MATCH PAGE TOP END-->

        <!--MATCH PAGE TOP BEGIN-->
        <div class="match-page-top" style="background-color: #ffffff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="broadcast-item">
                        
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="lineup-list">
                                            <?php if($tournament->game_id < 3): ?>
                                                <?php  
                                                    $i_count = 0;
                                                ?>
                                                <form action="/matches/result-user" method="POST" >
                                                     <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
                                                    <input type="hidden" name="match" value="<?=$model->id?>">
                                                    <input type="hidden" name="tournament" value="<?=$tournament->id?>">
                                                <?php  foreach ($userMatchs as $userMatch):?>
                                                    <?php if($i_count != $userMatch->round) {
                                                        $i_count =  $userMatch->round;
                                                        echo '<div class="title" style="text-align:center;" >'.
                                                        Yii::t('app','Round').$i_count.'</div>'; 
                                                    }
                                                        $data = json_decode($userMatch->data,true);
                                                    ?>
                                                    <div class="item">
                                                        <div class="col-xs-5" style="padding: 0;">
                                                            <div class="number">
                                                                <?= $this->render('icon',['data' => $data[0],'tournament'=>$tournament])?>
                                                            </div>
                                                            <div class="name"><?=$userMatch->userS->name?></div>
                                                        </div>
                                                        <div class="col-xs-2 input_round_match" style="padding: 0;text-align: center;">
                                                            <?php if (($user_id == $tournament->user_id)&&($second>900)&&!$userMatch->state):?>
                                                            <input maxlength="2" 
                                                                value="<?=$userMatch->results1??''?>"
                                                                type='text' onkeyup = 'this.value=parseInt(this.value) | 0' 
                                                                name="user_match[<?=$userMatch->id?>][results1]"  autocomplete="off"
                                                                >
                                                            <span>:</span>
                                                            <input maxlength="2"
                                                                value="<?=$userMatch->results2??''?>"
                                                                type='text' onkeyup = 'this.value=parseInt(this.value) | 0'
                                                                name="user_match[<?=$userMatch->id?>][results2]" autocomplete="off">
                                                            <input type="hidden" name="user_match[<?=$userMatch->id?>][id]" value="<?=$userMatch->id?>">
                                                            <?php else: ?>
                                                                <div style="margin-top: 7px;display: inline-block;">
                                                                    <b><?=$userMatch->results1??'--'?></b>
                                                                    <b>:</b>
                                                                    <b><?=$userMatch->results2??'--'?></b>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-xs-5" style="padding: 0;">
                                                            <div class="number" style="float: right;">
                                                                <?= $this->render('icon',['data' => $data[1],'tournament'=>$tournament])?>
                                                            </div>
                                                            <div class="name" style="float: right;padding-right: 25px;
                                                            padding-left: 0;"><?=$userMatch->userF->name?></div>
                                                        </div>
                <!-- // ==============================Sistem Ban  ===========================================-->
                                                        <?php $data_tournament = json_decode($tournament->data); ?>
                                                        <?php if (($tournament->game_id==1)&&(!empty($data_tournament->game_mode))&&($data_tournament->game_mode=='Last hero standing')&&($second<-900)):?>
                                                        <?php if (($user_id == $userMatch->userS->id)||($user_id == $userMatch->userF->id)):?>
                                                        <div class="col-md-12" style="background-color: #fff;padding-bottom:10px;text-align: center;">
                                                            <div class="col-md-6 lhs" >
                                                                <?php if($user_id == $userMatch->userS->id): ?>
                                                                    <p class="message_to_ban" ><?=Yii::t('app','Your classes')?></p>
                                                                    <?php $class = ''; ?>
                                                                <?php else :?>
                                                                    <p class="message_to_ban" ><?=Yii::t('app','Ban rival class')?></p>
                                                                    <?php $class = 'rival'; ?>
                                                                <?php endif;?>
                                                                <?php
                                                                    if (!empty($data[0])&&is_array($data)) {
                                                                       foreach ($data[0] as $key => $element) {
                                                                            if (isset($data[2]['user1']) && (int)$data[2]['user1'] == $key) {
                                                                                $class_ban = 'activiti_ban';
                                                                            } else {
                                                                                $class_ban = '';
                                                                            }
                                                                            echo "<img class='img_data ".$class." ".$class_ban."'
                                                                            src='/images/game/hearthstone/".$element.".png'
                                                                            data-data='[".$userMatch->id.",".$userMatch->user1.",".$key."]'>";
                                                                       }
                                                                    }else{
                                                                        echo "no data";
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-6 lhs">
                                                                <?php if($user_id == $userMatch->userF->id): ?>
                                                                    <p class="message_to_ban" ><?=Yii::t('app','Your classes')?></p>
                                                                    <?php $class = ''; ?>
                                                                <?php else :?>
                                                                    <p class="message_to_ban" ><?=Yii::t('app','Ban rival class')?></p>
                                                                    <?php $class = 'rival'; ?>
                                                                <?php endif;?>
                                                                <?php
                                                                    if (!empty($data[1])&&is_array($data)) {
                                                                       foreach ($data[1] as $key => $element) {
                                                                            if (isset($data[2]['user2'])&&$data[2]['user2'] == $key) {
                                                                                $class_ban = 'activiti_ban';
                                                                            } else {
                                                                                $class_ban = '';
                                                                            }
                                                                            echo "<img class='img_data ".$class." ".$class_ban."'
                                                                            src='/images/game/hearthstone/".$element.".png'
                                                                            data-data='[".$userMatch->id.",".$userMatch->user2.",".$key."]'>";
                                                                       }
                                                                    }else{
                                                                        echo "no data";
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
        <!-- // ============================== End Sistem Ban  ===========================================-->
                                                    </div>
                                                <?php endforeach; ?>
                                                <input type="hidden" value="<?=$i_count?>" name="round" >
                                                <div class="col-md-12" style="text-align: center;margin-top: 30px;">
                                                    <button class="btn seve_tur_btn" style="display:none;"><?=Yii::t('app','save')?>
                                                </button>
                                                </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>  
                           
                            <?php if (!\Yii::$app->user->isGuest&&($second>900)&&$tournament->game_id > 2):?>
                            <?php if (\Yii::$app->user->identity->id == $tournament->user_id):?>    
                                <div class="item-body write-result-match">
                                    <?php if($model->active_result!=1): ?>
                                        <h6 style="text-align: center;margin-top: 10px;"><?=Yii::t('app','set match results')?></h6>
                                    <?php else: ?>
                                        <h6 style="text-align: center;margin-top: 10px;"><?=Yii::t('app','match results')?></h6>
                                    <?php endif; ?>   
                                    <div class="row">
                                        <form  method="POST" >
                                        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="col-md-4" style="text-align: right;margin-top: 10px;">
                                                <a href="<?=$team1->links()?>">
                                                    <span><?=$team1->name ?></span>
                                                </a>
                                            </div>
                                            <div class="col-md-4" style="text-align: center;" >
                                                <input maxlength="2" 
                                                    value="<?=$model->results2??''?>"
                                                    autocomplete="off"
                                                    <?=$model->active_result==1?'disabled':''?>
                                                    name="ScheduleTeams[results2]" type='text' 
                                                    onkeyup = 'this.value=parseInt(this.value) | 0'>
                                                <span>:</span>
                                                <input maxlength="2" 
                                                    value="<?=$model->results1??''?>" 
                                                    name="ScheduleTeams[results1]" 
                                                    autocomplete="off"
                                                    <?=$model->active_result==1?'disabled':''?>
                                                    type='text' onkeyup = 'this.value=parseInt(this.value) | 0'>
                                            </div>
                                            <div class="col-md-4" style="text-align: left;margin-top: 10px;">
                                                <a href="<?=$team2->links()?>">
                                                    <span><?=$team2->name ?></span>
                                                </a>
                                            </div>
                                            <div class="row">
                                                <?php if($model->active_result != 1): ?>
                                                <div class="col-md-12" style="text-align: center;margin-top: 20px;">
                                                    <button class="btn" ><?=Yii::t('app','Save result')?></button>
                                                </div> 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php endif;?>
                            <?php if (\Yii::$app->user->isGuest):?>
                                <div class="item-body write-result-match" style="margin-bottom: 40px;">
                                    <h6 style="text-align: center;margin-top: 10px;"><?=Yii::t('app','match results')?></h6>
                                    <div class="col-md-4" style="text-align: right;margin-top: 10px;">
                                        <a href="<?=$team1->links()?>">
                                            <span><?=$team1->name ?></span>
                                        </a>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;" >
                                        <span><b><?=$model->results1??'--'?></b></span>
                                        <span><b><?=$model->results2??'--'?></b></span>
                                    </div>
                                    <div class="col-md-4" style="text-align: left;margin-top: 10px;">
                                        <a href="<?=$team2->links()?>">
                                            <span><?=$team2->name ?></span>
                                        </a>
                                    </div>
                                </div>  
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





