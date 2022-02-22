<?php

require_once 'Task.php';
$task = new Task(1, 1);
echo $task->customerId;
echo $task->status;
print_r($task->getMap());
$task->status = 'active';
print_r($task->getActions($task->status));
print_r($task->getNextStatus('cancel'));

