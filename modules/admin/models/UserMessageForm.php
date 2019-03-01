<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\MessageUser;

class UserMessageForm extends Model
{
    public $subject;
    public $content;
    public $user_id;

    public function rules()
    {
        return [
            
            [['subject', 'content','user_id'], 'required'],
            ['user_id', 'integer'],
            [['subject', 'content'], 'string'],
            [
                ['subject', 'content'],
                'filter', 
                'filter' => 'strip_tags'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'subject' => 'Message subject',
            'content' => 'Message body',
        ];
    }


    public function sendMessage ()
    {
        if ($this->validate()) {
            $message = new MessageUser();
            $message->writeTitle("Administrator: {$this->subject}")
                ->writeMessage(1, $this->user_id, $this->content);
            Yii::$app->mailer->compose()
                ->setFrom([
                    Yii::$app->params['adminEmail'] => 'Site administrator Esports']
                )->setTo([$message->recipients->email])
                ->setSubject($this->subject)
                ->setTextBody($this->content)->send(); 
            return true;
        }
        return false;
    }


}
