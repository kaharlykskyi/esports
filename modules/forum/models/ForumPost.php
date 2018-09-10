<?php

namespace app\modules\forum\models;

use Yii;

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
            [['forum_topic_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['forum_topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ForumTopic::className(), 'targetAttribute' => ['forum_topic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forum_topic_id' => 'Forum Topic ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumTopic()
    {
        return $this->hasOne(ForumTopic::className(), ['id' => 'forum_topic_id']);
    }
}
