<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;


class MessageUser extends \yii\db\ActiveRecord
{

    const TEAM = 1;
    const TOURNAMENT = 2;
    const MATCH = 3;

    public static function tableName()
    {
        return 'message_user';
    }

    public function behaviors()
    {
        return [
            TimeStampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['sender', 'recipient', 'type', 'created_at', 'updated_at'], 'integer'],
            [['text','title'], 'string'],
            [['recipient'], 'required'],
            [
                ['recipient'], 
                'exist', 'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['recipient' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'recipient' => 'Recipient',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRecipients()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient']);
    }
 
    public function getSenders()
    {
        return $this->hasOne(User::className(), ['id' => 'sender']);
    }

    public function writeTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function writeType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function writeMessage($sender,$recipient,$text)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->text = $text;
        return $this->save();
    }
}
