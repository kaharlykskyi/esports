<?php

use yii\helpers\Html;

$this->title = 'Match';



$team1 = $model->teamF;
$team2 = $model->teamS;

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
                                    <span class="win">w</span>
                                    <span class="win">w</span>
                                    <span class="win">w</span>
                                    <span class="win">w</span>
                                    <span class="win">w</span>
                                </div>
                            </div> 
                        </div>
                        <div class="counter">
                            <ul>
                                <li>
                                    <div class="digit">6</div>
                                </li>
                                <li>
                                    <div class="digit">20</div>
                                </li>
                                <li>
                                    <div class="digit">37</div>
                                </li>
                            </ul>
                        </div>
                        <div class="team right">
                            <div class="text">
                                <?=$team2->name ?> <span><?= $team2->game->name ?></span>
                                <div class="latest">
                                    <div class="latest-title">Latest Results</div>
                                    <span class="win">w</span>
                                    <span class="drawn">d</span>
                                    <span class="win">w</span>
                                    <span class="lose">l</span>
                                    <span class="win">w</span>
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