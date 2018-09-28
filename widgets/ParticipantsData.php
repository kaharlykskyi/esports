<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class ParticipantsData extends Widget
{
    public $model;
    public $access;

    public function run()
    {
        return $this->render('participants_data',['model'=>$this->model,
        	'access'=>$this->access,'wget'=>$this
        ]);
    }

    public function getPers($data)
    {
    	if($this->model->game_id = 1){
    		return '<div class="block_card_class" >
    				<img src="/images/game/hearthstone/'.$data.'.png" >
    				<p class="text_card_class" >'.$data.'</p></div>';
    	}

    	if($this->model->game_id = 2){
    		return '<div class="block_pokemon">'.$data.'</div>';
    	}
    }


}