<?php

namespace app\modules\cabinet\models;

use Yii;
use yii\base\Model;
use app\models\Users;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $mail;
    public $name;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    private $_mail = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [[ 'mail', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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
            $user = $this->getUserByMail();
            if (!$user) {
                $this->addError($attribute, 'Неверные данные!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUserByMail(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return $this->_mail;
    }

    public function getUserByMail()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByMail($this);
        }
        return $this->_user;
    }
}
