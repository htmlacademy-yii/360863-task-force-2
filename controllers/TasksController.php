<?php

namespace app\controllers;

use TaskForce\data\TasksQuery;

class TasksController extends \yii\web\Controller
{
    /**
     * Displays page Tasks.
     *
     * @return string
     */

    public function actionIndex()
    {
        $tasks = TasksQuery::getQuery();
        return $this->render('index', compact('tasks'));
    }
}
