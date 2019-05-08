<?php

namespace app\models;

use Yii;


class TournamentUser extends \yii\db\ActiveRecord
{

    const SENT = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;
    const PART_REQUESTS = 4;

    public static function tableName()
    {
        return 'tournament_user';
    }

    public function rules()
    {
        return [
            [['tournament_id', 'user_id','status'], 'integer'],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'user_id' => 'User ID',
        ];
    }

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
