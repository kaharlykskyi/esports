<?php

namespace app\models;

use Yii;

class UserPoint extends \yii\db\ActiveRecord
{
    public $arry_bonus = [
        'Participation in the match',
        'Victory in the match',
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'appraisal' => 'Appraisal',
        ];
    }

    public function getNameBonus()
    {
        return $this->arry_bonus[$this->bonus_id-1];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function addBall($bonus_id,$user_id,$ball) 
    {
        $model = new self();
        $model->appraisal = $ball;
        $model->user_id = $user_id;
        $model->bonus_id = $bonus_id;
        $model->save();
    }

    public static function MonthSum($user_id)
    {
        $user_points = (new \yii\db\Query())
            ->select(['Sum(appraisal) as sum','Month(user_point.created_at) as month',
            'Year(user_point.created_at) as year'])
            ->from('user_point')->where(['user_id' => $user_id])
            ->groupBy(['Year(user_point.created_at)','Month(user_point.created_at)'])
            ->limit(11)->all();

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
