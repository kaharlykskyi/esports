<?php

namespace app\modules\forum\models;

use Yii;

use yii\behaviors\TimestampBehavior;

class ForumPostSchedule extends \yii\db\ActiveRecord
{
   

    public function behaviors()
    {
        return [
            TimeStampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'forum_post_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['forum_topic_schedule_id'], 'string', 'max' => 250],
            [['name'], 'string', 'max' => 200],
            [['forum_topic_schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => ForumTopicSchedule::className(), 'targetAttribute' => ['forum_topic_schedule_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forum_topic_schedule_id' => 'Forum Topic Schedule ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumTopicSchedule()
    {
        return $this->hasOne(ForumTopicSchedule::className(), ['id' => 'forum_topic_schedule_id']);
    }
}
