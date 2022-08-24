<?php

namespace app\controllers;

use app\models\Response;
use app\models\Review;
use app\models\TaskFile;
use app\models\TaskFilterForm;
use app\models\Task;
use TaskForce\TaskStrategy;
use Yii;
use yii\db\Exception;
use yii\helpers\Url;
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

        $response = new Response();
        $review = new Review();

        if (Yii::$app->request->getIsPost())
        {
            if (Yii::$app->request->post('responseForm'))
            {
                $response->load(Yii::$app->request->post());
                $response->task_id = $id;
                $response->user_id = Yii::$app->user->getId();
                if ($response->validate()) {
                    $response->save(false);
                } else {
                    $errors = $response->errors;
                }
            } elseif (Yii::$app->request->post('reviewForm'))
            {
                $review->load(Yii::$app->request->post());
                $review->task_id = $id;
                $review->customer_id = $review->task->customer_id;
                $review->worker_id = $review->task->worker_id;
                $task = Task::find()
                    ->where(['id' => $id])
                    ->one();
                $task->status = TaskStrategy::STATUS_DONE;
                if ($review->validate()) {
                   /* $review->save(false);*/
                    $task->save(false);
                    if ($review->save()) {
                    Yii::$app->session->setFlash('success', "все получилось");
                    }
                } else {
                    $errors = $review->errors;
                    foreach ($review->errors as $error) {
                        Yii::$app->session->setFlash('error', "$error");
                    }

                }
            }
        }
        return $this->render('view', ['task' => $task, 'response' => $response, 'review' => $review]);
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
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReject($id)
    {
        $response = Response::find()
            ->where(['id' => $id])
            ->one();
        $response->status = TaskStrategy::RESPONSE_REJECTED;
        $response->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRejectTask ($id)
    {
        $task = Task::find()
            ->where(['id' => $id])
            ->one();
        $task->status = TaskStrategy::STATUS_FAILED;
        $task->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCancellTask ($id)
    {
        $task = Task::find()
            ->where(['id' => $id])
            ->one();
        $task->status = TaskStrategy::STATUS_CANCELLED;
        $task->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }

}
