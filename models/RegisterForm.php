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
            [['username'], 'unique', 'targetAttribute' => 'username', 'targetClass' => '\app\models\User', 'message' => 'This username can not be taken.'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\User', 'message' => 'Email already registered.'],
        ];
    }

  
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app','The email or password you entered is incorrect.'));
            }
        }
    }

    public function register()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
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
