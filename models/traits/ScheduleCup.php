<?php

namespace app\models\traits;

use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

trait ScheduleCup {

    public function addCupSingle($results)
    {
        $array_tur = [1,2,4,8,16,32,64,124,248];
        $array_cub = json_decode($this->cup,true);
        $teams_p = $array_cub['teams'];
        $start_r = count($teams_p);
        $tek_r = count($results);

        $a = $start_r/($tek_r);
        $tur = array_search($a, $array_tur)+1;

        $result_arry = array_fill(0,($tek_r*2),0);
        $ids = [];
        foreach ($teams_p as $teams) {
           $ids = array_merge($ids,ArrayHelper::getColumn($teams, 'id'));
        }
        $count_team = count($ids);
        for ($i=0; $i < $count_team; $i++) { 
            if (in_array($ids[$i], $results)) {
               $b = ceil(($i+1)/$tur);
               $result_arry[$b-1] = 1;
            }
        }

        $result_arry = array_chunk($result_arry, 2);
        if (empty($array_cub['results'])) {
           $array_cub['results'] = [];
        }

        $array_cub['results'][$tur-1] = $result_arry;

        $this->cup = json_encode($array_cub);
        $this->save();
    }

    public function addCupDuble($results)
    {
        $array_cub = json_decode($this->cup,true);
        $teams_p = $array_cub['teams'];
        if(empty($array_cub['results'])) return;
        $results_win = $array_cub['results'][0];
        $last_win = array_pop($results_win);
        if (empty(end($last_win))) {
            $array_id = $this->arryId($array_cub['teams']);
            $result_arry = array_fill(0,count($array_id),0);
            $win_state_id = [];
            $los_state_id = [];
            foreach ($array_id as $key => $value) {
                if(in_array($value, $results)) {
                    $result_arry[$key] = 1;
                    $win_state_id[] = $value;
                } else {
                    $los_state_id[] = $value;
                }
            }
            $result_arry = array_chunk($result_arry, 2);
            $array_cub['results'][0][0] = $result_arry;
            $array_cub['results'][3] = [$win_state_id,$los_state_id];
        }



        
        // echo "<pre>";
        // VarDumper::dump($array_cub['results'][0][0]);
        // echo "</pre>";
        // exit;
        $this->cup=json_encode($array_cub);
        $this->save();

    }

    private function arryId($teams_p)
    {
        $ids = [];
        foreach ($teams_p as $teams) {
            $ids = array_merge($ids,ArrayHelper::getColumn($teams, 'id'));
        }
        return $ids;
    }
}