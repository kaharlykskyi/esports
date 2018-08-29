<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_cup_team".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $team_id
 * @property string $name
 * @property int $tur
 * @property int $position
 *
 * @property Tournaments $tournament
 * @property Teams $team
 */
class TournamentCupTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tournament_cup_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'team_id', 'tur', 'position'], 'integer'],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
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
            'team_id' => 'Team ID',
            'tur' => 'Tur',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public static function getTurs($id)
    {
        $tur = (new \yii\db\Query())->select(['*'])->from('tournament_cup_team')
            ->andWhere(['tournament_id' => $id])->all();
        $arry_tur = [];

        foreach ($tur as $value) {
           $arry_tur[$value['tur']][] = $value;
        }
        return $arry_tur;
    }
}
