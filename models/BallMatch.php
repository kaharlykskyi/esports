<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ball_match".
 *
 * @property int $id
 * @property int $summ_ball
 */
class BallMatch extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ball_match';
    }

    public function rules()
    {
        return [

            [['tournament_id', 'team_id'], 'required'],
            [['summ_ball', 'tournament_id','played', 'lost', 'won'], 'integer'],
            [
                ['tournament_id'], 'exist',
                'skipOnError' => true, 
                'targetClass' => Tournaments::className(), 
                'targetAttribute' => ['tournament_id' => 'id']
            ],
            [
                ['team_id'], 'exist',
                'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'summ_ball' => 'Summ Ball',
        ];
    }
}
