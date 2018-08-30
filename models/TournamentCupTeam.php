<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_cup_team".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $team_p
 * @property int $team_v
 * @property int $tur
 * @property int $position
 * @property int $result
 *
 * @property Teams $teamP
 * @property Teams $teamV
 * @property Tournaments $tournament
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
            [['tournament_id', 'team_p', 'team_v', 'tur', 'position', 'result'], 'integer'],
            [['team_p'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_p' => 'id']],
            [['team_v'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_v' => 'id']],
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
            'team_p' => 'Team P',
            'team_v' => 'Team V',
            'tur' => 'Tur',
            'position' => 'Position',
            'result' => 'Result',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamP()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_p']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamV()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_v']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public static function getTurs($id)
    {
        $tur = (new \yii\db\Query())->select(['tournament_cup_team.*','p.name as p_name','v.name as v_name'])->from('tournament_cup_team')
            ->innerJoin('teams as p', '`p`.`id` = `tournament_cup_team`.`team_p`')
            ->innerJoin('teams as v', '`v`.`id` = `tournament_cup_team`.`team_v`')
            ->andWhere(['tournament_id' => $id])->all();
        $arry_tur = [];

        foreach ($tur as $value) {
           $arry_tur[$value['tur']][$value['position']] = $value;
        }
        return $arry_tur;
    }

    public static function getTursto($id)
    {
        $tur = (new \yii\db\Query())->select(['tournament_cup_team.*','p.name as p_name','v.name as v_name'])->from('tournament_cup_team')
            ->innerJoin('teams as p', '`p`.`id` = `tournament_cup_team`.`team_p`')
            ->innerJoin('teams as v', '`v`.`id` = `tournament_cup_team`.`team_v`')
            ->andWhere(['tournament_id' => $id])->all();
        $arry_tur = [];

        foreach ($tur as $value) {
           $arry_tur['teams'][] = [$value['p_name'],$value['v_name']];
        }
        return $arry_tur;
    }
}
//SELECT * FROM (`test` INNER JOIN `teams` as `p` on `p`.`id`=`test`.`team_p`) INNER JOIN `teams` as `v` ON `v`.`id`=`test`.`team_v`