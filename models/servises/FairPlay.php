<?php

namespace app\models\servises;

use app\models\UsetTeamTournament;
use app\models\User;
use Yii;

class FairPlay
{
    public static function capitanTournaments($id_user,$tournament_id)
    {
        $model = UsetTeamTournament::find()->where([
            'user_id' => $id_user,
            'tournament_id' => $tournament_id,
        ])->one();
        return $model;
        
    }

    public static function RremRating($id,$tournament_id)
    {
        $user = Yii::$app->user->identity;
        $capitan_tournament = self::capitanTournaments($id,$tournament_id);
        if (isset($capitan_tournament)&&$user) {
            if ($capitan_tournament->tournament->user_id == $user->id) {
                if(!$capitan_tournament->fair_play) {
                    $capitan_tournament->fair_play = 1;
                    $capitan_tournament->save();
                    $capitan_tournament->user->fair_play = $capitan_tournament->user->fair_play-7;
                    $capitan_tournament->user->save();
                }
            }
        }
    }

    public static function addRating($tournament)
    {
        if ($tournament->state == 2) {
            $user_t = UsetTeamTournament::find()->select('user_id')
                ->where([
                    'tournament_id' => $tournament->id, 
                    'fair_play' => 0
            ]);
            $users = User::find()->where(['in', 'id', $user_t])
                ->andWhere(['<', 'fair_play', 100])->all();
            foreach ($users as $user) {
                $user->fair_play = $user->fair_play + 5;
                if ($user->fair_play > 100) {
                    $user->fair_play = 100;
                }
                $user->save();
            }    
        }
    }
}