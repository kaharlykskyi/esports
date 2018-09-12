<?php

namespace app\models\traits;
//use app\modules\forum\models\ForumTopic as Topic;
use app\models\ScheduleTeams;

trait Schedule {

    public function createSchedule($teams)
    {

        foreach ($teams as $key => $match) {
           $this->seveSchedule($match);
        }

    }

    // public function createSchedule1 ($league)
    // {
    //     $forum_text = '';
    //     if ($this->format == self::SINGLE_E) {
    //         foreach($league as $tur => $tur_game) {
    //             foreach ($tur_game as $position => $game) {
    //                 $text = $game[0]->name." vs ".$game[1]->name;
    //                 $forum_text .= '<p>'.$text.'</p>'; 
    //                 $this->seveSchedule($game,($tur+1));
    //             }
    //         }    
    //     }

    //     if (($this->format == self::DUBLE_E)&&(!empty($this->league))) {
    //         foreach($league as $grup => $shedule) {
    //             foreach($shedule as $tur => $tur_game) {
    //                 foreach ($tur_game as $position => $game) {
    //                     $text = $game[0]->name." vs ".$game[1]->name;
    //                     $forum_text .= '<p>'.$text.'</p>'; 
    //                     $this->seveSchedule($game,($tur+1));
    //                 }
    //             }    
    //         }
    //     }

    //     if ((($this->format == self::LEAGUE)||($this->format == self::LEAGUE_P))&&(!empty($this->league))) {
    //             foreach($league as $tur => $tur_game) {
    //                 foreach ($tur_game as $position => $game) {
    //                     $num_text = (int)((string)($tur+1).(string)($position+1)); 
    //                     $text = $game->players1->name." vs ".$game->players2->name;
    //                     $forum_text .= '<p>'.$text.'</p>'; 
    //                     $this->seveForum($game,$num_text,$text);
    //                 }
    //             }
    //     }


    //     if (($this->format == self::LEAGUE_G)&&(!empty($this->league))) {
    //         foreach($league as $grup => $shedule) {
    //             foreach($shedule as $tur => $tur_game) {
    //                 foreach ($tur_game as $position => $game) {
    //                     $num_text = (int)((string)($grup+1).(string)($tur+1).(string)($position+1));
    //                     $text = $game->players1->name." vs ".$game->players1->name;
    //                     $forum_text .= '<p>'.$text.'</p>'; 
    //                     $this->seveForum($game,$num_text,$text);
    //                 }
    //             }    
    //         }
    //     }

    //     $this->forum_text = $forum_text;
    //     $this->save(false);
    // }

    private function seveSchedule($game) 
    {
        // echo "<pre>";
        //     print_r($teams);
        //     echo "<pre>";exit;
        $schedule = new ScheduleTeams();
        $schedule->team1 = $game[0]['id'];
        $schedule->team2 = $game[1]['id'];
        $schedule->date = $game['date']??date("Y-m-d H:i");
        $schedule->group = $game['group']?? null;
        $schedule->tur = $game['tur']??1;
        $schedule->results1 = $game['results1']??null;
        $schedule->results2 = $game['results2']??null;
        $schedule->tournament_id = $this->id;
        $schedule->save(false);
    }


    private function forumText($teams)
    {
        $forum_text = "";
        foreach ($teams as $key => $team) {
            $text = $team[0]['name']." vs ".$team[1]['name'];
            $forum_text .= '<p>'.$text.'</p>';
        }
        $this->forum_text = $forum_text;
        $this->save(false);
    }

    public function getSchedule()
    {
        $teams = (new \yii\db\Query())
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo'])
            ->from('schedule_teams')
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

}