<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $bacgraund
 * @property int $game_id
 * @property string $website
 * @property string $captain
 *
 * @property Games $game
 * @property UserTeam[] $userTeams
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logo', 'bacgraund', 'captain'], 'required'],
            [['game_id'], 'integer'],
            [['name', 'logo', 'bacgraund', 'website', 'captain'], 'string', 'max' => 200],
            [['name'], 'unique'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'logo' => 'Logo',
            'bacgraund' => 'Bacgraund',
            'game_id' => 'Game ID',
            'website' => 'Website',
            'captain' => 'Captain',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['id_team' => 'id']);
    }
}
