<?php

namespace app\models\traits;



trait ScheduleLeague {


    public function createLeague()
    {

        $players = $this->getPlayers();
        shuffle($players);
        $c = count($players);
        $ch = $c%2 == 0 ? 1 : 0;
        $c_block = [];
        $players_turs = [];

        if ( $this->format == self::LEAGUE_G ) {
            if (!$ch) {
                return false;
            }
            $group = $c/$this->league_g;
            for ($d=0; $d < $group; $d++) {
                $group_mas = []; 
                for ($dc=0; $dc < $this->league_g; $dc++) { 
                    $group_mas[] = array_pop($players);
                }
                $c_block[] = $group_mas;
            }
            $this->league_table = json_encode($c_block);
            for ($i=0; $i < $group; $i++) { 
                $players_turs = array_merge($players_turs ,$this->generateLeague($c_block[$i],$ch,($i+1)));
            }
        }
        
        if (($this->format == self::LEAGUE_P) || ($this->format == self::LEAGUE)) {
            $players_turs = $this->generateLeague($players,$ch);

            $this->league_table = json_encode($players);
        }   

        if ((\Yii::$app->user->identity->id == $this->user_id)) {
            
            $this->createSchedule($players_turs,2);

            if ( isset($this->league_p) && (($this->format == self::LEAGUE_P) || ($this->format == self::LEAGUE_G))) {
                $cup["teams"] = [];
                $count_p = $this->league_p/2;
                for ($i=0; $i < $count_p; $i++) { 
                    $cup["teams"][] = [['BYE'],['BYE']];
                }
                $cup["results"][] = [];
                $this->cup = json_encode($cup);
            }
            $this->save(false);
        }
    }

    private function generateLeague($players,$ch,$group = null)
    {

            $c = count($players);
            $players_turs = [];
            if (!$ch) {
                array_unshift($players, ['name'=>'bolvan']);
            }
            $a =$c/2;
            $mass_temp = [];
            for ($int=1; $int <= $c; $int++) { 
                $mass_temp[] = $int;
            }
            $b =$c-1;
            
            for ($c=0; $c < $b; $c++) { 
                $turs;
                for ($i=0; $i < $a; $i++) { 
                    $date = new \DateTime($this->start_date);
                    $date->add(new \DateInterval('P'.($c*(int)$this->match_schedule).'D'));
                    $date = $date->format('Y-m-d H:i'); 
                    $turs = [
                        $players[$mass_temp[$i]-1],
                        $players[$mass_temp[$i+$a]-1],
                        'date' => $date,
                        'tur' => $c+1,
                        'group' => $group,
                    ];
                    $players_turs[] = $turs;
                }
               
                $output1 = array_slice($mass_temp, $a);
                $output2 = array_slice($mass_temp, 1,$a-1);
                $output3 = array_merge($output1,$output2);
                array_unshift($output3, $mass_temp[0]);
                $mass_temp = $output3;
            }
            if(!$ch){
                foreach ($players_turs as &$value) {
                   unset($value[0]);
                }
            } 
        return $players_turs;
    }

}