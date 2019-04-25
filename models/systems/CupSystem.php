<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;
use yii\db\Expression;

class CupSystem extends TournamentSystem
{
    protected function init ()
    {
        $this->createBracket();
    }

    public function createBracket ($format = ScheduleTeams::FM_CUP)
    {
        $a = count($this->players)/2;
        $cup["teams"] = [];
        for ($i=0; $i < $a; $i++) { 
            $p_mod1 = array_pop($this->players);
            $p_mod2 = array_pop($this->players);
            $player_1 = ['id'=>$p_mod1->id,'name'=>$p_mod1->name,'logo'=>$p_mod1->logo()];
            $player_2 = ['id'=>$p_mod2->id,'name'=>$p_mod2->name,'logo'=>$p_mod2->logo()];
            $cup["teams"][] = [$player_1,$player_2];
        }

        if($format == ScheduleTeams::FM_DCUP) {
            $cup["results"] = [[[[]]], [], []];
        }

        $this->turnir->createSchedule($cup["teams"], $format, $this->turnir->start_date);
        $this->turnir = json_encode($cup);
    }

    public function addMatch (ScheduleTeams $model) 
    {
        $this->summBal($model);

        $matches = self::find()->where([
            'tournament_id'=>$this->tournament_id,
            'tur'=>$this->tur,
        ])->all();
        $result = $this->winAndLoss($matches);
        if (!$result) {
            return false;
        }
        $this->writeStringTable($result[0],1,($this->tur + 1));
        if (!empty($result[0])) {
            $this->turnir->addCupSingle($result[0]);
        }
    }

    public function writeStringTable($players,$format,$tur,$group=null)
    {
        $winner = $players;
        $count = count($winner);
        if ($count%2==0&&$count>0) {
            $count = $count/2;
            for ($i=0; $i < $count; $i++) { 
                $new_mathc = new self();
                $winer1 = array_pop($winner);
                $winer2 = array_pop($winner);
                $new_mathc->team1 = $winer1;
                $new_mathc->team2 = $winer2;
                $new_mathc->tur = $tur;
                $new_mathc->tournament_id = $this->tournament_id;
                $new_mathc->format = $format;
                $new_mathc->group = $group;
                $time_pluss = 2;
                if ($group==2) {
                    $time_pluss = 1;
                }
                $time_pluss_string = "+".$time_pluss." day";
                $newdata = strtotime($time_pluss_string,strtotime ($this->date));
                $new_mathc->date = date('Y-m-d H:m:i', $newdata);
                $new_mathc->save();
            }
        }
    }


}