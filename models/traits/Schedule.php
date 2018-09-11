<?php

namespace app\models\traits;
//use app\modules\forum\models\ForumTopic as Topic;
use app\models\ScheduleTeams;

trait Schedule {


    public function addSchedule ($league)
    {
        $forum_text = '';
        if ($this->format == self::SINGLE_E) {
            foreach($league as $tur => $tur_game) {
                foreach ($tur_game as $position => $game) {
                    $text = $game[0]->name." vs ".$game[1]->name;
                    $forum_text .= '<p>'.$text.'</p>'; 
                    $this->seveSchedule($game,($tur+1));
                }
            }    
        }

        if (($this->format == self::DUBLE_E)&&(!empty($this->league))) {
            foreach($league as $grup => $shedule) {
                foreach($shedule as $tur => $tur_game) {
                    foreach ($tur_game as $position => $game) {
                        $num_text = (int)((string)($grup+1).(string)($tur+1).(string)($position+1));
                        $text = $game->{0}->name." vs ".$game->{0}->name;
                        $forum_text .= '<p>'.$text.'</p>'; 
                        $this->seveForum($game,$num_text,$text);
                    }
                }    
            }
        }

        if ((($this->format == self::LEAGUE)||($this->format == self::LEAGUE_P))&&(!empty($this->league))) {
                foreach($league as $tur => $tur_game) {
                    foreach ($tur_game as $position => $game) {
                        $num_text = (int)((string)($tur+1).(string)($position+1)); 
                        $text = $game->players1->name." vs ".$game->players2->name;
                        $forum_text .= '<p>'.$text.'</p>'; 
                        $this->seveForum($game,$num_text,$text);
                    }
                }
        }


        if (($this->format == self::LEAGUE_G)&&(!empty($this->league))) {
            foreach($league as $grup => $shedule) {
                foreach($shedule as $tur => $tur_game) {
                    foreach ($tur_game as $position => $game) {
                        $num_text = (int)((string)($grup+1).(string)($tur+1).(string)($position+1));
                        $text = $game->players1->name." vs ".$game->players1->name;
                        $forum_text .= '<p>'.$text.'</p>'; 
                        $this->seveForum($game,$num_text,$text);
                    }
                }    
            }
        }

        $this->forum_text = $forum_text;
        $this->save(false);
    }

    private function seveSchedule($game,$tur,$group = null) 
    {
        $schedule = new ScheduleTeams();
        $schedule->team1 = $game[0]->id;
        $schedule->team2 = $game[1]->id;
        $schedule->date = $game['date'];
        $schedule->group = $group;
        $schedule->tur = $tur;
        $schedule->results1 = $game['results1'];
        $schedule->results2 = $game['results2'];
        $schedule->tournament_id = $this->id;
        $schedule->save(false);
    }


    public function getSchedule()
    {
        //SELECT `schedule_teams`.`id`, t.name as tn ,a.name as an FROM `schedule_teams` INNER JOIN `teams` t ON t.`id` = `schedule_teams`.`team1` INNER JOIN `teams` a ON a.`id` = `schedule_teams`.`team2`
    }

}