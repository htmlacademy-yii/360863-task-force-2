<?php

namespace app\controllers;

use app\models\Task;
use TaskForce\TaskStrategy;

class AppController extends \yii\web\Controller
{
    public function getWorkerStatus ($id): string
    {
        if (Task::find()->where(['worker_id' => $id, 'status' => TaskStrategy::STATUS_ACTIVE])->all()) {
            return 'Занят' ;
        } else {
            return 'Открыт для новых заказов';
        }
    }
}
