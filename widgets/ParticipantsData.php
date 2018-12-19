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
                $this->dataHearthstone($dataJson);
            }
        }
        if($this->model->game_id == 2){
            if (!empty($dataJson)&&is_array($dataJson)) {
                $this->dataPokemon($dataJson[1]);
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
        $datal = $datas[1];
        foreach ($datal as $data) {
            echo '<div class="block_card_class" >
                <img src="/images/game/hearthstone/'.$data.'.png" >
                <p class="text_card_class" >'.$data.'</p></div>';
        }
        if(!empty($datas[0])){
            $datast = $datas[0];
            echo "<div class ='row resurses-user-container' > <div class='resurses-user-game col-sm-offset-2 col-sm-8 ' >";
            foreach ($datast as $key => $data) {
                $count = $key+1;
                echo "<p><b>{$count}: </b>{$data}</p>";
            }
            echo "</div>";
            echo "<a href='#' class='resurses-btn-show'><span class='glyphicon glyphicon-chevron-up glyphicon-chevron-down'></span> Deckstrings</a>";
            echo "</div>";
        }
    }

    private function dataPokemon($datas)
    {
        foreach ($datas as $data) {
            if(!empty($data['name']))  {
                echo "<div class='block_pokemon'>
                    <img src='/images/game/{$data['icons']['.']}.png' > 
                    {$data['name']}</div>";

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