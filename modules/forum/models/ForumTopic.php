<?php

namespace app\modules\forum\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\Tournaments;

class ForumTopic extends \yii\db\ActiveRecord
{
    
    public function behaviors()
    {
        return [
            TimeStampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'forum_topic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'name' => 'Name Topic',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

 
    public function getForumPosts()
    {
        return $this->hasMany(ForumPost::className(), ['forum_topic_id' => 'id']);
    }

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public function countPost()
    {
        return ForumPost::find()->where(['forum_topic_id' => $this->id])->count();
    }
}
