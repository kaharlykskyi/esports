<?php

namespace app\models;

use Yii;

class TournamentTeam extends \yii\db\ActiveRecord
{
    
    const SENT = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;

    public static function tableName()
    {
        return 'tournament_team';
    }

    public function rules()
    {
        return [
            [['tournament_id', 'team_id','status'], 'integer'],
            [
                ['team_id'], 
                'exist', 'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
            [
                ['tournament_id'], 
                'exist', 'skipOnError' => true, 
                'targetClass' => Tournaments::className(), 
                'targetAttribute' => ['tournament_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'team_id' => 'Team ID',
        ];
    }

 
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == self::ACCEPTED) {
            TeamHistory::setHistory('addTournament', $this, $this->team_id);
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
