<?php 

namespace app\models\points;

use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\UsetTeamTournament;

class  PlayPoint {

    public static function checkTournament (Tournaments $tournament) {

        $uset_team_tournaments = $tournament->getUset_team_tournament()
            ->joinWith(['user'])
            ->all();
        $format = null;
        if ( $tournament->format < 3) {
            $format = EventUser::PLAY_CUP;
        } elseif ( $tournament->format > 2 && $tournament->format < 6) {
            $format = EventUser::PLAY_LEAGUE;
        } elseif ( $tournament->format == 6) {
            $format = EventUser::PLAY_SWISS;
        }

        $sql = "INSERT INTO event_user (user_id,type,type_event,event) VALUES ";
        foreach ($uset_team_tournaments as $key => $uset_team_tournament) {
            $sqlop = !empty($key)?',':' ';
            $sql .= "{$sqlop}({$uset_team_tournament->user->id},
            ".EventUser::PLAY.",
            ".EventUser::PLAY_TOURNAMENT.",
            {$format})";
        }
        $sql .= ';';
        $connection = \Yii::$app->db->createCommand($sql)->execute();

        foreach ($uset_team_tournaments as $key => $uset_team_tournament) {

            $sql = "select count(id) from event_user where  user_id = {$uset_team_tournament->user->id}
                and type = ".EventUser::PLAY." and type_event ".EventUser::PLAY_TOURNAMENT;
            $count_tournaments= (new \yii\db\Query())->select([
                "({$sql} and event ".EventUser::PLAY_LEAGUE.") as league,
                 ({$sql} and event ".EventUser::PLAY_CUP.") as cup,
                 ({$sql} and event ".EventUser::PLAY_SWISS.") as swiss
                "
            ])->from('event_user')->one();

            $summ = array_sum($count_tournaments);
            if ($summ == 5) {
                $uset_team_tournament->user->addBall(5);
            }

            if ($format == EventUser::PLAY_CUP) {
                $summ = $count_tournaments['cup'];

                if ($summ == 5) {
                    $uset_team_tournament->user->addBall(10);
                } elseif ($summ == 20) {
                    $uset_team_tournament->user->addBall(16);
                } elseif ($summ == 100) {
                    $uset_team_tournament->user->addBall(22);
                }

            } elseif ($format == EventUser::PLAY_LEAGUE ) {
                $summ = $count_tournaments['league'];
               if ($summ == 5) {
                    $uset_team_tournament->user->addBall(9);
                } elseif ($summ == 20) {
                    $uset_team_tournament->user->addBall(15);
                } elseif ($summ == 100) {
                    $uset_team_tournament->user->addBall(21);
                }

            } elseif ($format == EventUser::PLAY_SWISS ){
                $summ = $count_tournaments['swiss'];
                if ($summ == 5) {
                    $uset_team_tournament->user->addBall(11);
                } elseif ($summ == 20) {
                    $uset_team_tournament->user->addBall(17);
                } elseif ($summ == 100) {
                    $uset_team_tournament->user->addBall(23);
                }
            }
        }

    }

    public static function checkMatch (ScheduleTeams $match) {
        
        $user_teams = UsetTeamTournament::find()->joinWith('user')->where([
            'and',
            ['in', 'team_id', [$match->team1,$match->team2]],
            ['tournament_id' => $match->tournament_id]
        ])->all();

        $format = null;
        if ( $match->tournament->format < 3) {
            $format = EventUser::PLAY_CUP;
        } elseif ( $match->tournament->format > 2 && $match->tournament->format < 6) {
            $format = EventUser::PLAY_LEAGUE;
        } elseif ( $match->tournament->format == 6) {
            $format = EventUser::PLAY_SWISS;
        }

        $sql = "INSERT INTO event_user (user_id,type,type_event,event) VALUES ";
        foreach ($user_teams as $key => $user_team) {
            $sqlop = !empty($key)?',':' ';
            $sql .= "{$sqlop}({$user_team->user->id},
            ".EventUser::PLAY.",
            ".EventUser::PLAY_MATCH.",
            {$format})";
        }
        $sql .= ';';
        $connection = \Yii::$app->db->createCommand($sql)->execute();

        foreach ($user_teams as $key => $user_team) {

            $sql = "select count(id) from event_user where  user_id = {$user_team->user->id}
                and type = ".EventUser::PLAY." and type_event ".EventUser::PLAY_MATCH;
            $count_matches = (new \yii\db\Query())->select([
                "({$sql} and event ".EventUser::PLAY_LEAGUE.") as league,
                 ({$sql} and event ".EventUser::PLAY_CUP.") as cup,
                 ({$sql} and event ".EventUser::PLAY_SWISS.") as swiss
                "
            ])->from('event_user')->one();
            $summ = array_sum($count_matches);

            if ($summ == 1) {
                $user_team->user->addBall(1);
            }

            if ($format == EventUser::PLAY_LEAGUE) {
                $summ = $count_matches['league'];
                if ($summ == 1) {
                    $user_team->user->addBall(2);
                } elseif ($summ == 5) {
                    $user_team->user->addBall(6);
                } elseif ($summ == 50) {
                    $user_team->user->addBall(12);
                } elseif ($summ == 200) {
                    $user_team->user->addBall(18);
                }

            } elseif ($format == EventUser::PLAY_CUP ) {
                $summ = $count_matches['cup'];
               if ($summ == 1) {
                    $user_team->user->addBall(3);
                } elseif ($summ == 5) {
                    $user_team->user->addBall(7);
                } elseif ($summ == 50) {
                    $user_team->user->addBall(13);
                } elseif ($summ == 200) {
                    $user_team->user->addBall(19);
                }

            } elseif ($format == EventUser::PLAY_SWISS ){
                $summ = $count_matches['swiss'];
                if ($summ == 1) {
                    $user_team->user->addBall(4);
                } elseif ($summ == 5) {
                    $user_team->user->addBall(8);
                } elseif ($summ == 50) {
                    $user_team->user->addBall(14);
                } elseif ($summ == 200) {
                    $user_team->user->addBall(20);
                }
            }
        }
    
    }
}