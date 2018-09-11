<?php

namespace app\models\traits;
use app\modules\forum\models\ForumTopic as Topic;

trait ForumTopic {


    public function addForumTopic ()
    {
        $forum_text = '';

        $league = json_decode($this->league);
        if (($this->format == self::SINGLE_E)&&(!empty($this->league))) {
            foreach($league as $tur => $tur_game) {
                foreach ($tur_game as $position => $game) {
                    $num_text = (int)((string)($tur+1).(string)($position+1)); 
                    $text = $game->{0}->name." vs ".$game->{0}->name;
                    $forum_text .= '<p>'.$text.'</p>'; 
                    $this->seveForum($game,$num_text,$text);
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

    private function seveForum($game,$num_text,$text) 
    {
        $newtop = new Topic();
        $newtop->name = $text;
        $newtop->num_schedule = $num_text;
        $newtop->tournament_id = $this->id;
        $newtop->save(false);
    }

}