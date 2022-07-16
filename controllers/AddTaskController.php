<?php

namespace app\controllers;

use app\models\Task;
use app\models\City;
use app\models\TaskFile;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class AddTaskController extends SecuredController
{

    public function actionIndex ()
    {

        $task = new Task();
        $files = new TaskFile();

        if (Yii::$app->request->isPost) {
            $task->load(Yii::$app->request->post());
            $task->customer_id = Yii::$app->user->getId();

            if ($task->validate()) {

                $task->city_id = City::findOne(['title' => $task->location])->id;

                if ($task->save(false)) {
                    $taskId = $task->id;
                } else {
                    $taskId = null;
                }

                $files->files = UploadedFile::getInstances($files, 'files');
                foreach ($files->files as $file) {
                    $file->saveAs("uploads/{$file->baseName}.{$file->extension}");
                    $files->file = $file->name;
                    $files->task_id = $taskId;
                    $files->size = ceil(($file->size)/1024);
                    $files->save(false);
                }

                $this->redirect(Url::to("tasks/view/$taskId"));
            }
        }

        return $this->render('index', ['task' => $task, 'files' => $files]);

    }

}

/*
4. какая то не понятная ошибка если нет задания в бд
*/
