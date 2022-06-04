<?php

namespace app\models;

class RegistrationForm extends \yii\base\Model
{

    public $name;
    public $email;
    public $city;
    public $password;
    public $passwordRepeat;
    public $isWorker;

    public function rules ()
    {
        return [
            [['name', 'email', 'city', 'password', 'passwordRepeat', 'isWorker'], 'required'],
            ['email', 'email'],
            ['city', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id', 'message' => 'Такого города не существует'],
            ['email', 'unique', 'targetClass' => User::class,'targetAttribute' => 'email', 'message' => 'Такой Email уже существует'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
        ];
    }

    public function attributeLabels ()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повтор пароля',
//            'isWorker' => 'я собираюсь откликаться на заказы',
        ];
    }
}
