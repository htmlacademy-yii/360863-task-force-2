<?php

namespace app\models;

use yii\base\Model;

class AuthorizationForm extends Model
{

    public $email;
    public $password;
    private $_user;


    public function rules ()
    {

        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'safe'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }


    public function attributeLabels ()
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ'
        ];
    }

/*    public function validatePassword()
    {
        $user = User::findByEmail($this->email);

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Неправильные учетные данные');
        }
    }*/

    //    public function rules ()
//    {
//        return [
//            [['email', 'password'], 'required'],
//            ['email', 'email'],
//            ['email', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Такого email нет'],
//            ['password', 'validatePassword'],
//
//        ];
//    }



}