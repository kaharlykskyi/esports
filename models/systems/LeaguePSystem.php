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

        $cup_system = new CupSystem($this->turnir);
        $cup_system->players = $this->players;
        $cup_system->createBracket();





        // $this->turnir->winner = $membersi[0]->team_id;
        // $this->turnir->state = 2;
        // $this->turnir->save();
    }

}