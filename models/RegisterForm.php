<?php

namespace app\models;

use Yii;
use yii\base\Model;


class RegisterForm extends Model
{
    public $email;
    public $password;
    public $name;
    public $username;
    public $country;

    private $_user = false;


    public function rules()
    {
        return [
            [['password', 'email', 'name', 'username', 'country'], 'required'],
            [['username'], 'unique', 
                'targetAttribute' => 'username', 
                'targetClass' => '\app\models\User', 
                'message' => 'This username can not be taken.'
            ],
            [['email'], 'unique', 
                'targetAttribute' => 'email', 
                'targetClass' => '\app\models\User', 
                'message' => 'Email already registered.'
            ],
        ];
    }

    public function register()
    {
        if ($this->validate() && ($user = $this->getUser())) {
            return Yii::$app->user->login($user);
        }
        return false;
    }

  
    public function getUser()
    {
        $user = User::register($this);
        if($user) {
            return $user;
        }
        return null;
    }
}
