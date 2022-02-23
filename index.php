<?php

require_once 'Task.php';
$task = new Task(1);
print_r($task->customerId);
print_r($task->workerId);
echo $task->status;
print_r($task->getMap());
$task->status = 'active';
print_r($task->getActions($task->status));
print_r($task->getNextStatus('cancel'));
print_r($task->getMap()[$task->status]);
print_r($task->getActions($task->status));