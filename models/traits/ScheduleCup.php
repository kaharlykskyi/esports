<?php

namespace app\models\traits;

use yii\helpers\ArrayHelper;

trait ScheduleCup {

    public function addCupSingle($results)
    {
        $array_tur = [1,2,4,8,16,32,64,124,248];
        $array_cub = json_decode($this->cup,true);
        $teams_p = $array_cub['teams'];
        $start_r = count($teams_p);
        $tek_r = count($results);
        $a = $start_r/($tek_r*2);
        $tur = array_search($a, $array_tur)+1;
        $result_arry = array_fill(0,($tek_r*2),0);
        $ids = [];
        foreach ($teams_p as $teams) {
           $ids = array_merge($ids,ArrayHelper::getColumn($teams, 'id'));
        }
        $count_team = count($ids);
        for ($i=0; $i < $count_team; $i++) { 
            if (in_array($ids[$i],$results)) {
               $b = ceil(($i+1)/$tur);
               $result_arry[$b-1] = 1;
            }
        }
       // print_r($result_arry);exit;
        $result_arry = array_chunk($result_arry, 2);
        if (empty($array_cub['results'])) {
           $array_cub['results'] = [];
        }
        $array_cub['results'][] = $result_arry;

        $this->cup = json_encode($array_cub);
        $this->save();
    }


   //  private $lusers = [];

   //  public function ScheduleCupTur($tur)
   //  {
   //      $raspisanie = $this->getScheduleCupSingle();
   //      if(!empty($raspisanie[$tur])) {

   //      }
   //  }

   //  public function getScheduleCupSingle () 
   //  {
   //      $raspisanie = [];
   //      $json = json_decode($this->cup);
   //      $teams = $json->teams;
   //      $results = $json->results[0];
   //      if (empty($json->results[0])) {
   //          $results = [[null]];
   //      }
   //      foreach ($results as $tur => $znachenie) {
   //          $raspisanie[] = $this->kley($teams,$znachenie,$tur);
   //          if(!$this->is_result_null($znachenie)){
   //              break;
   //          }
   //          $teams = $this->delete_luser($teams,$znachenie);
   //      }
        
   //      return $raspisanie;
        
   //  }
           
   //  public function getScheduleCupDuble () 
   //  {
   //      $raspisanie = $this->getScheduleCupSingle();
        
   //      $json = json_decode($this->cup);
   //      $lusers = $this->lusers;
   //      $raspisanie_duble = [];
   //      $teams = [];
   //      if (!empty($this->lusers)) {
   //          foreach ($json->results[1] as $tur => $znachenie) {
   //              $count_team = count($znachenie)*2;

   //              $teams = $this->dubleTeamsTur($count_team,$lusers,$teams,$tur);
   //              $raspisanie_duble[] = $this->kley($teams,$znachenie,$tur,true);
   //              if(!$this->is_result_null($znachenie)){
   //                  break;
   //              }
   //              $teams = $this->delete_luser($teams,$znachenie);
   //          }
   //      }
   //      $this->league = json_encode([$raspisanie,$raspisanie_duble]);
   //  }

   //  private function dubleTeamsTur($count_team,&$lusers,$teams,$tur) {
   //      $tur_teams = [];
   //      if (empty($teams)) {
   //          for ($i=0; $i < $count_team ; $i++) { 
   //              $tur_teams[] = array_shift($lusers);
   //          }
   //      } elseif ($tur%2 == 0) {
   //          $tur_teams = [];
   //          foreach ($teams as $team) {
   //              foreach ($team as $teama) {
   //                  $tur_teams[] = $teama;
   //              }
   //          }
   //      } else {   
   //          $tur_teams = [];
   //          $tur_lusers = [];
   //          foreach ($teams as $team) {
   //              foreach ($team as $teama) {
   //                  if (!empty($teama)) {
   //                     $tur_teams[] = $teama;
   //                  }
   //                  if (!empty($lusers)) {
   //                      $tur_lusers[] = array_shift($lusers);
   //                  }
   //              }
   //          }
   //          $tur_lusers = array_reverse($tur_lusers);
   //          $temp = [];
   //          foreach ($tur_teams as $tur_team) {
   //              $temp[] = $tur_team;
   //              $temp[] = array_shift($tur_lusers);
   //          }
   //         $tur_teams = $temp;
   //      }
   //      return array_chunk($tur_teams,2);
   //  }

   //  private function delete_luser($teams,$znachenie) {
   //     $teams_spis = [];
   //      foreach ($teams as $key => $team) {
   //          if ( $znachenie[$key][0] > $znachenie[$key][1] ) {
   //              $teams_spis[] = $team[0];
   //              $this->lusers[] = $team[1];
   //          } elseif ( $znachenie[$key][1] > $znachenie[$key][0] ) {
   //              $teams_spis[] = $team[1];
   //              $this->lusers[] = $team[0];
   //          }
   //      }
   //      return array_chunk($teams_spis,2);
   //  }

   //  private function kley($teams,$znachenie,$turs,$duble = false) {
   //      $tur = [];
   //      foreach ($teams as $key => $team) {
   //          if ($duble) {
   //              $time = $turs+1;
   //          } else {
   //              $time = $turs*2;
   //          }
   //          $date = new \DateTime($this->start_date);
   //          $date->add(new \DateInterval('P'.$time.'D'));
   //          $date = $date->format('Y-m-d H:i');
   //          $team['results1'] = $znachenie[$key][0]??null;
   //          $team['results2'] = $znachenie[$key][1]??null;
   //          $team['date'] = $date;
   //          $tur[] = $team;
   //      }
   //      return $tur;
   //  }

   //  private function is_result_null($result) {

   //      if(is_null($result)){
   //          return false;
   //      }
   //      foreach ($result as $match) {
   //          if (empty($match)) {
   //              return false;
   //          }
   //          if(($match[0] === null)||($match[1] === null)){ 
   //              return false;
   //          }
   //          if ($match[0] == $match[1]) {
   //              return false;
   //          }
   //      }
   //      return true;
   //  }

   //  public function writeResult($result,$max) {
   //     if ( $this->is_result_null($result)) {
   //          return true;
   //     }
   // }

}