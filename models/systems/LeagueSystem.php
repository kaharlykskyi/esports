<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;

class LeagueSystem extends TournamentSystem
{
	protected function init ()
    {
        $players = $this->players;
        shuffle($players);
        $c = count($players);
        $ch = $c%2 == 0 ? 1 : 0;
        $c_block = [];
        $players_turs = [];

        $players_turs = $this->generateLeague($players,$ch);
        $this->turnir->createSchedule($players_turs,Tournaments::LEAGUE);
        $this->turnir->save(false);
            
    }

    protected function generateLeague($players,$ch,$group = null)
    {
            $c = count($players);
            $players_turs = [];
            if (!$ch) {
                array_unshift($players, ['name'=>'bolvan']);
            }
            $a =$c/2;
            $mass_temp = [];
            for ($int=1; $int <= $c; $int++) { 
                $mass_temp[] = $int;
            }
            $b =$c-1;
            
            for ($c=0; $c < $b; $c++) { 
                $turs;
                for ($i=0; $i < $a; $i++) { 
                    $date = new \DateTime($this->turnir->start_date);
                    $date->add(new \DateInterval('P'.($c*(int)$this->turnir->match_schedule).'D'));
                    $date = $date->format('Y-m-d H:i'); 
                    $turs = [
                        $players[$mass_temp[$i]-1],
                        $players[$mass_temp[$i+$a]-1],
                        'date' => $date,
                        'tur' => $c+1,
                        'group' => $group,
                    ];
                    $players_turs[] = $turs;
                }
               
                $output1 = array_slice($mass_temp, 1,$a-1);
                $output2 = array_slice($mass_temp, $a);
                array_unshift($output1, array_shift($output2));
                $output2[] = array_pop($output1);

                $output3 = array_merge($output1,$output2);
                array_unshift($output3, $mass_temp[0]);
                $mass_temp = $output3;
            } 
            if(!$ch){
                $ci = 0;
                foreach ($players_turs as &$value) {
                    if ($value['tur'] != $ci) {
                        $ci=$value['tur'];
                        unset($value);
                    }
                }
            } 
        return $players_turs;
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