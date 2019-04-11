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
        $this->turnir->winner = $membersi[0]->team_id;
        $this->turnir->state = 2;
        $this->turnir->save();
    }

}