<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\servises\UserServis;
use dosamigos\transliterator\TransliteratorHelper;
use app\models\points\TeamPoint;



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
            [['name', 'website', 'slug'], 'string', 'max' => 200],
            ['name', 'filter', 'filter'=>'trim'],
            ['slug', 'filter', 
               'filter' => function($model) {
                   return mb_strtolower(str_replace(' ', '-', TransliteratorHelper::process(($this->name))));
             }],
            [['name', 'slug'], 'unique'],
            [['game_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Games::className(), 
                'targetAttribute' => ['game_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app','Team name'),
            'file' => Yii::t('app','Team logo'),
            'file1' => Yii::t('app','Background'),
            'game_id' => Yii::t('app','Game'),
            'website' => Yii::t('app','Website URL'),
            'capitan' => Yii::t('app','Capitan'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if (!$this->single_user) {
                TeamPoint::createTeam ($this);
            }
        }
        parent::afterSave($insert, $changedAttributes);
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

    public function getSponsors()
    {
        return $this->hasMany(SponsorTeam::className(), ['team_id' => 'id']);
    }

    public function getTournamentTeams()
    {
        return $this->hasMany(TournamentTeam::className(), ['team_id' => 'id']);
    }

    public function getTournamentTeam(int $id)
    {
        return $this->hasMany(TournamentTeam::className(), ['team_id' => 'id'])
            ->where(['tournament_id' => $id]);
    }

    public function getHistory()
    {
        return $this->hasMany(TeamHistory::className(), ['team_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
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
            return "/teams/{$this->slug}";
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

    public function name()
    {
        if (is_null($this->single_user)) {
            return $this->name;
        }
        return $this->capitans->name;
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
        return Yii::t('app','<p>Hello {user_name},</p><p>The <b>{team_name}</b> team invites you to become part of its players. To <b>accept</b> or <b>decline</b> the invitation click the link below: </p>
            <p> <a href="{link}" > Click linkc </a> </p>
            <p>Finally, if you want more information, contact <b>{team_name}</b> through their website, or through their captain, by email {email}.</p><p>We hope you enjoy competing in our tournaments.</p><p>Sincerely.</p><p>The organization.</p>',
                [
                    'user_name'=> $user->name,
                    'team_name'=> $team->name,
                    'email' => $capitanEmail,
                    'link' => $a,
                ]
            );
    }

    public static function sentDeleteHtml($a, $user, $team)
    {
        return Yii::t('app','<p>Team captain {user_name},</p><p>I ask to remove a command <b>{team_name}</b></p><p>To delete or cancel, follow the link   <a href="{link}">{link}</a></p><p>You can write a letter to the captain of the team <b>{team_name}</b> his mail  {email}.</p><p>The capitan.</p>',
                [
                    'user_name'=> $user->name,
                    'team_name'=> $team->name,
                    'email' => $user->email,
                    'link' => $a,
                ]
            );
    }

    public function getMembers()
    {
        $ids = ArrayHelper::getColumn(UserTeam::find()->where([
            'id_team' => $this->id, 
            'status' => UserTeam::ACCEPTED
        ])->asArray()->all(), 'id_user');
        return User::find()->with('statisticAll')->where(['in', 'id', $ids])->all();
    }

    public function dummyTeam($tournament,$user)
    {
        $model = self::findOne(['capitan'=>$user->id,'game_id'=>$tournament->game_id,'single_user' => 1]);
        if (!is_object($model)) {
            $this->name = $user->name.'@'.$tournament->game->alias;
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
            if(($tournament->game_id==1)||($tournament->game_id==2)||($tournament->game_id==3)) {
                (new UsetTeamTournament)->seveMembersTournament([$user->id],$tournament,$model,false);
                $url ='<a href="'.Url::toRoute(['api-string','id' => $tournament->id], true).'">link</a>' ;
                $text_meesage = "<p> ".Yii::t('app','To participate in the tournament, enter the data')." {$url} </p>";
            } else {
                $text_meesage = "<p> ".Yii::t('app','You took part in the tournament')." <a  href='/tournaments/public/{$tournament->id}' >link</a> </p>";
            }

            $message_config = new MessageUser();
            $message_config->writeTitle(Yii::t('app','You are participating in a tournament.'))
                ->writeType(MessageUser::TOURNAMENT)
                ->writeMessage($tournament->user_id,$user->id,$text_meesage);
        } else {
            return false;
        }
        return true;
    }

    public function isCapitan  ($user_id) 
    {
        if ($user_id == $this->capitan) {
            return true;
        }
        return false;
    }
}
