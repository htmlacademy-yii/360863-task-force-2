<?php

namespace app\controllers;

use app\models\TaskFilterForm;
use Yii;

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

        $filter = new TaskFilterForm();
        $filter->load(Yii::$app->request->get());

        return $this->render('index', ['filter' => $filter, 'dataProvider' => $filter->getDataProvider(),]);
    }
}
