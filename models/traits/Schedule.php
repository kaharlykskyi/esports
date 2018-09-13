<?php

namespace app\models\traits;

use app\models\ScheduleTeams;

trait Schedule {

    public function createSchedule($teams,$format)
    {
        $result = [];
        foreach ($teams as $key => $match) {
           $result[] = $this->seveSchedule($match,$format);
        }
        $this->forumText($teams);
        return $result;
    }

    private function seveSchedule($game,$format) 
    {
        $schedule = new ScheduleTeams();
        $schedule->team1 = $game[0]['id'];
        $schedule->team2 = $game[1]['id'];
        $schedule->date = $game['date']??date("Y-m-d H:i");
        $schedule->group = $game['group']?? null;
        $schedule->tur = $game['tur']??1;
        $schedule->results1 = $game['results1']??null;
        $schedule->results2 = $game['results2']??null;
        $schedule->tournament_id = $this->id;
        $schedule->format = $format;
        $schedule->save(false);
        return [$schedule->results1,$schedule->results2,$schedule->id];
    }


    private function forumText($teams)
    {
        $forum_text = "";
        $forum_text .= $this->forum_text;
        foreach ($teams as $key => $team) {
            $text = $team[0]['name']." vs ".$team[1]['name'];
            $forum_text .= '<p>'.$text.'</p>';
        }
        $this->forum_text = $forum_text;
        $this->save(false);
    }

    public function getScheduleCup()
    {
        $teams = (new \yii\db\Query())
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo'])
            ->from('schedule_teams')
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id,'format'=>1])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

    public function getScheduleLeague()
    {
        $teams = (new \yii\db\Query())
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo'])
            ->from('schedule_teams')
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id,'format'=>2])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

}