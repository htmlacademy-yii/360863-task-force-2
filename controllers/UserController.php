<?php

namespace app\controllers;

use TaskForce\TaskStrategy;
use app\models\Review;
use app\models\Task;
use app\models\User;
use app\models\UserCategory;
use yii\web\NotFoundHttpException;

class UserController extends AppController
{

    public function actionView($id): string
    {

        $user = User::find()
            ->where(['id' => $id])
            ->with('city')
            ->one();

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $this->view->title = "Пользователь: $user->name";


        $userCategories = UserCategory::find()
            ->where(['user_id' => $id])
            ->with('category')
            ->all();

        $reviews = Review::find()
            ->where(['worker_id' => $id])
            ->with('task', 'worker', 'customer')
            ->all();

        if ($reviews) {
            $averageGrade = round(Review::find()->where(['worker_id' => $id])->average('grade'), 2);
        } else {
            $averageGrade = 0;
        }

        $totalDone = count(Task::find()
            ->where(['worker_id' => $id, 'status' => TaskStrategy::STATUS_DONE])
            ->all());

        $totalFailed = count(Task::find()
            ->where(['worker_id' => $id, 'status' => TaskStrategy::STATUS_FAILED])
            ->all());

        return $this->render('view', [
            'user' => $user,
            'userCategories' => $userCategories,
            'reviews' => $reviews,
            'averageGrade' => $averageGrade,
            'totalDone' => $totalDone,
            'totalFailed' => $totalFailed,
            ]);
    }

}