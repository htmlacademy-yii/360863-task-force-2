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

    public function getRatingPosition($id)
    {
        $result = null;

        $sql = "SELECT worker_id FROM review
GROUP BY worker_id
HAVING AVG(grade) >= (SELECT AVG(grade) FROM review WHERE worker_id = $id)
ORDER BY AVG(grade) DESC";

        $records = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        $index = array_search($id, array_column($records, 'worker_id'));

        if ($index !== false) {
            $result = $index + 1;
        }

        return $result;
    }

}