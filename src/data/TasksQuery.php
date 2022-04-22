<?php

namespace TaskForce\data;

use app\models\Task;
use TaskForce\Helpers;
use TaskForce\TaskStrategy;
use yii\db\Query;

class TasksQuery
{
    /**
     * @return array
     */
    public static function getQuery(): array
    {

        $tasks = Task::find()
            ->where (['status' => TaskStrategy::STATUS_NEW])
            ->with(['category', 'city'])
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->limit(5)
            ->asArray()
            ->all();

        foreach ($tasks as $key => $task) {
            $tasks[$key]['creation_date'] = Helpers::getTimePassed($task['creation_date']);
        }

        return $tasks;
    }
}
