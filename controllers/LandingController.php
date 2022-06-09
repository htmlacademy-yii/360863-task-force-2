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

        if (Yii::$app->request->getIsPost()) {
            $authorization->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax && $authorization->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($authorization);
            }

            if ($authorization->load(\Yii::$app->request->post()) && $authorization->validate()) {
                var_dump(11111111111111111111111111);
            }

        }





        return $this->render('index', ['authorization' => $authorization]);
    }
}
