<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;



class Admin extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'admins';
    }

    public function rules()
    {
        return [
            [['login','password'], 'required'],
            [['login'], 'unique'],
            [['login','username','password'], 'string'],
        ];
    }

    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByAdmin($login)
    {
        return static::findOne(['login' => $login]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        $a;
    }
 
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}