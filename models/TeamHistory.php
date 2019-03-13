<?php

namespace app\models;

use Yii;

class TeamHistory extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'team_history';
    }

    public function rules()
    {
        return [
            [['team_id'], 'integer'],
            [['event'], 'required'],
            [['event'], 'string'],
            [['created_at'], 'safe'],
            [
                ['team_id'], 
                'exist', 'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    public static function setHistory ($method, $object, $team_id)
    {
        $model = new self;
        if (!method_exists($model,$method)) {
            return false;
        }
        
        $model->team_id = $team_id;
        $model->event = $model->$method($object);
        $model->save(false);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'event' => 'Event',
            'created_at' => 'Created At',
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    private function textAddUser ( UserTeam $object )
    {
        return "<p><a href='/user/public/{$object->user->id}' >
                <img src='{$object->user->avatar()}' alt='player'></a>
                The team is accepted player <b>{$object->user->name}</b> <p>";
    }

    private function textDeletedUser ( UserTeam $object )
    {
        return "<p><a href='/user/public/{$object->user->id}' >
                <img src='{$object->user->avatar()}' alt='player'></a>
                Player out of team <b>{$object->user->name}</b> <p>";
    }

    private function victoryMatch ( ScheduleTeams $object )
    {
        return "<div class='matche-history' >
                <a href='/matches/public/{$object->id}' >
                <div><img src='{$object->teamF->logo()}' alt='player'>
                <span>{$object->teamF->name}</span></div>
                <img src='/images/tournaments/vs_dark.png'>
                <div><img src='{$object->teamS->logo()}' alt='player'>
                <span>{$object->teamS->name}</span></div></a>
                <span>Winning the match</span></div>";
    }

    private function loseMatch ( ScheduleTeams $object )
    {
        return "<div class='matche-history' >
                <a href='/matches/public/{$object->id}' >
                <div><img src='{$object->teamF->logo()}' alt='player'>
                <span>{$object->teamF->name}</span></div>
                <img src='/images/tournaments/vs_dark.png'>
                <div><img src='{$object->teamS->logo()}' alt='player'>
                <span>{$object->teamS->name}</span></div></a>
                <span>Losing the match</span></div>";
    }

    private function addTournament (TournamentTeam $object)
    {
        return "<div class='tournament-history' >
                <a href='/tournaments/public/{$object->tournament_id}' >
                <div><img src='{$object->tournament->getLogo()}' alt='player'>
                </div></a><div class='title-his'><p>Took part in the tournament</p>
                <a href='/tournaments/public/{$object->tournament_id}' >
                {$object->tournament->name}</a></div></div>";
    }
}
