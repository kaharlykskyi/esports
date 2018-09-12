<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule_teams".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $team1
 * @property int $team2
 * @property int $results1
 * @property int $results2
 * @property int $tur
 * @property int $group
 * @property string $date
 *
 * @property Teams $team10
 * @property Teams $team20
 * @property Tournaments $tournament
 */
class ScheduleTeams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule_teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'team1', 'team2', 'results1', 'results2', 'tur', 'group','format'], 'integer'],
            [['date'], 'safe'],
            [['team1'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team1' => 'id']],
            [['team2'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team2' => 'id']],
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
            'team1' => 'Team1',
            'team2' => 'Team2',
            'results1' => 'Results1',
            'results2' => 'Results2',
            'tur' => 'Tur',
            'group' => 'Group',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam10()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam20()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }
}
