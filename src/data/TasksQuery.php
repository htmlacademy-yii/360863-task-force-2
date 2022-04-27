<?php

namespace TaskForce\data;

use app\models\Task;
use TaskForce\TaskStrategy;

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
            ->all();

        return $tasks;
    }
}
