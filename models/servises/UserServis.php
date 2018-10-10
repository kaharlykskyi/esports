<?php

namespace app\models\servises;

use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\User;
use app\models\UserTeam;
use app\models\UsersMatch;
use app\models\TournamentTeam;
use app\models\TournamentUser;
use app\models\TournamentCupTeam;
use Yii;
use yii\web\HttpException;
use app\models\ScheduleTeams;
use app\models\UsetTeamTournament;


class UserServis
{
	public function scheduleUsers ($match,$tournament)
	{
		$team1_users = UsetTeamTournament::findAll(['tournament_id'=>$tournament->id,'team_id'=>$match->team1]);
        $team2_users = UsetTeamTournament::findAll(['tournament_id'=>$tournament->id,'team_id'=>$match->team2]);
        if ((count($team2_users) == count($team1_users))&&!empty($team2_users)) {
            shuffle($team1_users);
            shuffle($team2_users);
            $count = count($team1_users);
            for ($i=0; $i < $count; $i++) { 
                $user_match = new UsersMatch();
                $user_match->user1 = $team1_users[$i]->id;
                $user_match->user2 = $team2_users[$i]->id;
                $user_match->tournament_id = $tournament->id;
                $user_match->match = $match->id;
                $user_match->round = 1;
                // $arry = [];
                // $json1 = json_decode($team1_users[$i]->text,true);
                // $json2 = json_decode($team1_users[$i]->text,true);
                // if ($tournament->game_id == 1) {

                //    $arry
                // } elseif ($tournament->game_id == 1) {
  
                // } 
                $user_match->save();
            }
        }
	}

}