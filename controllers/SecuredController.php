<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;

abstract class SecuredController extends \yii\web\Controller
{

    public $userProfile;

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

//    public function getUserProfile ()
//    {
//        $userProfile = [];
//        if ($id = \Yii::$app->user->getId()) {
//            Yii::$app->user->userProfile = User::findOne($id);
//        }
//
//        return $userProfile;
//    }
//
//
//    public function __construct($id, $module, $config = [])
//    {
//        $this->userProfile = $this->getUserProfile();
//        parent::__construct($id, $module, $config);
//    }




}