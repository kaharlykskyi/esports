<?php

namespace app\models;

use Yii;

class UserPoint extends \yii\db\ActiveRecord
{
    public $arry_bonus = [
        ['Participation in the match',10],
        ['Victory in the match',20],
        ['Took part in the tournament',10],
        ['Tournament creation',20],
        ['Tournament victory',200],
        ['Adding social networks',20],
        ['Winning several matches in a row',20],
        ['Win several tournaments in turn',200],
    ];

    public static function tableName()
    {
        return 'user_point';
    }

    public function rules()
    {
        return [
            [['user_id', 'appraisal'], 'integer'],
            [['bonus_id'], 'required'],
            [['bonus_id'], 'number'],
            [
                ['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::className(), 
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function getNameBonus()
    {
        return $this->arry_bonus[$this->bonus_id-1][0];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function addBall($bonus_id,$user_id,$cup) 
    {
        $model = new self();
        $ball = $model->arry_bonus[$bonus_id-1][1];
        if ($cup>5000) {
            $bonus_ball = 60;
        } elseif ($cup>4000) {
            $bonus_ball = 50;
        } elseif ($cup>3000) {
            $bonus_ball = 40;
        } elseif ($cup>2000) {
            $bonus_ball = 30;
        } elseif ($cup>1000){
            $bonus_ball = 20;
        } else {
            $bonus_ball = 0;
        }

        $model->appraisal = $ball + $bonus_ball;
        $model->user_id = $user_id;
        $model->bonus_id = $bonus_id;
        $model->save();

        if($bonus_id == 2) {
            $this->dubleWinMatch($user_id,$bonus_ball);
        }

        if($bonus_id == 5) {
            $this->dubleWinTournament($user_id,$bonus_ball);
        }
    }

    public static function MonthSum($user_id)
    {
        $user_points = (new \yii\db\Query())
            ->select([
                'Sum(appraisal) as sum',
                'Month(user_point.created_at) as month',
                'Year(user_point.created_at) as year'
        ])->from('user_point')->where(['user_id' => $user_id])
            ->groupBy([
                'Year(user_point.created_at)',
                'Month(user_point.created_at)'
        ])->limit(11)->all();

        foreach ($user_points as &$user_point) {
            $str = strval($user_point['month']);
            if (strlen($str)<2) {
                $str = '0'.$str;
            }
            $user_point['y_m'] = $user_point['year'].'-'.$str;
        }
        return $user_points;
    }

    private function dubleWinMatch($user_id,$bonus_ball)
    {
        $model_array = self::find()
            ->where(['user_id'=>$this->user_id])
            ->orderBy('id desc')->limit(30)->all(); 

        $int_count = 0;
        foreach ($model_array as $val_mod) {
            if($val_mod->bonus_id == 2) {
                $int_count++;
                if($int_count==2){
                    $model = new self();
                    $model->appraisal = $model->arry_bonus[6][1]; + $bonus_ball;
                    $model->user_id = $user_id;
                    $model->bonus_id = 7;
                    $model->save();
                    break;
                }
            }
            if($val_mod->bonus_id == 1){
                break;
            }
        }
    }

    private function dubleWinTournament($user_id,$bonus_ball)
    {
        $model = Tournaments::find()
            ->innerJoin('uset_team_tournament', 'uset_team_tournament.tournament_id = tournaments.id')
            ->where(['uset_team_tournament.user_id' => $this->user_id])
            ->where(['IS NOT', 'winner', null])
            ->orderBy(['tournaments.id' => SORT_DESC])->one(); 
        if (is_object($model)) {
            $model_u = $model->uset_team_tournament;
            $t_w = false;
            foreach ($model_u as $value) {
                if ($value->user_id == $user_id) {
                    $t_w = $value->team_id;
                    break;
                }     
            }
            if ($t_w && ($model->winner==$t_w)) {
                $model = new self();
                $model->appraisal = $model->arry_bonus[7][1]; + $bonus_ball;
                $model->user_id = $user_id;
                $model->bonus_id = 8;
                $model->save();
            }
        }
    }
}
