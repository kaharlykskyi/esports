<?php

namespace app\modules\forum\models;

use Yii;
use app\models\ScheduleTeams;
use app\models\User;
/**
 * This is the model class for table "schedule_post".
 *
 * @property int $id
 * @property int $schedule_teams_id
 * @property int $user_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ScheduleTeams $scheduleTeams
 * @property Users $user
 */
class SchedulePost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schedule_teams_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['schedule_teams_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleTeams::className(), 'targetAttribute' => ['schedule_teams_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schedule_teams_id' => 'Schedule Teams ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleTeams()
    {
        return $this->hasOne(ScheduleTeams::className(), ['id' => 'schedule_teams_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
