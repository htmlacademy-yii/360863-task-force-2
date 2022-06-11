<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;

abstract class SecuredController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect('/');
                }
            ]
        ];
    }

}
