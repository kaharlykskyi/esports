<?php

namespace app\models\traits;

use app\models\TournamentTeam;
use app\models\UserTeam;

trait UserTournament {
    
    public static function gerUsers($model) 
    {

        $users = (new \yii\db\Query())->select(['users.id'])->from('users')
            ->leftJoin('user_team', 'user_team.id_user = users.id')
            ->leftJoin('teams', 'teams.id = user_team.id_team')
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where([ 'and',
                ['tournament_team.status' => TournamentTeam::ACCEPTED],
                ['in', 'user_team.status',[UserTeam::ACCEPTED, UserTeam::DUMMY]],
                ['tournament_team.tournament_id' => $model->id]
            ])->all();
        array_push($users, ['id' => $model->user_id]);
        return $users;

    }

}