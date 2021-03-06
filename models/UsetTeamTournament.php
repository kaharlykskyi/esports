<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

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

    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function seveMembersTournament($uset_team_tournament,$tournament,$team ,$message = true)
    {
        foreach ($uset_team_tournament as $value) {
           $model = new self();
           $model->tournament_id = $tournament->id;
           $model->team_id = $team->id;
           $model->user_id = $value;
           $model->save();
        }
        if ($message) {
            $this->getMembersTournament($tournament,$team);
        }
    }

    public function getMembersTournament($tournament,$team)
    {
        $users = self::find()->select('user_id')
            ->where(['tournament_id' => $tournament->id,'team_id' => $team->id]);
        $members = User::find()->where(['in','id',$users])->all();
        $url = Url::toRoute(['tournaments/public','id' => $tournament->id], true);
        $a_api_hearstone = '';
        if ($tournament->game_id < 4) {
            $url = Url::toRoute(['api-string','id' => $tournament->id], true);
            $a_api_hearstone ='<a href="'.$url.'">'.$url.'</a>' ;
        }

        foreach ($members as $member) {
            $text_meesage = '<p><b>'.$team->capitans->name.'</b>'.
                Yii::t('app','chose you to participate in tournament').
                ' <a href="'.$url.'" >'.$tournament->name.'</a></p>';
            Yii::$app->mailer->compose()
                ->setFrom([
                    Yii::$app->params['adminEmail'] => 
                    Yii::t('app','Participation in the tournament').' '.$tournament->name])
                ->setTo([$member->email])
                ->setSubject(Yii::t('app','Participation in the tournament'))
                ->setTextBody(Yii::t('app','Participation in the tournament'))
                ->setHtmlBody($text_meesage)
                ->send();
            (new MessageUser())
                ->writeTitle(Yii::t('app','You have been chosen to participate in the tournament'))
                ->writeMessage($team->capitans->id,$member->id,$text_meesage.$a_api_hearstone);   
        }   
    }



}
