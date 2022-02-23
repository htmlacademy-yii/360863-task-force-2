<?php

require_once 'Task.php';
$task = new Task(1);
$task->userId = 1;
print_r($task->customerId); echo '<br>';
echo $task->status; echo '<br>';
print_r($task->getMap()); echo '<br>';
$task->status = 'active';
print_r($task->getActions($task->status)); echo '<br>';
print_r($task->getMap()[$task->status]); echo '<br>';