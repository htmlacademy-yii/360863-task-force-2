<?php

namespace app\models;

use yii\base\Model;

class AuthorizationForm extends Model
{

    public $email;
    public $password;

    public function rules ()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Такого email нет'],
            ['password', 'validatePassword'],

        ];
    }

    public function attributeLabels ()
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ'
        ];
    }

    public function validatePassword()
    {
        $user = User::findByEmail($this->email);

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Неправильные учетные данные');
        }
    }


}