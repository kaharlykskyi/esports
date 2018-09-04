<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Bracket extends Widget
{
	private $heightBlock = 195;
	public $teams;
	public $elumination = 1;
	public $turs = [];
	private $couttteam;
	private $position = 0;

	public function run()
    {

    	$this->couttteam = count($this->teams);
    	$couttteampar = $this->couttteam/2;
    	
        echo '<div class="cup-body " style="overflow-x: scroll;" >';
        echo '<div class="jQBracket" >';
        echo '<div class="bracket" style="height: '.($this->heightBlock*$couttteampar).'px;width:'.(310*sqrt($this->couttteam)).'px;">';


        $this->round($this->heightBlock,$couttteampar);
        
        echo '</div>';
        echo '</div>';
       	echo '</div>';
    }

    private function round($hedit,$count)
    {
    	$tur_int = $this->couttteam/($count*2);
    	echo '<div class="round int'.$tur_int.'" ">';
    	$heditConector = $hedit/2;
    		for ($i=0; $i < $count; $i++) { 
    			$this->position++;
		        echo '<div class="match" style="height: '.$hedit.'px;">';
		        echo '<div class="teamContainer" >';
		        echo '<div class="team win"  data-teamid="0">';
		        if (array_key_exists($tur_int,$this->turs)) {
		        	echo '<div class="label" >'.$this->turs[$tur_int][$this->position]['p_name'].'</div>';
		        } else {
		        	echo '<div class="label" >------</div>';
		        }
		        
		        
		        echo '<div class="score"  data-resultid="result-1">3</div>';
		        echo '</div>';
		        echo '<div class="team lose"  data-teamid="1">';

				if (array_key_exists($tur_int,$this->turs)) {
		        	echo '<div class="label" >'.$this->turs[$tur_int][$this->position]['v_name'].'</div>';
		        } else {
		        	echo '<div class="label" >------</div>';
		        }
		        echo '<div class="score"  data-resultid="result-2">2</div>';
		        echo '</div>';
		        if ($count != 1) {
		        	echo '<div class="connector" style="height: '.$heditConector.'px;  ">';
		        	echo '<div class="connector" > </div>';
		        	echo '</div>';
		        }
		        
		        echo '</div>';
		        echo '</div>';
		    }
		echo '</div>';
		if (($count/2) >= 1) {
			$this->round($hedit*2,$count/2);
		}
		
    }
}