<?php

namespace app\models;

use Yii;
use  app\models\points\PointsPoint;

class UserPoint extends \yii\db\ActiveRecord
{
    public static $arry_bonus = [

        /*  1*/['Play first game',100],//+
        /*  2*/['Play first match in a league format tournament', 100],//+
        /*  3*/['Play first match in a cup-shaped tournament',100],//+
        /*  4*/['Play first match in a tournament with Swiss format',100],//+
        /*  5*/['Play in five tournaments in total', 500],//+

        /*  6*/['Play five matches in a league format tournament', 500],//+
        /*  7*/['Play five matches in a cup-shaped tournament', 500],//+
        /*  8*/['Play five matches in a tournament with Swiss format', 500],//+
        /*  9*/['Play in a five league format tournaments', 1000],//+
        /* 10*/['Play in a five cup-shaped tournaments', 1000],//+
        /* 11*/['Play in a five swiss round format tournaments', 1000],//+

        /* 12*/['Play fifty matches in a league format tournament', 3000],//+
        /* 13*/['Play fifty matches in a cup-shaped tournament', 3000],//+
        /* 14*/['Play fifty matches in a tournament with Swiss forma', 3000],//+
        /* 15*/['Play in a twenty league format tournaments', 3000],//+
        /* 16*/['Play in a twenty cup-shaped tournaments', 3000],//+
        /* 17*/['Play in a twenty swiss round format tournaments', 3000],//+

        /* 18*/['Play two hundred matches in a league format tournament', 10000],
        /* 19*/['Play two hundred matches in a cup-shaped tournament', 10000],
        /* 20*/['Play two hundred matches in a tournament with Swiss format', 10000],
        /* 21*/['Play in a one hundred league format tournaments', 15000],//+
        /* 22*/['Play in a one hundred cup-shaped tournaments', 15000],//+
        /* 23*/['Play in a one hundred swiss round format tournaments', 15000],//+
            //MANAGE
        /* 24*/['Create first tournament', 250],//+
        /* 25*/['Create first league format tournament', 250],//+
        /* 26*/['Create first cup-shaped format tournament', 250],//+
        /* 27*/['Create first swiss round format tournament', 250],//+
        /* 28*/['Create five tournaments in total', 1000],//+

        /* 29*/['Create five league format tournaments', 1500],//+
        /* 30*/['Create five cup-shaped format tournaments', 1500],//+
        /* 31*/['Create five swiss round format tournaments', 1500],//+
        /* 32*/['Create twenty tournaments in total', 2000],//+

        /* 33*/['Create twenty league format tournaments', 5000],//+
        /* 34*/['Create twenty cup-shaped format tournaments', 5000],//+
        /* 35*/['Create twenty swiss round format tournaments', 5000],//+
        /* 36*/['Create fifty tournaments in total', 6000],//+

        /* 37*/['Create one hundred league format tournaments', 20000],//+
        /* 38*/['Create one hundred cup-shaped format tournaments', 20000],//+
        /* 39*/['Create one hundred swiss round format tournaments', 20000],//+
        /* 40*/['Create five hundred tournaments in total', 30000],//+
            //TEAM
        /* 41*/['Create first team', 1000],//+
        /* 42*/['Invite first player for team', 100],//+
        /* 43*/['Participe in first tournament', 250],//+

        /* 44*/['Win first team tournament', 1000],//+
        /* 45*/['Participe in ten team tournaments', 1000],//+

        /* 46*/['Win ten team tournaments', 3000],//+
        /* 47*/['Participe in fifty team tournaments', 3000],//+
        /* 48*/['Participe in epic team tournamen', 3000],//+
        /* 49*/['Participe in ten great team tournaments', 3000],//+

        /* 50*/['Win fifty team tournaments', 20000],//+
        /* 51*/['Participe in one hundred team tournaments', 20000],//+
        /* 52*/['Participe in legendary team tournament', 30000],//+
        /* 53*/['Participe in twenty epic team tournaments', 20000],//+
            //POINTS
        /* 54*/['Win first point', 100],//+
        /* 55*/['Get 1000 points', 100],//+
        /* 56*/['Get 5000 points', 500],//+

        /* 57*/['Get 10000 points', 1000],//+
        /* 58*/['Get 15000 points', 1500],//+
        /* 59*/['Get 20000 points', 2000],//+
        
        /* 60*/['Get 50000 points', 2500],//+
        /* 61*/['Get 75000 points', 3500],//+
        /* 62*/['Get 100000 points', 5000],//+

        /* 63*/['Get 250000 points', 10000],//+
        /* 64*/['Get 500000 points', 25000],//+
        /* 65*/['Get 1000000 points', 50000],//+
                //SOCIAL NETWORKS
        /* 66*/['Follow us in Twitter', 1000],//+
        /* 67*/['Follow us in Facebook', 1000 ],//+
        /* 68*/['Follow us in Twitch', 1000 ],//+
        /* 69*/['Follow us in Youtube', 1000],//+
        /* 70*/['Follow us in Instagram', 1000],//+
        
        /* 71*/['Get 10 likes in Twitter', 2000],//+
        /* 72*/['Get 10 RT in Twitter', 2000],
        /* 73*/['Follow one of our Partners in Twitter', 1000],
            
        /* 74*/['Follow one of our Partners in Twitch', 1000],
        /* 75*/['Get 30 likes in Twitter', 3000],
        /* 76*/['Get 30 RT in Twitter', 3000],
        /* 77*/['Follow all of our Partner in Twitter', 3000],

        /* 78*/['Get 100 likes in Twitter', 5000],
        /* 79*/['Get 100 RT in Twitter', 5000],
        /* 80*/['Subscribe our newsletter', 2000],
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

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
           PointsPoint::getPoints($this);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getNameBonus()
    {
        return self::$arry_bonus[$this->bonus_id-1][0];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function addBall($bonus_id,$user_id,$cup) 
    {
        $model = new self();
        $ball = self::$arry_bonus[$bonus_id-1][1];

        $model->appraisal = $ball;
        $model->user_id = $user_id;
        $model->bonus_id = $bonus_id;
        $model->save();
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
}

