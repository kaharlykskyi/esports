<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\Tournaments;
use app\models\ScheduleTeams;


class Schedule extends Widget
{
    public $turnir;

    public function run()
    {

        switch ($this->turnir->format) {
            case Tournaments::SINGLE_E:
                return $this->cup();
                break;
            case Tournaments::DUBLE_E:
               // # code...
                break;
            case Tournaments::LEAGUE:
                return $this->league();
                break;
            case Tournaments::LEAGUE_P:
                return $this->pleague();
                break;
            case Tournaments::LEAGUE_G:
                //# code...
                break;
            case Tournaments::SWISS:
                //# code...
                break;
        }   
    }
    
    public function cup() {
        $cup = $this->turnir->getSchedules(ScheduleTeams::FM_CUP);
        return $this->render('schedule/cup', compact('cup'));
    }

    public function duble_cup() {

    }

    public function league() {
        $league = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        return $this->render('schedule/league', compact('league'));
    }

    public function pleague() {
        $league = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        $cup = $this->turnir->getSchedules(ScheduleTeams::FM_CUP);
        return $this->render('schedule/pleague', compact('league', 'cup'));
    }


    public function group($posit_game)
    {
    	$arra_cub = ['Winners','Losers','Final'];
    	if ($posit_game->format == 2 ) {
    		echo $arra_cub[$posit_game->group-1];
    	} else {
    		echo "GROUP {$posit_game->group}";
    	}
    }
}