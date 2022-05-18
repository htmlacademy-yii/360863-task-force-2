<?php

namespace app\controllers;

use app\models\Review;
use app\models\Task;
use TaskForce\TaskStrategy;
use Yii;

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
