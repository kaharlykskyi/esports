<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "uset_team_tournament".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $team_id
 * @property int $user_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Tournaments $tournament
 * @property Teams $team
 * @property Users $user
 */
class UsetTeamTournament extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'uset_team_tournament';
    }


    public function behaviors()
    {
        return [
             TimeStampBehavior::className(),
        ];
    }


    public function rules()
    {
        return [
            [['tournament_id', 'team_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['tournament_id', 'team_id', 'user_id'], 'required'],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'team_id' => 'Team ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    public function seveMembersTournament($uset_team_tournament,$tournament,$team)
    {
        foreach ($uset_team_tournament as $value) {
           $model = new self();
           $model->tournament_id = $tournament->id;
           $model->team_id = $team->id;
           $model->user_id = $value;
           $model->save();
        }
        $this->getMembersTournament($tournament,$team);
    }

    public function getMembersTournament($tournament,$team)
    {
        $users = self::find()->select('user_id')->where(['tournament_id' => $tournament->id,'team_id' => $team->id]);//->asArray()->all();
        $members = User::find()->where(['in','id',$users])->all();
        $url = Url::toRoute(['toutnaments/public','id' => $tournament->id], true);
        foreach ($members as $member) {
            $text_meesage = '<p><b>'.$team->capitans->name.'</b></a> chose you to participate in tournament
            <a href="'.$url.'" >'.$tournament->name.'</a><p>';
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => 'Participation in the tournament '.$tournament->name])
                ->setTo([$member->email])
                ->setSubject("Participation in the tournament")
                ->setTextBody("Participation in the tournament")
                ->setHtmlBody($text_meesage)
                ->send();
        }   
    }



}
