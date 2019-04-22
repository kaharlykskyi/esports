<?php 

namespace app\models\points;

use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\UsetTeamTournament;

class ManagePoint {

	public static function cteateTournament (Tournaments $tournament)
	{
		$user = $tournament->user;
		$format = null;
		if ( $tournament->format < 3) {
            $format = EventUser::MANAGE_CUP;
        } elseif ( $tournament->format > 2 && $tournament->format < 6) {
            $format = EventUser::MANAGE_LEAGUE;
        } elseif ( $tournament->format == 6) {
            $format = EventUser::MANAGE_SWISS;
        }

		(new EventUser())->create($user->id, EventUser::MANAGE, null, $format);

		$sql = "select count(id) from event_user where  user_id = {$user->id}
                and type = ".EventUser::MANAGE;
        $count_tournaments = (new \yii\db\Query())->select([
            "({$sql} and event = ".EventUser::MANAGE_LEAGUE.") as league,
             ({$sql} and event = ".EventUser::MANAGE_CUP.") as cup,
             ({$sql} and event = ".EventUser::MANAGE_SWISS.") as swiss
            "
        ])->from('event_user')->one();

        $summ = array_sum($count_tournaments);
        if ($summ == 1) {
            $user->addBall(24);
        } elseif  ($summ == 5) {
            $user->addBall(28);
        } elseif  ($summ == 20) {
            $user->addBall(32);
        } elseif  ($summ == 50) {
            $user->addBall(36);
        } elseif  ($summ == 500) {
            $user->addBall(40);
        }

        if ($format == EventUser::PLAY_LEAGUE) {
            $summ = $count_tournaments['league'];
            if ($summ == 1) {
                $user->addBall(25);
            } elseif ($summ == 5) {
                $user->addBall(29);
            } elseif ($summ == 20) {
                $user->addBall(33);
            } elseif ($summ == 100) {
                $user->addBall(37);
            }

        } elseif ($format == EventUser::PLAY_CUP ) {
            $summ = $count_tournaments['cup'];
           if ($summ == 1) {
                $user->addBall(26);
            } elseif ($summ == 5) {
                $user->addBall(30);
            } elseif ($summ == 20) {
                $user->addBall(34);
            } elseif ($summ == 100) {
                $user->addBall(38);
            }

        } elseif ($format == EventUser::PLAY_SWISS ){
            $summ = $count_tournaments['swiss'];
            if ($summ == 1) {
                $user->addBall(27);
            } elseif ($summ == 5) {
                $user->addBall(31);
            } elseif ($summ == 20) {
                $user->addBall(35);
            } elseif ($summ == 100) {
                $user->addBall(39);
            }
        }

	}


}