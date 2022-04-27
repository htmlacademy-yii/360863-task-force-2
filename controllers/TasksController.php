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

    public function actionIndex() :string
    {
        $this->view->title = 'Tasks - Task-Force';
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Описание страницы'], 'description');

        $tasks = TasksQuery::getQuery();

        return $this->render('index', compact('tasks'));
    }
}
