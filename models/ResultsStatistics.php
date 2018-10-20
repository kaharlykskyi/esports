<?php

namespace app\models;

use Yii;


class ResultsStatistics extends \yii\db\ActiveRecord
{
 
    public static function tableName()
    {
        return 'results_statistics';
    }

    public function rules()
    {
        return [
            [['team_id', 'victories', 'loss','game_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
