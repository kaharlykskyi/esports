<?php 

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use yii\helpers\ArrayHelper;
use Yii;

class LeagueGSystem extends LeagueSystem
{
    protected function init ()
    {
        $players = $this->players;
        shuffle($players);
        $c = count($players);
        $ch = $c%2 == 0 ? 1 : 0;
        $players_turs = [];
        $c_block = [];
        $group = $c/$this->turnir->league_g;
        if (!$ch || $group < 2) {
            return false;
        }

        for ($d=0; $d < $group; $d++) {
            $group_mas = []; 
            for ($dc=0; $dc < $this->turnir->league_g; $dc++) { 
                $group_mas[] = array_pop($players);
            }
            $c_block[] = $group_mas;
        }
        for ($i=0; $i < $group; $i++) { 
            $players_turs = array_merge(
                $players_turs,
                $this->generateLeague($c_block[$i],$ch,($i+1))
            );
        }
        $this->turnir->createSchedule($players_turs,ScheduleTeams::FM_LEAGUE);

        $cup["teams"] = [];
        $count_p = $this->turnir->league_p/2;
        for ($i=0; $i < $count_p; $i++) { 
            $cup["teams"][] = [['BYE'],['BYE']];
        }
        $cup["results"][] = [];
        $this->turnir->cup = json_encode($cup);        
    }

    public function addMatch (ScheduleTeams $model) 
    {
        $cup_system = new CupSystem($this->turnir);
        if ($model->format == ScheduleTeams::FM_LEAGUE) {
            $this->summBal($model);
            $matches = ScheduleTeams::find()->where([
                'tournament_id' => $model->tournament_id,
                'tur' => $model->tur,
            ])->all();
            $result = $this->winAndLoss($matches);
            if ($result === false || empty($result)) {
                return false;
            }

            $membersi = $this->turnir->summBal;
            $count_team = count($membersi);
            $league_p = $this->turnir->league_p;
            if ($this->turnir->league_p < $count_team) {
                $league_p = $count_team;
            }
            $team_play_off = array_slice($membersi, 0, $league_p);
            $team_play_off_array = [];
            foreach ($team_play_off as $value) {
                $team_play_off_array[] = $value->team;
            }
            $cup_system->players = $team_play_off_array;
            $date = $this->turnir->start_date;
            $this->turnir->start_date = date('Y-m-d', strtotime($model->date. ' + 1 days'));
            $cup_system->createBracket();
            $this->turnir->start_date = $date;
            $this->turnir->save(false);

        } elseif ($model->format == ScheduleTeams::FM_CUP) {
            $cup_system->addMatch($model);
        }
    }

    public function getTeamsInGroup ()
    {
        $matches = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        $summBals = $this->turnir->summBal;
        $group = [];
        foreach ($summBals as $summBal) {
            foreach ($matches as $match) {
                if ($summBal->team_id == $match->team1) {
                    $group[$match->group][] = $summBal;
                    break ;
                } elseif ($summBal->team_id == $match->team2) {
                    $group[$match->group][] = $summBal;
                    break ;
                }
            } 
        }
        ksort($group);
        return $group;
    }
}