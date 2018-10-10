<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;


class MessageUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
            [['sender', 'recipient', 'created_at', 'updated_at'], 'integer'],
            [['text','title'], 'string'],
            [['sender', 'recipient'], 'required'],
            [['recipient'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient' => 'id']],
            [['sender'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
    
    public function writeMessage($sender,$recipient,$text)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->text = $text;
        $this->save();
    }
}
