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
                return $this->duble_cup();
                break;
            case Tournaments::LEAGUE:
                return $this->league();
                break;
            case Tournaments::LEAGUE_P:
                return $this->pleague();
                break;
            case Tournaments::LEAGUE_G:
                return $this->gleague();
                break;
            case Tournaments::SWISS:
                return $this->swiss();
                break;
        }   
    }
    
    private function cup() {
        $cup = $this->turnir->getSchedules(ScheduleTeams::FM_CUP);
        return $this->render('schedule/cup', compact('cup'));
    }

    private function duble_cup() {
        $dcup = $this->turnir->getSchedules(ScheduleTeams::FM_DCUP);
        return $this->render('schedule/duble_cup', ['dcup' => $dcup, 'wiget' => $this ]);
    }

    private function league() {
        $league = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        return $this->render('schedule/league', compact('league'));
    }

    private function pleague() {
        $league = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        $cup = $this->turnir->getSchedules(ScheduleTeams::FM_CUP);
        return $this->render('schedule/pleague', compact('league', 'cup'));
    }

    private function gleague() {
        $gleague = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        $cup = $this->turnir->getSchedules(ScheduleTeams::FM_CUP);
        return $this->render('schedule/gleague', [
            'cup' => $cup,
            'gleague' => $gleague, 
            'wiget' => $this
        ]);
    }

    private function swiss() {
        $swiss = $this->turnir->getSchedules(ScheduleTeams::FM_LEAGUE);
        return $this->render('schedule/swiss', compact('swiss'));
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