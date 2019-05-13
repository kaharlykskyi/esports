<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;

class SwissSystem extends TournamentSystem
{

    protected function init ()
    {
        $players = $this->players;
        shuffle($players);

        $count_member = count($players);
        if (($count_member % 2 ) != 0) {
            return false;
        }

        $players = array_chunk($players, 2);
        $teams = [];
        foreach ( $players as $player ) {
            $teams[] = [
                $player[0],
                $player[1],
                'date' => $this->turnir->start_date,
                'tur' => 1,
            ];
        }
        $this->turnir->createSchedule($teams, Tournaments::SWISS);
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
        $count_members = count($membersi);
        $turow = (int)round(log($count_members,2));

        $members = array_merge($result[0], $result[1]);
        $count = count($members);
        $time_pluss_string = "+".($model->tur*1)." day";
        $newdata = strtotime($time_pluss_string, strtotime ($this->turnir->start_date));
        $newdata =  date('Y-m-d H:m:i', $newdata);

        if ($turow > $model->tur) {
            $i=0; 
            while ( $i < $count ) { 
                $new_match = new ScheduleTeams();
                $new_match->team1 = $members[$i];
                $new_match->team2 = $members[$i+1];
                $new_match->tournament_id = $this->turnir->id;
                $new_match->tur = $model->tur + 1;
                $new_match->date = $newdata;
                $new_match->format = Tournaments::SWISS;
                $new_match->save(false); 
                $i = $i+2;
            }   
        } else {
            if ($membersi[0]->summ_ball == $membersi[1]->summ_ball) {
                $new_match = new ScheduleTeams();
                $new_match->team1 = $membersi[0]->team_id;
                $new_match->team2 = $membersi[1]->team_id;
                $new_match->tournament_id = $this->turnir->id;
                $new_match->tur = $model->tur + 1;
                $new_match->date = $newdata; 
                $new_match->format = Tournaments::SWISS;
                $new_match->save(false);
            } else {
                $this->turnir->winner = $membersi[0]->team_id;
                $this->turnir->state = 2;
                $this->turnir->save(false);
            }
        }
    }

}