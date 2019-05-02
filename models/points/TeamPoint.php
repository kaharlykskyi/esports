<?php 

namespace app\models\points;

use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\UsetTeamTournament;
use app\models\Teams;
use app\models\User;

class TeamPoint {

    public static function createTeam (Teams $team)
    {
        $user = $team->capitans;
        (new EventUser())->create($user->id, EventUser::TEAM, null, EventUser::CREATE_TEAM);
        $cteate_teams = EventUser::find()->where([
            'user_id' => $user->id,
            'type' => EventUser::TEAM,
            'event' => EventUser::CREATE_TEAM
        ])->count();
        if ($cteate_teams == 1) {
            $user->addBall(41);
        }
    }

    public static function invitePlayer (Teams $team)
    {
        $user = $team->capitans;
        (new EventUser())->create($user->id, EventUser::TEAM, null, EventUser::INVINITE_PLAYER);
        $invinite_p = EventUser()->find()->where([
            'user_id' => $user->id,
            'type' => EventUser::TEAM,
            'event' => EventUser::INVINITE_PLAYER
        ])->count();
        if ($invinite_p == 1) {
            $user->addBall(42);
        }
    }

    public static function participeTournament (Tournaments $tournament) 
    {
        if( $tournament->flag == Tournaments::TEAMS ) {
            $uset_team_tournaments = $tournament->getUset_team_tournament()
                ->joinWith(['user'])->all();

            $rank = $tournament->rank();
               
            $sql = "INSERT INTO event_user (user_id,type,type_event,event) VALUES ";
            foreach ($uset_team_tournaments as $key => $uset_team_tournament) {
                $sqlop = !empty($key)?',':' ';
                $sql .= "{$sqlop}({$uset_team_tournament->user->id},
                ".EventUser::TEAM.",
                ".EventUser::PARTICIPE.",
                {$rank})";
            }
            $sql .= ';';
            $connection = \Yii::$app->db->createCommand($sql)->execute();

            foreach ($uset_team_tournaments as $uset_team_tournament) {
                $user = $uset_team_tournament->user;
                $sql = "select count(id) from event_user where  user_id = {$user->id}
                and type = ".EventUser::TEAM." and type_event = ".EventUser::PARTICIPE;
                $count_tournaments = (new \yii\db\Query())->select([
                    "({$sql} and event = ".User::NORMAL.") as normal,
                     ({$sql} and event = ".User::GOOD.") as good,
                     ({$sql} and event = ".User::GREAT.") as great,
                     ({$sql} and event = ".User::EPIC.") as epic,
                     ({$sql} and event = ".User::LEGENDARY.") as legendary
                    "
                ])->from('event_user')->one();

                $summ = array_sum($count_tournaments);

                if ($summ == 1) {
                    $user->addBall(43);
                } elseif ($summ == 10) {
                    $user->addBall(45);
                } elseif ($summ == 50) {
                    $user->addBall(47);
                } elseif ($summ == 100) {
                    $user->addBall(51);
                }

                if ($count_tournaments['great'] == 10) {
                    $user->addBall(49);
                } elseif ($count_tournaments['epic'] == 1) {
                    $user->addBall(48);
                } elseif ($count_tournaments['legendary'] == 1) {
                    $user->addBall(52);
                } elseif ($count_tournaments['epic'] == 20) {
                    $user->addBall(53);
                }
            }
        }    
    }

    public static function winTournament(Tournaments $tournament) 
    {
        if( $tournament->flag == Tournaments::TEAMS ) {
            $uset_team_tournaments = $tournament->getUset_team_tournament()
                ->joinWith(['user'])
                ->where(['team_id' => $tournament->winner])
                ->all();
            $rank = $tournament->rank();    
            $sql = "INSERT INTO event_user (user_id,type,type_event,event) VALUES ";
            foreach ($uset_team_tournaments as $key => $uset_team_tournament) {
                $sqlop = !empty($key)?',':' ';
                $sql .= "{$sqlop}({$uset_team_tournament->user->id},
                ".EventUser::TEAM.",
                ".EventUser::WIN.",
                {$rank})";
            }
            $sql .= ';';
            $connection = \Yii::$app->db->createCommand($sql)->execute();

            foreach ($uset_team_tournaments as $uset_team_tournament) {
                $user = $uset_team_tournament->user;
                $count_tournaments = (new \yii\db\Query())->select(["*"])
                    ->where([
                        'type'=> EventUser::TEAM,
                        'type_event' => EventUser::WIN,
                    ])->from('event_user')->count();
                if ($count_tournaments == 1) {
                    $user->addBall(44);
                } elseif ($count_tournaments == 10) {
                    $user->addBall(46);
                } elseif ($count_tournaments == 50) {
                    $user->addBall(50);
                }
            }

        }
    }


}