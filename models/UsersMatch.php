<?php

namespace app\models;

use app\models\ResultsStatisticUsers;
use Yii;

class UsersMatch extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'users_match';
    }

    public function rules()
    {
        return [
            [
                ['user1', 'user2', 'match', 
                    'results1', 'results2', 'tournament_id', 'round','state'
                ], 'integer'
            ],
            [['match'], 'required'],
            [['data'], 'string'],
            [['match'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => ScheduleTeams::className(), 
                'targetAttribute' => ['match' => 'id']
            ],
            [['tournament_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Tournaments::className(), 
                'targetAttribute' => ['tournament_id' => 'id']
            ],
            [['user1'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['user1' => 'id']
            ],
            [['user2'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['user2' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user1' => 'User1',
            'user2' => 'User2',
            'match' => 'Match',
            'results1' => 'Results1',
            'results2' => 'Results2',
            'tournament_id' => 'Tournament ID',
            'round' => 'Round',
            'data' => 'Data',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    { 
        if (!$insert) {
            ResultsStatisticUsers::addStatistic($this);
            $this->addBallUser();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getMatche()
    {
        return $this->hasOne(ScheduleTeams::className(), ['id' => 'match']);
    }

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public function getUserS()
    {
        return $this->hasOne(User::className(), ['id' => 'user1']);
    }

    public function getUserF()
    {
        return $this->hasOne(User::className(), ['id' => 'user2']);
    }

    private function addBallUser()
    {
        if (is_numeric($this->results1)&&is_numeric($this->results2)) {
            if ($this->results1 != $this->results2) {
                if ($this->results1 > $this->results2) {
                    $this->userS->addBall(20);
                    $this->userF->addBall(10);
                } else {
                    $this->userS->addBall(10);
                    $this->userF->addBall(20);
                }
            }
        }
    }
}
