<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;
use yii\db\Expression;

abstract class TournamentSystem
{
	public $turnir;
	public $players = [];

	public function __construct (Tournaments $object)
    {
        $this->turnir = $object;
    }

    public function start ()
    {

    	$this->turnir->state = 1;
        if(strtotime($this->turnir->start_date) < strtotime('+30 minute',time())) {
            $this->turnir->start_date = date("Y-m-d H:i",strtotime('+50 minute',time()));
        }
    	$this->players = $this->turnir->getPlayers();
    
        foreach ($this->players as $player) {
            $ballmch = new BallMatch();
            $ballmch->tournament_id = $this->turnir->id;
            $ballmch->team_id = $player->id;
            $ballmch->save();
        }

        $this->init();
        $this->turnir->save(false);
    }

    protected function winAndLoss (array $matches)
    {
        $winner = [];
        $loser = [];
        foreach ($matches as $match) {
            if(!is_numeric($match->results1)
                || !is_numeric($match->results2)
                || ($match->results2 == $match->results1))
            {
                return false;
            }
            if ($match->results1 > $match->results2) {
                $winner[] = $match->team1;
                $loser[] = $match->team2;
            } elseif ($match->results1 < $match->results2) {
                $winner[] = $match->team2;
                $loser[] = $match->team1;
            }
        }
        return [array_reverse($winner),array_reverse($loser)];
    }

    public function summBal(ScheduleTeams $model)
    {
        if ($model->results1 > $model->results2) {
            BallMatch::updateAll(
                [
                    '`played`' => new Expression("`played` + 1"), 
                    '`won`' => new Expression("`won` + 1"),
                    '`summ_ball`' => new Expression("`summ_ball` + 1")
                ],
                [ 'tournament_id' => $model->tournament_id, 'team_id' => $model->team1]
            );
            BallMatch::updateAll(
                [
                    '`played`' => new Expression("`played` + 1"), 
                    '`lost`' => new Expression("`lost` + 1"),
                ],
                [ 'tournament_id' => $model->tournament_id, 'team_id' => $model->team2]
            );

        } elseif ($model->results1 < $model->results2) {
           BallMatch::updateAll(
                [
                    '`played`' => new Expression("`played` + 1"), 
                    '`won`' => new Expression("`won` + 1"),
                    '`summ_ball`' => new Expression("`summ_ball` + 1")
                ],
                [ 'tournament_id' => $model->tournament_id, 'team_id' => $model->team2]
            );
            BallMatch::updateAll(
                [
                    '`played`' => new Expression("`played` + 1"), 
                    '`lost`' => new Expression("`lost` + 1"),
                ],
                [ 'tournament_id' => $model->tournament_id, 'team_id' => $model->team1]
            );
        }
    }

    abstract protected function init();
}