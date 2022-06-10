<?php

namespace app\controllers;

use TaskForce\TaskStrategy;
use app\models\Review;
use app\models\Task;
use app\models\User;
use app\models\UserCategory;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class UserController extends SecuredController
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

        $userCategories = UserCategory::find()
            ->where(['user_id' => $id])
            ->with('category')
            ->all();

        if ($user->reviews) {
            $averageGrade = Review::find()->where(['worker_id' => $id])->average('grade');
            $userAverageGrade = round($averageGrade, 2);
            $avg = new Expression('AVG(grade)');
            $ratings = Review::find()->select('worker_id')->groupBy('worker_id')->having(['>=', "$avg", "$averageGrade"])->orderBy(["$avg" => SORT_DESC])->asArray()->all();
            $userRatingPlace = array_search($id, array_column($ratings, 'worker_id')) + 1 . ' место';
        } else {
            $userAverageGrade = 0;
            $userRatingPlace = 'отзывов пока нет';
        }

        $totalDone = count(Task::find()
            ->where(['worker_id' => $id, 'status' => TaskStrategy::STATUS_DONE])
            ->all());

        $totalFailed = count(Task::find()
            ->where(['worker_id' => $id, 'status' => TaskStrategy::STATUS_FAILED])
            ->all());

        $workerStatus = $user->getWorkerStatus();

        return $this->render('view', [
            'user' => $user,
            'userCategories' => $userCategories,
            'userAverageGrade' => $userAverageGrade,
            'totalDone' => $totalDone,
            'totalFailed' => $totalFailed,
            'workerStatus' => $workerStatus,
            'userRatingPlace' => $userRatingPlace,
            ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

}