<?php

namespace app\controllers;

use app\models\Response;
use app\models\TaskFile;
use app\models\TaskFilterForm;
use app\models\Task;
use TaskForce\TaskStrategy;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
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

    public function actionView($id): string
    {

        $task = Task::find()
            ->where(['id' => $id])
            ->with(['category'])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }

        return $this->render('view', ['task' => $task,]);
    }

    public function actionAccept($id)
    {
        $response = Response::find()
            ->where(['id' => $id])
            ->one();
        $response->status = TaskStrategy::RESPONSE_ACCEPTED;
        $response->save(false);
        $task = Task::find()
            ->where(['id' => $response->task_id])
            ->one();
        $task->worker_id = $response->user_id;
        $task->status = TaskStrategy::STATUS_ACTIVE;
        $task->save(false);
        return $this->redirect('view/' . $task->id);
    }

    public function actionReject($id)
    {
        $response = Response::find()
            ->where(['id' => $id])
            ->one();
        $response->status = TaskStrategy::RESPONSE_REJECTED;
        $response->save(false);
        return $this->redirect('view/' . $response->task_id);
    }

}
