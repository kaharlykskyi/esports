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

    public function getShedule()
    {
        $matches = ScheduleTeams::find()->where(['team1'=>$this->team_id])
            ->orWhere(['team2'=>$this->team_id])
            ->andWhere(['tournament_id' => $this->tournament_id])
            ->andWhere(['not',['results1'=> null]])->andWhere(['not',['results2' => null]])
            ->orderBy('id DESC')->limit(5)->all();

        $result = [];
        foreach ($matches as $matche) { 
            if ($matche->team1 == $this->team_id) {
                if ($matche->results1 > $matche->results2) {
                    $result[] = 1;
                } elseif ($matche->results2 > $matche->results1) {
                    $result[] = 0;
                }
            }
            elseif ($matche->team2 == $this->team_id ) {
                if ($matche->results2 > $matche->results1) {
                    $result[] = 1;
                } elseif ($matche->results1 > $matche->results2) {
                    $result[] = 0;
                }
            }   
        } 

        return $result;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'summ_ball' => 'Summ Ball',
        ];
    }
}
