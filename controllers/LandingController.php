<?php

namespace app\controllers;

use app\models\AuthorizationForm;
use Yii;
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
            if ($authorization->validate()) {
                return Yii::$app->response->redirect(['/tasks']);
            } else {
                return ActiveForm::validate($authorization);
            }
        }

        return $this->render('index', ['authorization' => $authorization]);
    }
}
