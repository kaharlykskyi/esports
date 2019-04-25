<?php

namespace app\models;

use Yii;
use app\modules\forum\models\SchedulePost;
use app\models\servises\UserServis;
use app\models\events\MatchEvent;

class ScheduleTeams extends \yii\db\ActiveRecord
{
    /*
        Format match
    */
    const FM_CUP = 1;
    const FM_DCUP = 2;
    const FM_LEAGUE = 3;

    public static function tableName()
    {
        return 'schedule_teams';
    }

    public function rules()
    {
        return [
            [['tournament_id', 'team1', 'team2', 'results1', 'results2', 'tur', 
                'group','format','active_result'], 'integer'],
            [['date'], 'safe'],
            [['results1', 'results2'], 'number'],
            [
                ['team1'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team1' => 'id']
            ],
            [
                ['team2'], 'exist', 
                'skipOnError' => true,
                 'targetClass' => Teams::className(), 
                 'targetAttribute' => ['team2' => 'id']
            ],
            [
                ['tournament_id'], 'exist', 
                'skipOnError' => true, 
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
            'team1' => 'Team1',
            'team2' => 'Team2',
            'results1' => 'Results1',
            'results2' => 'Results2',
            'tur' => 'Tur',
            'group' => 'Group',
            'date' => 'Date',
        ];
    }

    public function afterSave ($insert, $changedAttributes)
    {
        if ($insert) {
            MatchEvent::creationMatch($this);
            $this->tournament->forumText($this);
            if($this->tournament->game->id < 3) {
               UserServis::scheduleUsers($this, $this->tournament_id); 
            }     
        } else {
            MatchEvent::played($this);
            $this->addMatch();
            
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
            $this->tournament->system->addMatch($this);//$this->addMatchSingle();
        } elseif ($this->format == 2) {
            $this->addMatchDuble();
        } elseif ($this->format == 3) {
           $this->tournament->system->addMatch($this);
        } elseif ($this->format == 4) {
            $this->tournament->system->addMatch($this);
        } elseif ($this->format == 6) {
            $this->tournament->system->addMatch($this);
        }      
    }

    private function addMatchSingle()
    {
        $matches = self::find()->where([
            'tournament_id'=>$this->tournament_id,
            'tur'=>$this->tur,
        ])->all();
        $result = $this->winAndLoss($matches);
        if (!$result) {
            return false;
        }
        $this->writeStringTable($result[0],1,($this->tur + 1));
        if (!empty($result[0])) {
            $this->tournament->addCupSingle($result[0]);
        }
    }

    private function addMatchDuble()
    {
        if ($this->tur==1 && $this->group==1) {
            $matches = self::find()->where([
                'tournament_id'=>$this->tournament_id,
                'tur'=>1,
                'group' => 1,
            ])->all();
            $result = $this->winAndLoss($matches);
            if (!$result) {
                return false;
            }
            $this->writeStringTable($result[0], 2, ($this->tur + 1), 1);
            $this->writeStringTable($result[1], 2, 1, 2);
            $this->tournament->addCupDuble($result[0]);

        } elseif(($this->group==1 && $this->tur >1)||($this->group == 2 && !($this->tur%2==0)) ) {

            if ($this->group ==1) {
                $tur_winner = $this->tur;
                $tur_losers = (($this->tur-2)*2)+1;
            } elseif ($this->group == 2) {
                $tur_winner = ($this->tur-1)/2+2;
                $tur_losers = $this->tur;
            }

            $matches_win = self::find()->where([
                'tournament_id' => $this->tournament_id,
                'tur' => $tur_winner,
                'group' => 1,
            ])->all();

            $matches_los = self::find()->where([
                'tournament_id' => $this->tournament_id,
                'tur' => $tur_losers,
                'group' => 2,
            ])->all();

            $result_win = $this->winAndLoss($matches_win);
            $result_los = $this->winAndLoss($matches_los);
            if ( empty($result_win) || empty($result_los)) {
                return false;
            }

            if (count($result_win[1]) == count($result_los[0])) {
                $los = $result_los[0];
                $win = $result_win[1];
                $arry_new_loss = [];
                $c = count($los);
                if (!(($tur_losers+1)%4==0)) {
                    $los = array_reverse($los);
                }
                for ($i=0; $i < $c; $i++) { 
                  $arry_new_loss[] = array_pop($los);
                  $arry_new_loss[] = array_pop($win);
                }

            }
            $this->writeStringTable($result_win[0], 2, ($tur_winner+1), 1);
            $this->writeStringTable($arry_new_loss, 2, ($tur_losers+1), 2);
            $this->tournament->addCupDuble(array_merge($result_win[0],$result_los[0]));

        } elseif($this->group == 2 && ($this->tur%2==0)) {
            $matches_los = self::find()->where([
                'tournament_id' => $this->tournament_id,
                'tur' => $this->tur,
                'group' => 2,
            ])->all();
            $result_los = $this->winAndLoss($matches_los);
            if (!$result_los) {
                return false;
            }

            if (count($result_los[0]) == 1) {

                $matches_win = self::find()->where([
                    'tournament_id' => $this->tournament_id,
                    'tur' => ($this->tur-2)/2+2,
                    'group' => 1,
                ])->all();

                $result_win = $this->winAndLoss($matches_win);
                if (!$result_win) {
                    return false;
                }

                if (count($result_los[0]) ==  count($result_win[0])){
                    $final_arry = [];

                    $final_arry[] = array_pop($result_los[0]);
                    $final_arry[] = array_pop($result_win[0]);
                    $this->writeStringTable($final_arry, 2, 1, 3);
                    $this->tournament->addCupDuble($final_arry);
                }
            } else {
                $this->writeStringTable($result_los[0], 2, ($this->tur+1), 2);
                $this->tournament->addCupDuble($result_los[0]);
            }
        } elseif( $this->group == 3 ) {
            $matches_final = self::find()->where([
                'tournament_id' => $this->tournament_id,
                'tur' => 1,
                'group' => 3,
            ])->all();

            $matches_final = $this->winAndLoss($matches_final);
            if (!$matches_final) {
                return false;
            }
            $this->tournament->addCupDuble($matches_final[0]);
            $this->tournament->state =2;
            $this->tournament->save();
        }
      
    }

    private function writeStringTable($players,$format,$tur,$group=null)
    {
        $winner = $players;
        $count = count($winner);
        if ($count%2==0&&$count>0) {
            $count = $count/2;
            for ($i=0; $i < $count; $i++) { 
                $new_mathc = new self();
                $winer1 = array_pop($winner);
                $winer2 = array_pop($winner);
                $new_mathc->team1 = $winer1;
                $new_mathc->team2 = $winer2;
                $new_mathc->tur = $tur;
                $new_mathc->tournament_id = $this->tournament_id;
                $new_mathc->format = $format;
                $new_mathc->group = $group;
                $time_pluss = 2;
                if ($group==2) {
                    $time_pluss = 1;
                }
                $time_pluss_string = "+".$time_pluss." day";
                $newdata = strtotime($time_pluss_string,strtotime ($this->date));
                $new_mathc->date = date('Y-m-d H:m:i', $newdata);
                $new_mathc->save();
            }
        }
    }

    private function winAndLoss($matches)
    {
        $winner = [];
        $loser = [];
        foreach ($matches as $match) {
            if(!is_numeric($match->results1)
                || !is_numeric($match->results2)
                || ($match->results2 == $match->results1))
            {
                return false;
            }
            if ($match->results1 > $match->results2) {
                $winner[] = $match->team1;
                $loser[] = $match->team2;
            } elseif ($match->results1 < $match->results2) {
                $winner[] = $match->team2;
                $loser[] = $match->team1;
            }
        }

        return [array_reverse($winner),array_reverse($loser)];
    }

}
