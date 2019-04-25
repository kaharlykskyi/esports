<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Yii;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $file_logo;
    public $file_background;
    public $appraisal;

    const NOT = 0;
    const NORMAL = 1;
    const GOOD  = 2;
    const GREAT = 3;
    const EPIC = 4;
    const LEGENDARY = 5;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['name','email'], 'required'],
            [['name','email'], 'unique'],
            ['email','email'],
            ['ban_date', 'safe'],
            [['sex','favorite_game','fair_play','system_ball'],'number'],
            ['visible', 'boolean',],
            [['username','name',  'birthday','activities','interests','logo','background'], 'string'],
            [['activities','interests','username','name'], 
                'filter', 'filter' => 'strip_tags'
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->file_logo = UploadedFile::getInstance($this,'file_logo');
        if (is_object($this->file_logo)) {
            $now_name = 'logo'.time();
            $path = \Yii::getAlias('@webroot').'/images/users/'.$this->id.'/'; 
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }    
            $this->file_logo->saveAs($path.$now_name.'.'.$this->file_logo->extension);
            $this->resizeImg($path.$now_name.'.'.$this->file_logo->extension);
            $this->logo = '/images/users/'.$this->id.'/'.$now_name.'.'.$this->file_logo->extension;
        }

        $this->file_background = UploadedFile::getInstance($this,'file_background');
        if (is_object($this->file_background)) {
            $now_name = 'background'.time();
            $path = \Yii::getAlias('@webroot').'/images/users/'.$this->id.'/'; 
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }  
            $this->file_background->saveAs($path.$now_name.'.'.$this->file_background->extension);
            $this->background = '/images/users/'.$this->id.'/'.$now_name.'.'.$this->file_background->extension;
        }

        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByEmail($email)
    {
        $user = User::find()->where(['email' => $email])->limit(1)->one();
        if(!$user) {
            return false;
        }
        return $user;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function register($model)
    {
        $user = new self();
        $user->name = $model->name;
        $user->username = $model->username;
        $user->email = $model->email;
        $user->country = $model->country;
        $user->password = \Yii::$app->getSecurity()->generatePasswordHash($model->password);
        if($user->save()) {
            return $user;
        }
        return false;
    }

    public static function emailRecovery($email)
    {
        $user = self::findOne(['email' => $email]);
        if(!$user) {
            return [
                'status' => false,
                'message' => 'Email not registered'
            ];
        }
        $user->restore_token = bin2hex(random_bytes(24));
        if(!$user->save()) {
            return [
                'status' => false,
                'message' => 'Can not save user'
            ];
        }

        $link = Url::base(true) . "/recovery-check?token={$user->restore_token}";
        $mail = \Yii::$app->mailer->compose()
            ->setFrom([\Yii::$app->params['adminEmail'] => "Bumeen Group Dev"])
            ->setTo($email)
            ->setSubject(Yii::t('app','Email recovery'))
            ->setTextBody(Yii::t('app','You can change your password by clicking on the button below.')." \n $link")
            ->setHtmlBody("<p>".Yii::t('app','You can change your password by clicking on the button below.')."</p><p>$link</p>");
        if($mail->send()) {
            return [
                'status' => true,
                'message' => Yii::t('app',
                    'Recovery email was successfully send to {email}. <br> Please check your inbox!',
                    ['email'=>$email]
                )
            ];
        }
    }

    public function getMessageTeams() {
        $team = (new \yii\db\Query())
        ->select(['teams.*' ,'user_team.status_tokin','users.name as u_name','users.email as u_email'])
        ->from('teams')->leftJoin('user_team', 'user_team.id_team = teams.id')
        ->leftJoin('users', 'users.id = teams.capitan')
        ->where(['user_team.status' => UserTeam::SENT])
        ->andWhere(['user_team.id_user' => $this->id])->all();
        return $team;
    }

    public function getUserteams()
    {
        return $this->hasMany(UserTeam::className(), ['id_user' => 'id']);
    }

    public function getTeams()
    {
        return $this->hasMany(Teams::className(), ['capitan' => 'id']);
    }

    public function getEventUser()
    {
        return $this->hasMany(EventUser::className(), ['user_id' => 'id']);
    }

    public function getGameF()
    {
        return $this->hasOne(Games::className(), ['id' => 'favorite_game']);
    }

    public function getUserGameApi()
    {
        return $this->hasOne(UserGameApi::className(), ['user_id' => 'id']);
    }

    public function getSocial_links() 
    {
        return $this->hasMany(SocialLinks::className(), ['user_id' => 'id']);
    }
    
    public function getMessages()
    {
        return $this->hasMany(MessageUser::className(), ['recipient' => 'id']);
    }

    public function getStatisticAll()
    {
        return $this->hasMany(ResultsStatisticUsers::className(), ['user_id' => 'id']);
    }

    public function StatisticTeam($team)
    {
        $statistic = $this->statisticAll;
        if (!empty($statistic)) {
            foreach ( $statistic as $model) {
                if($model->team_id == $team) {
                    return $model;
                }
            }
        }
        return new class { public $loss = 0; public $victories = 0; public $rate = 0;};
    }


    public function getInvitationUser()
    {
        return $this->hasMany(TournamentUser::className(), ['user_id' => 'id'])
            ->where(['status'=>TournamentUser::SENT])
            ->orderBy('id');
    }

    private function resizeImg ($pathFile)
    {
        $image = \Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('400', '400', \yii\image\drivers\Image::INVERSE);
        $image->crop('400','400');
        $image->save($pathFile);
    }

    public function avatar()
    {
        return $this->logo ?? '/images/profile/user_man.jpg';
    }

    public function background()
    {
        return $this->background ?? '/images/profile/images.jpg';
    }

    public function addBall($bonus_id,$cup = false)
    {
        if (is_numeric($bonus_id)){
            UserPoint::addBall($bonus_id,$this->id,$cup);
        }
    }

    public function getBall() 
    {   
        if (is_numeric($this->appraisal)) {
            return $this->appraisal;
        }
        $appraisal = (new \yii\db\Query())
           ->select(['sum(appraisal) as ball'])
           ->from('user_point')
           ->where(['user_id' => $this->id])->one();

        if (is_numeric($appraisal['ball'])) {
            $this->appraisal = $appraisal['ball'];
            return $this->appraisal;
        }
        $this->appraisal = 0;
        return 0;
    }

    public function getCup() 
    {
        if ($this->rank() == self::LEGENDARY ) {  
            $awards_text = Yii::t('app','Legendary cup');
            $cup_awards = '<img src="/images/profile/cup/legendary.svg" alt="legendary">';
        } elseif ($this->rank() == self::NORMAL ) {
            $awards_text = 'Normal cup';
            $cup_awards = '<img src="/images/profile/cup/normal.svg" >';
        } elseif ($this->rank() == self::EPIC ) {
            $awards_text = Yii::t('app','Epic cup');
            $cup_awards = '<img src="/images/profile/cup/epic.svg" alt="epic">';
        } elseif ($this->rank() == self::GOOD  ) {
            $awards_text = 'Good cup';
            $cup_awards = '<img src="/images/profile/cup/good.svg" alt="go0d">';
        } elseif ($this->rank() == self::GREAT ) {
            $awards_text = 'Great cup';
            $cup_awards = '<img src="/images/profile/cup/great.svg" alt="great">';
        } else {
            $awards_text = "";
            $cup_awards = "";
        }

        return [$awards_text,$cup_awards];
    }

    public function rank()
    {
        if ($this->role == self::LEGENDARY ){
            return self::LEGENDARY;
        } elseif ($this->ball < 7000) {
            return self::NOT;
        } elseif($this->ball < 16000){
            return self::NORMAL;
        } elseif($this->ball < 48000) {
            return self::GOOD;
        } elseif($this->ball < 100000) {
            return self::GREAT;
        }  elseif($this->ball > 99000) {
            return self::EPIC;
        } 

        //CONST LEGENDARY = 5;
    }

    public function persentLian()
    {
        $rank = $this->rank();
        $start_persent = $rank * 20;
        $plus_persent = 0;
        switch ($rank) {
            case self::NOT:
                $plus_persent = 20/7000*($this->ball);
                break;
            case self::NORMAL:
                $plus_persent = 20/9000*($this->ball-7000);
                break;
            case self::GOOD:
                $plus_persent = 20/32000*($this->ball-16000);
                break;
            case self::GREAT:
                $plus_persent = 20/52000*($this->ball-48000);
                break;
            case self::EPIC:
                $plus_persent = 20/152000*($this->ball-100000);
                break;
        }
        $result = $start_persent + $plus_persent;
        if ($result > 100) {
            $result == 100;
        }
        return  $result;
    }

    public function setBan($day_ban)
    {
        $ban_do = date("Y-m-d", strtotime("+{$day_ban} days"));
        $this->ban_date = $ban_do;
        return $this;
    }

    public function isBaned ()
    {
        if (!is_numeric(strtotime($this->ban_date))) {
            return false;
        }
        if (strtotime($this->ban_date)>strtotime(date('Y-m-d'))) {
            return true;
        }
        return false;
    }

    public function ratingOwervatch ()
    {
        $usapi = $this->userGameApi;
        if (!is_object($usapi)) {
            $usapi = new UserGameApi();
        }
        return $usapi->rating;
    }

}
