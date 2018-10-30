<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\servises\UserServis;

class Teams extends \yii\db\ActiveRecord
{

    public $file;
    public $file1; 

    public function behaviors()
    {
        return [
            TimeStampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'teams';
    }

    public function rules()
    {
        return [
            [['name', 'capitan'], 'required'],
            [['game_id','capitan','single_user'], 'integer'],
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

    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    public function getCapitans()
    {
        return $this->hasOne(User::className(), ['id' => 'capitan']);
    }

    public function getStatistic()
    {
        return $this->hasOne(ResultsStatistics::className(), ['team_id' => 'id']);
    }

    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['id_team' => 'id']);
    }

    public function getMatces()
    {
        return ScheduleTeams::find()
            ->with(['teamS','teamF','tournament'])
            ->where(['team1' => $this->id])
            ->orWhere(['team2' => $this->id])
            ->orderBy(['id' => SORT_DESC])->limit(10)->all();
    }

    public function coutUsers()
    {
        $count = $this->getUserTeams()
        ->where(['user_team.status'=> UserTeam::ACCEPTED])->count();
        return $count;
    }

    public function links()
    {
        if (is_null($this->single_user)) {
            return "/teams/public/{$this->id}";
        }
        return "/user/public/{$this->capitans->id}";
    }

    public function logo()
    {
        if (is_null($this->single_user)) {
            return $this->logo;
        }
        return $this->capitans->avatar();
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

    public static function sentDeleteHtml($a, $user, $team)
    {
        return "<p>Team captain {$user->name},
                </p><p>I ask to remove a command <b>{$team->name}</b></p>
                <p>To delete or cancel, follow the link   <a href='$a'>$a</a></p>
                <p>You can write a letter to the captain of the team <b>{$team->name}</b> his mail  {$user->email}.</p>
                <p>The capitan.</p>";
    }

    public function getMembers()
    {
        $ids = ArrayHelper::getColumn(UserTeam::find()->where(['id_team' => $this->id, 'status' => UserTeam::ACCEPTED])->asArray()->all(), 'id_user');
        return User::find()->with('statisticAll')->where(['in', 'id', $ids])->all();
    }


    public function dummyTeam($tournament,$user)
    {
        $model = self::findOne(['capitan'=>$user->id,'game_id'=>$tournament->game_id,'single_user' => 1]);
        if (!is_object($model)) {
            $this->name = $user->name;
            $this->capitan = $user->id;
            $this->logo = '-----';
            $this->background = '-----';
            $this->game_id = $tournament->game_id;
            $this->single_user = 1;
            if (!$this->save(false)) {
                return false;
            }
            $model = $this;
        }

        $user_team = UserTeam::findOne(['id_user'=>$user->id,'id_team'=>$this->id]);
        if (!is_object($user_team)) {
            $user_team = new UserTeam();
            $user_team->id_user = $user->id;
            $user_team->id_team = $this->id;
            $user_team->status = UserTeam::DUMMY;
            $user_team->save(false);
        }


        $tournament_team = new TournamentTeam();
        $tournament_team->status = TournamentTeam::ACCEPTED;
        $tournament_team->tournament_id = $tournament->id;
        $tournament_team->team_id = $model->id;
        if ($tournament_team->save()) {
            if(($tournament->game_id==1)||($tournament->game_id==2)) {
                (new UsetTeamTournament)->seveMembersTournament([$user->id],$tournament,$model,false);
                $url ='<a href="'.Url::toRoute(['api-string','id' => $tournament->id], true).'">'.Url::toRoute(['api-string','id' => $tournament->id], true).'</a>' ;
                $text_meesage = "<p> To participate in the tournament, enter the data $url </p>";
            } else {
                $text_meesage = "<p> You took part in the tournament <a  href='/tournaments/public/$tournament->id' >$tournament->name</a> </p>";
            }

            $message_config = new MessageUser();
            $message_config->writeTitle('You are participating in a tournament.')
                ->writeMessage($tournament->user_id,$user->id,$text_meesage);
        } else {
            return false;
        }
        return true;
    }
}
