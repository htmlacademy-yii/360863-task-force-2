<?php

namespace app\controllers;

use app\models\Task;
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

        if (\Yii::$app->request->isPost ) {
            $task->load(\Yii::$app->request->post());

            if ($task->validate()) {

                $task->save(false);
                $taskId = Yii::$app->db->getLastInsertID();

                if (UploadedFile::getInstances($files, 'files')) {
                    $files = UploadedFile::getInstances($files, 'files');
                    foreach ($files as $file) {
                        $file->saveAs("uploads/{$file->baseName}.{$file->extension}");
                        $file->file = $file;
                        $file->task_id = $taskId;
                        $file->save(false);
                    }
                }

                $this->redirect(Url::to("tasks/view/$taskId"));
            }
        }

        return $this->render('index', ['task' => $task, 'files' => $files]);

    }

}

/*
1. Сделать календарь

3. Коментарий про данные в лейауте
4. ошибка если нет задания в бд
5. На страницу задания вывести файлы
*/