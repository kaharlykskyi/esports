<?php

use yii\helpers\Html;

$this->title = 'Match';

$script = "$.matchDate = ".(strtotime($model->date)-time()).";";
$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/match.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);


       

$team1 = $model->teamF;
$team2 = $model->teamS;
$model->date;
?>
    <!--MATCH PAGE TOP BEGIN-->
    <div class="match-page-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="upcoming-match-info">
                        <div class="team">
                            <div class="avatar"><img src="<?=$team1->logo?>" alt="match-list-team-img"></div>
                            <div class="text">
                                <?=$team1->name ?> <span><?= $team1->game->name ?></span>
                                <div class="latest">
                                    <div class="latest-title">Latest Results</div>
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
                        </div>
                        <div class="team right">
                            <div class="text">
                                <?=$team2->name ?> <span><?= $team2->game->name ?></span>
                                <div class="latest">
                                    <div class="latest-title">Latest Results</div>
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
                            <div class="avatar"><img src="<?=$team2->logo?>" alt="match-list-team-img"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MATCH PAGE TOP END-->