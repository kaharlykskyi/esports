<?php

namespace app\models\traits;

use app\models\ScheduleTeams;
use app\models\servises\UserServis;
trait Schedule {

    public function createSchedule($teams,$format,$date = false)
    {
        foreach ($teams as $key => $match) {
           $this->seveSchedule($match,$format,$date);
        }
        return $teams;
    }

    private function seveSchedule($game,$format,$date) 
    {
        $schedule = new ScheduleTeams();
        $schedule->team1 = $game[0]['id'];
        $schedule->team2 = $game[1]['id'];
        if (!$date) {
            $schedule->date = $game['date']??date("Y-m-d H:i");
        } else {
            $schedule->date = $date;
        }
        $schedule->group = $game['group']?? null;
        $schedule->tur = $game['tur']??1;
        $schedule->results1 = $game['results1']??null;
        $schedule->results2 = $game['results2']??null;
        $schedule->tournament_id = $this->id;
        $schedule->format = $format;
        $schedule->save(false);
        return $schedule;
    }


    public function forumText($match)
    {
        $forum_text = $this->forum_text;
        $text = $match->teamS->name." vs ".$match->teamF->name;
        $forum_text .= '<p><a href="/tournaments/upcoming-match/'.$match->id.'" >'.$text.'</a></p>';
        $this->forum_text = $forum_text;
        $this->save(false);
    }

    public function getScheduleCup()
    {
        $teams = (new \yii\db\Query())
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo',
            '(select count(*) from schedule_post where schedule_teams_id = schedule_teams.id ) as count_post'])
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
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo',
              '(select count(*) from schedule_post where schedule_teams_id = schedule_teams.id ) as count_post' ])
            ->from('schedule_teams')
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id,'format'=>2])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

    public function getScheduleCupModel()
    {
        $teams = ScheduleTeams::find()->with()
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo',
            '(select count(*) from schedule_post where schedule_teams_id = schedule_teams.id ) as count_post'])
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id,'format'=>1])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

    public function getScheduleLeagueModel()
    {
        $teams = ScheduleTeams::find()->with()
            ->select(['schedule_teams.*','f.name as f_name','f.logo as f_logo','s.name as s_name','s.logo as s_logo',
              '(select count(*) from schedule_post where schedule_teams_id = schedule_teams.id ) as count_post' ])
            ->innerJoin('teams f', 'f.id = schedule_teams.team1')
            ->innerJoin('teams s', 's.id = schedule_teams.team2')
            ->where(['tournament_id' => $this->id,'format'=>3])
            ->orderBy(['schedule_teams.group' => SORT_ASC,'schedule_teams.tur' => SORT_ASC])
            ->all();
        return $teams;
    }

}