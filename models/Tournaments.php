<?php

namespace app\models;

use yii\helpers\Html;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use app\models\servises\FairPlay;
use app\models\systems\SwissSystem;
use app\models\systems\LeagueSystem;
use app\models\systems\LeaguePSystem;
use app\models\systems\CupSystem;
use app\models\systems\DCupSystem;
use app\models\systems\LeagueGSystem;
use app\models\events\TournamentEvent;
use yii\db\Expression;


class Tournaments extends \yii\db\ActiveRecord
{
    use \app\models\traits\ScheduleCup;
    use \app\models\traits\Schedule;
    
    const SINGLE_E = 1;
    const DUBLE_E = 2;
    const LEAGUE = 3;
    const LEAGUE_P = 4;
    const LEAGUE_G = 5;
    const SWISS = 6;

    const USERS = 1;
    const TEAMS = 2;
    const MIXED = 3;

    const STARTED = 1;
    const FINISHED = 2;
    
    const PRIVATE_T = 1;

    public $system;
    public $banner_file;
    public $banner_default = '/images/tournaments/logo.png';

    public function behaviors()
    {
        return [
             TimeStampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'tournaments';
    }

    public function rules()
    {
        return [
            [
                [
                    'game_id', 'format','flag','time_limit', 'rank', 
                    'match_schedule','user_id','league_p','league_g',
                    'state','max_players', 'private','prize_pool', 'winner'
                ], 'integer'
            ],
            [['format', 'rules', 'prizes', 'start_date','name','game_id'], 'required'],
            [['rules', 'prizes','name','banner'], 'string'],
            [['start_date','region','data','cup','league_table','forum_text'], 'safe'],
            [['name'], 'unique'],
            [
                ['game_id'], 'exist',
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
            'name' => Yii::t('app','Name of the tournament'),
            'game_id' => Yii::t('app','Select the tournament game'),
            'format' => Yii::t('app','Tournament format'),
            'rules' => Yii::t('app','Rules of the tournament'),
            'prizes' => Yii::t('app','Tournament prizes'),
            'start_date' => Yii::t('app','Tournament start date'),
            'prize_pool' => Yii::t('app','Prize pool').' $',
            'banner' => Yii::t('app','Tournament logo'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->banner_file = UploadedFile::getInstance($this,'banner_file');
        if (is_object($this->banner_file)) {
            $now_name = time();
            $path = \Yii::getAlias('@webroot').'/images/tournaments/'.$this->id.'/'; 
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }    
            $this->banner_file->saveAs($path.$now_name.'.'.$this->banner_file->extension);
            $this->resizeImg($path.$now_name.'.'.$this->banner_file->extension);
            $this->banner = '/images/tournaments/'.$this->id.'/'.$now_name.'.'.$this->banner_file->extension;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert){
            TournamentEvent::creationTournamen($this);
        } else {
            if ($this->state == self::FINISHED && $this->winner) {
                TournamentEvent::played($this);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind ()
    {
        parent::afterFind();
        switch( $this->format ) {
            case self::LEAGUE:
                $this->system = new LeagueSystem($this);
                break;
            case self::LEAGUE_P:
                $this->system = new LeaguePSystem($this);
                break;
            case self::LEAGUE_G:
                $this->system = new LeagueGSystem($this);
                break;
            case self::SWISS:
                $this->system = new SwissSystem($this);
                break;
            case self::SINGLE_E:
                $this->system = new CupSystem($this);
                break;
            case self::DUBLE_E:
                $this->system = new DCupSystem($this);
                break;
        }
    }

    public function getLogo()
    {
        return $this->banner ?? $this->banner_default;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    public function getTournamentTeam()
    {
        return $this->hasMany(TournamentTeam::className(), ['tournament_id' => 'id']);
    }

    public function getTournamentUser()
    {
        return $this->hasMany(TournamentUser::className(), ['tournament_id' => 'id']);
    }

    public function getMatches()
    {
        return $this->hasMany(ScheduleTeams::className(), ['tournament_id' => 'id']);
    }

    public function getUset_team_tournament()
    {
        return $this->hasMany(UsetTeamTournament::className(), ['tournament_id' => 'id']);
    }

    public function getSummBal()
    {
        return $this->hasMany(BallMatch::className(), ['tournament_id' => 'id'])
            ->joinWith('team')->orderBy(['summ_ball' => SORT_DESC, 'lost' => SORT_ASC]);
    }

    public function generateForm () 
    {

        if (!empty($this->id)) {

            $fileds = json_decode($this->game->filed);
            $data = $this->data !== '' ? json_decode($this->data) : [];
            if(!is_null($this->game->filed)){
                $result="";

                foreach ($fileds as $filed) {
                    $class = "";
                    if (!empty($filed->class)){
                        $class = $filed->class;
                    }
                    $value = !empty($data->{$filed->name}) ? $data->{$filed->name} : null;

                    if ($filed->type =='number') {
                        
                        $result .= '<div class="conteiner_filed '.$class.'" ><label class="col-sm-12" >'
                        . $filed->title .'</label>'. Html::input('number', "Data[{$filed->name}]",$value, 
                            ['class' => false,'min'=>"1" ,'max'=>"30"]) .'</div>';

                    } elseif ($filed->type === 'select') {

                        $options = [];
                        foreach($filed->options as $option){
                            $options[$option] = $option;
                        }

                        $result .= '<div class="conteiner_filed '.$class.'" >
                             <label class="control-label col-md-12" >'. $filed->title .
                            '</label><div class="item select-show"><select name="Data['.$filed->name.']" class="basic" >'
                            . Html::renderSelectOptions($value, $options) .'</select></div></div>';

                    } elseif ($filed->type === 'checkbox') {
                        $options = "<input type='hidden' name='Data[{$filed->name}]' value='0'>";
                        $options .= Html::checkbox(
                            "Data[{$filed->name}]", 
                            !empty($value), 
                            [
                                'id' => $filed->name,
                                'value' => '1' ,
                                'class' =>'filter-check '.$class
                        ]);
                        $options .= "<label for='{$filed->name}'>
                               <span style='font-size: 18px;position: relative;bottom: 5px;'>{$filed->title}</span>
                               </label>";
                        $result .= "<div class='checkbox conteiner_filed' >{$options}'</div>";
                    }  elseif ($filed->type === 'input') {
                        $result .= '<div class="conteiner_filed '.$class.'" ><label class="col-sm-12" >'
                        . $filed->title .'</label>'. Html::input('text', "Data[{$filed->name}]",$value, 
                            ['class' => false]) .'</div>';
                    }
                }
                return $result;
            }
        }
    }

    public function getPlayers()
    {
        $teams = Teams::find()->select(['teams.*'])
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where([
                'tournament_team.status' => TournamentTeam::ACCEPTED,
                'tournament_team.tournament_id' => $this->id
            ])->all();
        return $teams;
    }

    public function isCapitanTeam($id)
    {
        $models = $this->getTournamentTeam()
            ->select('team_id')->where(['status' => TournamentTeam::ACCEPTED]);
        $team = Teams::find()->where(['and',
            ['in', 'id', $models],
            ['capitan' => $id],
            ['is', 'single_user', new Expression('null')]
        ])->one();

        if (is_null($team)) {
            return false;
        }
        return true;
    }

    public function isPlayerTeam($id)
    {
        $models = UsetTeamTournament::find()
            ->where(['user_id' => $id,'tournament_id' => $this->id])->one();
        if (is_null($models)) {
            return false;
        }
        return true;
    }

    public function getPlayersTeams () 
    {
        return UsetTeamTournament::find()
            ->with('team','user')
            ->where(['tournament_id' => $this->id])->orderBy('team_id')->all();
    }

    public function getPlayersTeam ($id) 
    {
        $models = $this->getTournamentTeam()->select('team_id')->where(['status' => TournamentTeam::ACCEPTED]);
        $team = Teams::find()->where(['in','id',$models])->andWhere(['capitan' => $id])->one();
        if (is_object($team)) {
            return UsetTeamTournament::find()->with('team','user')
                ->where(['team_id'=>$team->id,'tournament_id' => $this->id])->all();
        }
        return [];
    }

    public function getPlayer ($id) 
    {
        return UsetTeamTournament::find()->with('team','user')
            ->where(['user_id'=>$id,'tournament_id' => $this->id])->one();
    }

    public function getMatchesResult()
    {
        return $this->getMatches()->with('teamS','teamF')
            ->where('UNIX_TIMESTAMP(date)<UNIX_TIMESTAMP()')
            ->andWhere(['active_result' => null])
            ->all();
    }

    public function getCups()
    {
        return $this->user->cup;
    }

    public function rank()
    {
        return $this->rank;
    }

    private function resizeImg ($pathFile)
    {
        $image = \Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('300', '100', \yii\image\drivers\Image::INVERSE);
        $image->crop('300','100');
        $image->save($pathFile);
    }

    public function getMatchNext()
    {
        return $this->hasOne(
            ScheduleTeams::className(), 
            ['tournament_id' => 'id']
        )->where(['>','date', date('Y-m-d')]);
    }

    public function getRequestUser()
    {
        return $this->getTournamentUser()
            ->joinWith('user')
            ->where([
                '!=', 'status', TournamentUser::ACCEPTED
            ])->all();
    }

    public function getRequestTeam()
    {
        return $this->getTournamentTeam()
            ->joinWith('team')
            ->where([
                '!=', 'status', TournamentTeam::ACCEPTED
            ])->all();
    }

    public function isRequestUser(int $id)
    {
        $tour_user = $this->getTournamentUser()->where([
                'user_id' => $id
            ])->one();
        if (is_object($tour_user)) {
            return $tour_user->status;
        }
        return false;
    }

    public function isRequestTeam(int $id, int $team_id = null) {

        $not_teams = $this->getUset_team_tournament()->select('team_id')->groupBy('team_id');

        $sql_user_team = "(select count(*) from user_team as ut
                       INNER JOIN users ON ut.id_user = users.id
                       where user_team.id_team = teams.id 
                       and (users.ban_date is NULL or users.ban_date < CURDATE()) 
                       and users.fair_play > 79 
                       and ut.status = 2 )";
        $team = Teams::find()->joinWith('userTeams')->where(['and',
            ['teams.capitan' => $id],
            ['teams.game_id' => $this->game_id],
            ['not in','teams.id', $not_teams],
            ['>=', $sql_user_team, $this->max_players],
        ])->one();

        if (is_object($team)) {
            return $team;
        }
        return false;
        
    }

    public function isUserInTournament ($id)
    {
        $users = $this->getUset_team_tournament()
            ->select('user_id')->asArray()->all();
        if (in_array($id, $users)) {
            return true;
        }
        return false;
    }

    public function isUserInTournamentTeam(Teams $team)
    {
        $users_tour = $this->getUset_team_tournament()
            ->select('user_id')->asArray()->all();
        $users_team = $team->getMembers();
        $result = false;
        foreach ($users_team as $user) {
            if (in_array($user->id, $users_tour)) {
               $result = true;
            }
        }
        return $result;
    }

    public function isUserCountInTeam(Teams $team)
    {
        $users_team = $team->getMembers();
        $count_user = 0;
        foreach ($users_team as $user) {
            if (!$user->isBaned() && $user->fair_play > 79) {
              $count_user++;
            }
        }
        if ($this->max_players > $count_user) {
           return false;
        }
        return true;
    }
    

}

