<?php

namespace app\controllers;

use app\models\RegistrationForm;
use app\models\User;;
use yii\helpers\Url;

class RegistrationController extends AppController
{

    public function actionIndex(): string
    {

        $registration = new RegistrationForm();

        if ($registration->load(\Yii::$app->request->post()) && $registration->validate()) {

            $user = new User();
            $user->name = $registration->name; /*а нужно тут делать что то с безопасностью?*/
            $user->email = $registration->email;
            $user->city_id = $registration->city;
            $user->password = md5($registration->password);
            $user->is_worker = $registration->isWorker;
            $user->save();
            $this->redirect(Url::to('/'));

        }

        return $this->render('index', ['registration' => $registration]);
    }

}
