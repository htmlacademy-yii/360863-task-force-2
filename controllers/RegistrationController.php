<?php

namespace app\controllers;

use app\models\AuthorizationForm;
use app\models\RegistrationForm;
use app\models\User;;

use Yii;
use yii\helpers\Url;

class RegistrationController extends AppController
{

    public function actionIndex(): string
    {

        $user = new User();

        if (Yii::$app->request->getIsPost()) {
            $user->load(Yii::$app->request->post());

            if ($user->validate()) {
                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                $user->save(false);
                Yii::$app->user->login($user);
                $this->redirect(Url::to('/tasks'));
            }
        }

        return $this->render('index', ['registration' => $user]);
    }

}
