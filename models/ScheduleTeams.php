<?php

namespace app\models;

use Yii;
use app\modules\forum\models\SchedulePost;
use app\models\servises\UserServis;

class ScheduleTeams extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'schedule_teams';
    }

    public function rules()
    {
        return [
            [['tournament_id', 'team1', 'team2', 'results1', 'results2', 'tur', 'group','format','active_result'], 'integer'],
            [['date'], 'safe'],
            [['results1', 'results2'], 'number'],
            [['team1'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team1' => 'id']],
            [['team2'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team2' => 'id']],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'team1' => 'Team1',
            'team2' => 'Team2',
            'results1' => 'Results1',
            'results2' => 'Results2',
            'tur' => 'Tur',
            'group' => 'Group',
            'date' => 'Date',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        
        if ($insert) {
            $this->tournament->forumText($this);
            if($this->tournament->game->id < 3) {
               UserServis::scheduleUsers($this,$this->tournament_id); 
            }     
        } else {
            $this->addMatch();
            ResultsStatistics::addStatistic($this);
        }
        
        parent::afterSave($insert, $changedAttributes);
    }
  
    public function getTeamF()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team1']);
    }

    public function getTeamS()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team2']);
    }

    public function getUserMatch()
    {
        return $this->hasMany(UsersMatch::className(), ['match' => 'id']);
    }

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id'])->with(['game']);
    }

    public function getFiveResult()
    {
        $result1 = self::find()
            ->where(['team1'=>$this->team1])
            ->orWhere(['team2'=>$this->team1])
            ->andWhere(['<','id',$this->id])
            ->andWhere(['not',['results1'=> null]])->andWhere(['not',['results2'=>null]])
            ->orderBy('id DESC')->limit(5)->all();
        $result2 = self::find()
            ->where(['team1'=>$this->team2])
            ->orWhere(['team2'=>$this->team2])
            ->andWhere(['<','id',$this->id])
            ->andWhere(['not',['results1'=> null]])->andWhere(['not',['results2'=>null]])
            ->orderBy('id DESC')->limit(5)->all();

        return ['result1'=>$this->sortResult($result1,$this->team1),'result2'=>$this->sortResult($result2,$this->team2)];
    }

    private function sortResult($result,$team_id)
    {
        $arry_result = [];
        foreach ($result as $match) {
            if ($match->team1 == $team_id) {
                if ($match->results1>$match->results2) {
                    $arry_result[] = 1;
                } elseif ($match->results1<$match->results2) {
                    $arry_result[] = 2;
                } elseif ($match->results1 == $match->results2){
                    $arry_result[] = 3;
                }
            } elseif ($match->team2 == $team_id) {
                if ($match->results2>$match->results1) {
                    $arry_result[] = 1;
                } elseif ($match->results2<$match->results1) {
                    $arry_result[] = 2;
                } elseif ($match->results1 == $match->results2){
                    $arry_result[] = 3;
                }
            }
        }
        return $arry_result;
    }

    private function addMatch()
    {
        if ($this->format == 1) {
            $this->addMatchSingle();
        } elseif ($this->format == 2) {
            $d;
        } elseif ($this->format == 3) {
            $l;
        }    
    }

    private function addMatchSingle()
    {
        $matches = self::find()->where([
            'tournament_id'=>$this->tournament_id,
            'tur'=>$this->tur,
        ])->all();
        $winner = [];
        //$loser = [];
        foreach ($matches as $match) {
            if(!is_numeric($match->results1)
                || !is_numeric($match->results2)
                || ($match->results2 == $match->results1))
            {
                return false;
            }
            if ($match->results1 > $match->results2) {
                $winner[] = $match->team1;
            } elseif ($match->results1 < $match->results2) {
                $winner[] = $match->team2;
            }
        }
        $count = count($winner);
        $winner_cup = $winner;
        if ($count%2==0&&$count>0) {
            $count = $count/2;
            for ($i=0; $i < $count; $i++) { 
                $new_mathc = new self();
                $winer1 = array_pop($winner);
                $winer2 = array_pop($winner);
                $new_mathc->team1 = $winer1;
                $new_mathc->team2 = $winer2;
                $new_mathc->tur = ($this->tur + 1);
                $new_mathc->tournament_id = $this->tournament_id;
                $new_mathc->format = 1;
                $new_mathc->date = $this->date;
                $new_mathc->save();
            }
        }
        if (!empty($winner_cup)) {
            $this->tournament->addCupSingle($winner_cup);
        }
       
    }

}
