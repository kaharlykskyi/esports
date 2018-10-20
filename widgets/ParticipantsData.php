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
        $dataJson = json_decode($data,true);
        if($this->model->game_id == 1){
            if (!empty($dataJson[1])&&is_array($dataJson[1])) {
                $this->dataHearthstone($dataJson[1]);
            }
        }
        if($this->model->game_id == 2){
            if (!empty($dataJson)&&is_array($dataJson)) {
                $this->dataPokemon($dataJson);
            }
        }
        if($this->model->game_id == 3){
            if (!empty($dataJson)&&is_array($dataJson)) {
                $this->dataWow($dataJson);
            }
        }
    }

    private function dataHearthstone($datas)
    {
        foreach ($datas as $data) {
            echo '<div class="block_card_class" >
                <img src="/images/game/hearthstone/'.$data.'.png" >
                <p class="text_card_class" >'.$data.'</p></div>';
        }
    }

    private function dataPokemon($datas)
    {
        foreach ($datas as $data) {
            if(!empty($data['name']))  {
                echo "<div class='block_pokemon'><img src='/images/game/{$data['icons']['.']}.png' > {$data['name']}</div>";
            } 
        }
    }

    private function dataWow($data)
    {
        echo '<div class="block_card_class wow" >
                <img src="'.$data['thumbnail_url'].'" >
                <p class="text_card_class" >'.$data['name'].'</p></div>';
        
    }
}