<?php

namespace app\models\servises;

use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use app\models\UsersMatch;
use app\models\TournamentTeam;
use app\models\TournamentUser;
use app\models\TournamentCupTeam;
use Yii;
use app\models\Tournaments;
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
                $arry = [];
                $json1 = json_decode($team1_users[$i]->text,true);
                $json2 = json_decode($team2_users[$i]->text,true);
                if ($tournament->game_id == 1) {
                    $user_match->data = json_encode([$json1[1],$json2[1]]);
                } elseif ($tournament->game_id == 2) {
                    $user_match->data = json_encode([$json1,$json2]);
                } 
                $user_match->save();
            }
        }
	}

   public static function addTur($id,$tournament,$round)
   {
        $user_matches = UsersMatch::findAll(['match'=>$id,'state'=>null,'tournament_id'=>$tournament,'round'=>$round]);
        if (empty($user_matches)) {
            return false;
        }

        $array_user1 = [];
        $array_user2 = [];
        foreach ($user_matches as $user_match) {
            if(!is_numeric($user_match->results1)
                ||!is_numeric($user_match->results2)
                ||($user_match->results2==$user_match->results1))
            {
                return false;
            }
            if ($user_match->results1>$user_match->results2) {
                $array_user1[] = $user_match->user1;
            } elseif ($user_match->results1<$user_match->results2) {
                $array_user2[] = $user_match->user2;
            }
        }

        $result = UsersMatch::updateAll(['state' => 1], ['match'=>$id,'state'=>null,'tournament_id'=>$tournament,'round'=>$round]);

        if ((count($array_user1) == count($array_user2))) {
            $count = count($array_user1);
            if ($result) {
               
                for ($i=0; $i < $count; $i++) { 
                    $new_mathc = new UsersMatch();
                    $new_mathc->user1 = $array_user1[$i];
                    $new_mathc->user2 = $array_user2[$i];
                    $new_mathc->round = ($round + 1);
                    $new_mathc->tournament_id = $tournament;
                    $new_mathc->match = $id;
                    $new_mathc->data = self::addJsonDate($array_user1[$i],$array_user2[$i],$tournament);
                    $new_mathc->save();
                }
            }
        } else {
            $match = ScheduleTeams::findOne($id);
            if ((count($array_user1) > count($array_user2))) {
                $match->results1 = 1;
                $match->results2 = 0;
            } elseif ((count($array_user1) < count($array_user2))) {
                $match->results1 = 0;
                $match->results2 = 1;
            }
            if ($match->save()){
                UsersMatch::updateAll(['state' => 1], ['match'=>$id,'state'=>null,'tournament_id'=>$tournament]);
            }
        }
   }

   private static function addJsonDate($array_user1,$array_user2,$tournament)
   {
        $user_team1 = UsetTeamTournament::findOne(['tournament_id' => $tournament,'user_id'=>$array_user1]);
        $user_team2 = UsetTeamTournament::findOne(['tournament_id' => $tournament,'user_id'=>$array_user2]);
        $tournament = Tournaments::findOne($tournament);
        $arrayJsonData = [];
        if (is_object($user_team1)&&is_object($user_team2)&&is_object($tournament)) {
            
            if (!empty($user_team1->text)) {
               $user_team1 = json_decode($user_team1->text,true);
            } else {
                $user_team1 = false;
            }

            if (!empty($user_team2->text)) {
               $user_team2 = json_decode($user_team2->text,true);
            } else {
                $user_team2 = false;
            }

            if($tournament->game_id == 1) {
                $arrayJsonData = [$user_team1[1]??[],$user_team2[1]??[]];
            }

            if($tournament->game_id == 2) {
                $arrayJsonData = [$user_team1??[],$user_team2??[]];
            }
            return json_encode($arrayJsonData);
        }
   }

}