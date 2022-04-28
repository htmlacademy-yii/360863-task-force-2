<?php

namespace app\controllers;

use app\models\Category;
use app\models\Task;
use app\models\TaskFilterForm;
use TaskForce\data\TasksQuery;
use TaskForce\TaskStrategy;
use yii\data\ActiveDataProvider;

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

        //$tasks = TasksQuery::getQuery();

        $categories = Category::find()->indexBy('id')->all();
        $tasks = Task::find()
            ->where (['status' => TaskStrategy::STATUS_NEW])
            ->with(['category', 'city'])
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->indexBy('id')
            ->all();

        $filter = new TaskFilterForm();

        $categoryList = Category::find()->where('id IN (1, 2, 3)')->select('title')->indexBy('id')->column();
        $periodList = [
            1 => '1 час',
            2 => '12 часов',
            3 => '24 часа',
        ];
        $filter->category = [1]; //что-то мне кажется так не очень верно

        //$this->debug($taskFilterForm);

//        if ($filter->load(\Yii::$app->request->get()) /*&& $taskFilterForm->validate()*/){
//            $tasks = Task::find()
//                ->where (['status' => TaskStrategy::STATUS_NEW, 'category_id' => $filter->category, /*'worker_id' => $taskFilterForm->isWorker*/])
//                ->with(['category', 'city'])
//                ->orderBy(['task.creation_date' => SORT_DESC])
//                ->indexBy('id')
//                ->all();
//        }


        $dataProvider = $filter->getDataProvider();


        return $this->render('index', compact('tasks', 'filter', 'categoryList', 'categories', 'periodList', 'dataProvider', ));
    }
}
