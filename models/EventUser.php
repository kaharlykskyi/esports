<?php

namespace app\models;

use Yii;

class EventUser extends \yii\db\ActiveRecord
{

    const PLAY = 1;
    const PLAY_MATCH = 1;
    const PLAY_TOURNAMENT = 2;
    const PLAY_CUP = 1;
    const PLAY_LEAGUE = 2;
    const PLAY_SWISS = 3;
    //======================//
    const MANAGE = 2;
    const MANAGE_CUP = 4;
    const MANAGE_LEAGUE = 5;
    const MANAGE_SWISS = 6;
    //======================//
    const TEAM = 3;
    const CREATE_TEAM = 3;
    const INVINITE_PLAYER = 4;
    const PARTICIPE = 5;
    const WIN = 4;

    //======================//
    const POINTS = 4;
    //======================//
    const SOCIAL_NETWORKS = 5;
    const SEGUE = 1;
    const TWITTER  = 1;
    const FACEBOOK = 2;
    const TWITCH = 3;
    const YOUTUBE = 4;
    const INSTAGRAM = 5;



    public static function tableName()
    {
        return 'event_user';
    }

    public function rules()
    {
        return [
            [['user_id', 'type', 'type_event', 'event'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                ['user_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Users::className(), 
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'event' => 'Event',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function create($user_id, $type, $type_event, $event)
    {
        $this->user_id = $user_id; 
        $this->type = $type;
        $this->type_event = $type_event;
        $this->event = $event;
        $this->save(false);

    }
}
