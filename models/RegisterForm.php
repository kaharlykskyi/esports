<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $email;
    public $password;
    public $name;
    public $username;
    public $country;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'email', 'name', 'username', 'country'], 'required'],
            [['username'], 'unique', 'targetAttribute' => 'username', 'targetClass' => '\app\models\User', 'message' => 'This username can not be taken.'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\User', 'message' => 'Email already registered.'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'The email or password you entered is incorrect.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $user = User::register($this);
        if($user) {
            return $user;
        }
        return null;
    }
}
