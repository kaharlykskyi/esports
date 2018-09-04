<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
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
            [['sex','favorite_game'],'number'],
            ['visible', 'boolean',],
            [['username','name',  'birthday','activities','interests'], 'string'],
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
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

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {

    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
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
            ->setSubject('Email recovery')
            ->setTextBody("You can change your password by clicking on the button below. \n $link")
            ->setHtmlBody("<p>You can change your password by clicking on the link below.</p><p>$link</p>");
        if($mail->send()) {
            return [
                'status' => true,
                'message' => "Recovery email was successfully send to $email. <br> Please check your inbox!"
            ];
        }
    }

    public function getMessageTeams(){
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
}
