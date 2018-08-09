<?php

namespace app\models;

use Yii;
use  yii\behaviors\TimeStampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $background
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
    public $file;
    public $file1; 

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

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
            [['name', 'capitan'], 'required'],
            [['game_id','capitan'], 'integer'],
            [['file', 'file1'],'file','skipOnEmpty' => false,
                'when' => function($model) { return !isset($model->id);},
                'whenClient' => "function (attribute, value) {
                    return !$('#game_idf').val();
                }"
            ],
            [['name', 'website' ], 'string', 'max' => 200],
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
            'name' => 'Team name',
            'file' => 'Team logo',
            'file1' => 'Background',
            'game_id' => 'Game',
            'website' => 'Website URL',
            'capitan' => 'Capitan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    public function getCapitan()
    {
        return $this->hasOne(User::className(), ['id' => 'capitan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['id_team' => 'id']);
    }

    public function coutUsers()
    {
        $count = $this->getUserTeams()
        ->where(['user_team.status'=> UserTeam::ACCEPTED])->count();
        return $count;
    }

    public static function getTeamsThisUser()
    {
        $teams = [];
        $count_teams = 0;
        $userteams =Yii::$app->user->identity->getUserteams()
        ->where(['user_team.status'=> UserTeam::ACCEPTED])->all();
        foreach ($userteams as  $value) {
           $count_teams++; 
           $teams[] = $value['id_team'];
        }
        $teams = self::find()->where(['in', 'id', $teams])->all();
        $count_games = Games::find()->count();
        $btn = $count_games-$count_teams;
        return compact('teams','count_teams','btn');
    }

    public static function getInviteEmailHtml($a, $user, $team, $capitanEmail)
    {
        return "<p>Hello {$user->name},
                </p><p>The <b>{$team->name}</b> team invites you to become part of its players. To <b>accept</b> or <b>decline</b> the invitation click the link below: </p>
                <p><a href='$a'>$a</a></p><p>Finally, if you want more information, contact <b>{$team->name}</b> through their website, or through their captain, by email {$capitanEmail}.</p>
                <p>We hope you enjoy competing in our tournaments.</p>
                <p>Sincerely.</p>
                <p>The organization.</p>";
    }

    public function getMembers()
    {
        $ids = ArrayHelper::getColumn(UserTeam::find()->where(['id_team' => $this->id, 'status' => UserTeam::ACCEPTED])->asArray()->all(), 'id_user');
        return User::find()->where(['in', 'id', $ids])->all();
    }
}
