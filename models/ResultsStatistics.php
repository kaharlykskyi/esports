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
            [['team_id', 'victories', 'loss','game_id','rate'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                ['team_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->rateUpdate();
        return true;
    } 

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
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

    public function getPercentage()
    {  
        if(!empty($this->victories)) {
            return round($this->victories/($this->victories+$this->loss)*100,1);
        } else {
            return 0;
        }
    }

    public static function addStatistic($match)
    {
        if($match->results1 > $match->results2) {
            self::addResults($match, $match->teamS, true);
            self::addResults($match, $match->teamF, false);
        } elseif($match->results1 < $match->results2) {
            self::addResults($match, $match->teamS, false);
            self::addResults($match, $match->teamF, true);
        } else {
            return;
        }
    }

    private static function addResults($match, $team, $flag)
    {
        if (!is_null($team->single_user)) {
            if ($match->tournament->game_id < 3) {
               return;
            }
            ResultsStatisticUsers::addSingleResults($match, $team, $flag);
            return;
        }
        if($flag) {
            $pole = 'victories';
        } else {
            $pole = 'loss';
        }  
        $model = self::find()
            ->where([ 
                'team_id' => $team->id, 
                'game_id' => $match->tournament->game_id,
            ])->one();

        if(!is_object($model)) {
            $model = new self();
            $model->team_id = $team->id;
            $model->game_id = $match->tournament->game_id;
            $model->victories = 0;
            $model->loss = 0;
            $model->rate = 0;
        }
        $model->$pole +=1;
        $model->save();
        //var_dump($model);exit;
    }
}
