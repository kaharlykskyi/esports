<?php

namespace app\modules\forum\models;

use Yii;
use app\models\User;
use yii\behaviors\TimestampBehavior;

class ForumPost extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
            TimeStampBehavior::className(),
        ];
    }

    
    public static function tableName()
    {
        return 'forum_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forum_topic_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at','user_id'], 'required'],
            [['text'], 'string'],
            [['forum_topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ForumTopic::className(), 'targetAttribute' => ['forum_topic_id' => 'id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumTopic()
    {
        return $this->hasOne(ForumTopic::className(), ['id' => 'forum_topic_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
