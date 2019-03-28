<?php

namespace app\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use app\models\UserTeam;
use app\models\ScheduleTeams;
use app\models\TournamentTeam;
use app\models\BallMatch;
use yii\db\Expression;
use app\models\MessageUser;

class TestController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $userteam = new UserTeam();
        $userteam->id_team = 18;
        $userteam->id_user = 2;
        $userteam->status = 2;

       	var_dump( $userteam->save());

        $userteam->delete();
        
    }

    public function actionShelude()
    {
        $match = new ScheduleTeams();
        $match->tournament_id = 1;
        $match->team1 = 1;
        $match->team2 = 18;
        $match->tur =1;

        $match->save();


        $match_new = ScheduleTeams::findOne($match->id);
        $match_new->results1 = 2;
        $match_new->results2 = 5;
        //$match_new->save();
       	var_dump($match_new->save());
       	$match_new->delete();
    }


    public function actionTournament()
    {
        $tournament = new TournamentTeam();
        $tournament->tournament_id =1;
        $tournament->team_id =18;
        $tournament->status =2;
        
       	var_dump($tournament->save());
       	$tournament->delete();
    }

    public function actionBall()
    {
        BallMatch::updateAll(
            ['`played`' => new Expression("`played` + 1")], 
            [ 'tournament_id' => 12, 'team_id'=>19]
        );
    }
    public function actionTeams()
    {
        $teams = MessageUser::find()
                ->joinWith('senders a')->joinWith('recipients b')
                ->where(['type'=> MessageUser::TEAM])->asArray()->all();
        echo "<pre>";
        print_r($teams);
        echo "</pre>";exit;
    }
}