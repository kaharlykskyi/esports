<?php

namespace app\models;

use Yii;

class TeamHistory extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'team_history';
    }

    public function rules()
    {
        return [
            [['team_id'], 'integer'],
            [['event'], 'required'],
            [['event'], 'string'],
            [['created_at'], 'safe'],
            [
                ['team_id'], 
                'exist', 'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'event' => 'Event',
            'created_at' => 'Created At',
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }
}
