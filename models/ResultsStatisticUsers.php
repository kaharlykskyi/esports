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
            [['user_id', 'team_id', 'victories', 'loss','game_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'team_id' => 'Team ID',
            'victories' => 'Victories',
            'loss' => 'Loss',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    public function getRate()
    {   if (!empty($this->victories)&&!empty($this->loss)) {
            return round($this->victories/$this->loss,2);
        } else {
            return 0;
        }
        
    }
}
