<?php

namespace app\controllers;

use app\models\AuthorizationForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LandingController extends AppController
{
    public $layout = 'landing';

    public function actionIndex()
    {

        $authorization = new AuthorizationForm();

        $authorization->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($authorization);
        }

        if($authorization->validate()){
            $user = $authorization->getUser();
            $this->userProfile = $user;
            Yii::$app->user->login($user);
            return Yii::$app->response->redirect(['/tasks']);
        }

        return $this->render('index', ['authorization' => $authorization]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect('tasks');
                }
            ]
        ];
    }
}
