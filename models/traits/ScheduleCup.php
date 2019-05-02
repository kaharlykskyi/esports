<?php

namespace app\models\traits;

use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

trait ScheduleCup {

    public function addCupSingle($results)
    {
        $array_tur = [1,2,4,8,16,32,64,124,248,496];
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
        $this->save(false);
    }

    public function addCupDuble($results)
    {
        $array_cub = json_decode($this->cup,true);
        $teams_p = $array_cub['teams'];

        if (!empty($array_cub['results'][3][2])&&(count($array_cub['results'][3][2])==2)) {
            $result_arry = array_fill(0,2,0);
            foreach ($array_cub['results'][3][2] as $key => $value) {
                if (in_array($value, $results)) {
                    $result_arry[$key] = 1;
                }
            }
            $array_cub['results'][2] = [[$result_arry]];

        } elseif (!empty($array_cub['results'][3])) {
            $win_id = end($array_cub['results'][3][0]);
            reset($array_cub['results'][3][0]);
            $los_id = end($array_cub['results'][3][1]);
            reset($array_cub['results'][3][1]);
           
            if(!empty(array_uintersect($win_id, $results, "strcasecmp"))) {
                $result_arry_win = array_fill(0,count($win_id),0);
                $new_win_id = [];
                $new_los_id = [];
                foreach ($win_id as $key => $win) {
                    if(in_array($win, $results)) {
                        $result_arry_win[$key] = 1;
                        $new_win_id[] = $win;
                    } else {
                        $new_los_id[] = $win;
                    }          
                }

                $result_arry = array_chunk($result_arry_win, 2);
                $array_cub['results'][0][] = $result_arry;
                if (count($new_win_id) == 1) {
                    $array_cub['results'][3][2] = $new_win_id;
                    $array_cub['results'][3][0][] = [null];
                } else {
                    $array_cub['results'][3][0][] = $new_win_id;
                }   
            }

            if (!empty($new_los_id)) {
                if (count($array_cub['results'][3][1])%4 == 0) {
                    $metka = 1;
                } else {
                    $metka = 2;
                }
            }

            $new_los_old_id = [];
            foreach ($los_id as $keys => $los) {
                if(in_array($los, $results)) {
                    $new_los_old_id[] = $los;
                    if (!empty($metka)) {
                        if ($metka == 1) {
                            $new_los_old_id[] = array_shift($new_los_id);
                        } else {
                            $new_los_old_id[] = array_pop($new_los_id);
                        }
                    }
                }        
            }
            if (count($new_los_old_id) == 1) {
                $array_cub['results'][3][2][] = end($new_los_old_id);
                $array_cub['results'][3][1][] = [null];
            } else {
                $array_cub['results'][3][1][] = $new_los_old_id;
            }

            if (isset($metka)) {
                $count = count($new_los_old_id);
            } else {
                $count = count($new_los_old_id)*2;
            }
            $result_arry_los = array_fill(0,$count,0);
            foreach ($los_id as $key => $loss) {
                if(in_array($loss, $results)) {
                    $result_arry_los[$key] = 1;
                }           
            }
            $result_arry = array_chunk($result_arry_los, 2);
            $array_cub['results'][1][] = $result_arry;
        } else {
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
                $array_cub['results'][3][0][] = $win_state_id;
                $array_cub['results'][3][1][] = $los_state_id;
            }

        }

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