<?php

namespace app\models;

use Yii;


class Stream extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'stream';
    }

    public function rules()
    {
        return [
            [['tournament_id', 'stream_chanal'], 'integer'],
            [['stream_url'], 'string', 'max' => 200],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'stream_chanal' => 'Stream Chanal',
            'stream_url' => 'Stream Url',
        ];
    }

 
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }
}
