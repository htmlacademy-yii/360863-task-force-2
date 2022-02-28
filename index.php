<?php

require_once 'vendor/autoload.php';

$task = new TaskForce\Task(1);
print_r($task->customerId); echo '<br>';
echo $task->status; echo '<br>';
print_r($task->getActionMap()); echo '<br>';
$task->status = 'active';
print_r($task->getActions($task->status)); echo '<br>';
print_r($task->getActionMap()[$task->status]); echo '<br>';