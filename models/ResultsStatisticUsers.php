<?php

namespace app\models;

use Yii;

class ResultsStatisticUsers extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'results_statistic_users';
    }

   
    public function rules()
    {
        return [
            [['user_id', 'team_id', 'victories', 'loss','game_id','rate'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        $this->rateUpdate();
        return true;
    } 

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    public static function addStatistic($user_match)
    {
        if($user_match->results1 > $user_match->results2) {
            self::addResults($user_match, $user_match->user1, true);
            self::addResults($user_match, $user_match->user2, false);
        } elseif($user_match->results1 < $user_match->results2) {
            self::addResults($user_match, $user_match->user1, false);
            self::addResults($user_match, $user_match->user2, true);
        } else {
            return;
        }
    }

    private static function addResults($user_match, $user, $flag)
    {
        if ($user_match->user1 == $user) {
            $team = 'team1';
        } elseif ($user_match->user2 == $user) {
            $team = 'team2';
        }

        if($flag) {
            $pole = 'victories';
        } else {
            $pole = 'loss';
        }

        $model = self::find()
            ->where([
                'user_id' => $user, 
                'team_id' => $user_match->matche->$team, 
                'game_id' => $user_match->tournament->game_id,
            ])->one();

        if(!is_object($model)) {
            $model = new self();
            $model->user_id = $user;
            $model->team_id = $user_match->matche->$team;
            $model->game_id = $user_match->tournament->game_id;
        }
        $model->$pole = $model->$pole+1;
        $model->save();

    }

    public static function addSingleResults($match, $team, $flag)
    {
        if($flag) {
            $pole = 'victories';
        } else {
            $pole = 'loss';
        }
        $model = self::find()
            ->where([ 
                'user_id' => $team->capitan,
                'team_id' => $team->id, 
                'game_id' => $match->tournament->game_id,
            ])->one();

        if(!is_object($model)) {
            $model = new self();
            $model->team_id = $team->id;
            $model->game_id = $match->tournament->game_id;
        }

        $model->$pole = $model->$pole+1;
        $model->save();

    }

    private function rateUpdate()
    {   if (!empty($this->victories)&&!empty($this->loss)) {
            $this->rate = round($this->victories/$this->loss,2);
        } elseif(empty($this->loss)) {
            $this->rate = $this->victories;
        } else {
            $this->rate =  0;
        }
        
    }
}
