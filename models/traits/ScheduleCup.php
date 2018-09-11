<?php

namespace app\models\traits;



trait ScheduleCup {

    private $lusers = [];

    public function getScheduleCupSingle () 
    {
        $raspisanie = [];
        $json = json_decode($this->cup);
        $teams = $json->teams;
        $results = $json->results[0];
        if (empty($json->results[0])) {
            $results = [[null]];
        }
        foreach ($results as $tur => $znachenie) {

            $raspisanie[] = $this->kley($teams,$znachenie,$tur);
            if(!$this->is_result_null($znachenie)){
                break;
            }
            $teams = $this->delete_luser($teams,$znachenie);
          
        }
        if ($this->format == self::DUBLE_E) {
            return $raspisanie;
        }
        $this->addSchedule($raspisanie);
        //$this->league = json_encode($raspisanie);
       
    }
           
    public function getScheduleCupDuble () 
    {
        $raspisanie = $this->getScheduleCupSingle();
        
        $json = json_decode($this->cup);
        $lusers = $this->lusers;
        $raspisanie_duble = [];
        $teams = [];
        if (!empty($this->lusers)) {
            foreach ($json->results[1] as $tur => $znachenie) {
                $count_team = count($znachenie)*2;

                $teams = $this->dubleTeamsTur($count_team,$lusers,$teams,$tur);
                $raspisanie_duble[] = $this->kley($teams,$znachenie,$tur,true);
                if(!$this->is_result_null($znachenie)){
                    break;
                }
                $teams = $this->delete_luser($teams,$znachenie);
            }
        }
        $this->league = json_encode([$raspisanie,$raspisanie_duble]);
    }

    private function dubleTeamsTur($count_team,&$lusers,$teams,$tur) {
        $tur_teams = [];
        if (empty($teams)) {
            for ($i=0; $i < $count_team ; $i++) { 
                $tur_teams[] = array_shift($lusers);
            }
        } elseif ($tur%2 == 0) {
            $tur_teams = [];
            foreach ($teams as $team) {
                foreach ($team as $teama) {
                    $tur_teams[] = $teama;
                }
            }
        } else {   
            $tur_teams = [];
            $tur_lusers = [];
            foreach ($teams as $team) {
                foreach ($team as $teama) {
                    if (!empty($teama)) {
                       $tur_teams[] = $teama;
                    }
                    if (!empty($lusers)) {
                        $tur_lusers[] = array_shift($lusers);
                    }
                }
            }
            $tur_lusers = array_reverse($tur_lusers);
            $temp = [];
            foreach ($tur_teams as $tur_team) {
                $temp[] = $tur_team;
                $temp[] = array_shift($tur_lusers);
            }
           $tur_teams = $temp;
        }
        return array_chunk($tur_teams,2);
    }

    private function delete_luser($teams,$znachenie) {
       $teams_spis = [];
        foreach ($teams as $key => $team) {
            if ( $znachenie[$key][0] > $znachenie[$key][1] ) {
                $teams_spis[] = $team[0];
                $this->lusers[] = $team[1];
            } elseif ( $znachenie[$key][1] > $znachenie[$key][0] ) {
                $teams_spis[] = $team[1];
                $this->lusers[] = $team[0];
            }
        }
        return array_chunk($teams_spis,2);
    }

    private function kley($teams,$znachenie,$turs,$duble = false) {
        $tur = [];
        foreach ($teams as $key => $team) {
            if ($duble) {
                $time = $turs+1;
            } else {
                $time = $turs*2;
            }
            $date = new \DateTime($this->start_date);
            $date->add(new \DateInterval('P'.$time.'D'));
            $date = $date->format('Y-m-d H:i');
            $team['results1'] = $znachenie[$key][0]??null;
            $team['results2'] = $znachenie[$key][1]??null;
            $team['date'] = $date;
            $tur[] = $team;
        }
        return $tur;
    }

    private function is_result_null($result) {

        if(is_null($result)){
            return false;
        }
        foreach ($result as $match) {
            if (empty($match)) {
                return false;
            }
            if(($match[0] === null)||($match[1] === null)){ 
                return false;
            }
            if ($match[0] == $match[1]) {
                return false;
            }
        }
        return true;
    }

}