<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;

class LeaguePSystem extends LeagueSystem
{
	protected function init ()
    {
        parent::init();

        $cup["teams"] = [];
        $count_p = $this->turnir->league_p/2;
        for ($i=0; $i < $count_p; $i++) { 
            $cup["teams"][] = [['BYE'],['BYE']];
        }
        $cup["results"][] = [];
        $this->turnir->cup = json_encode($cup);
        $this->turnir->save(false);
            
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

}