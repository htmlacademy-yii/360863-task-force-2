<?php

require_once 'vendor/autoload.php';

$task = new TaskForce\TaskStrategy(1, 2, 2);
print_r($task->getActionMap()); print_r('<br>');
print_r($task->getNextStatus('cancel')); print_r('<br>');
print_r($task->getActions( 'new')); print_r('<br>');
