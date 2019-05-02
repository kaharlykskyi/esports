<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Schedule extends Widget
{
    public $turs;

    public function run()
    {













        
        return $this->render('schedule',['turs'=>$this->turs,'wiget'=>$this]);
        
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