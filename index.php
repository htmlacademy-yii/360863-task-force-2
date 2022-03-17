<?php

use TaskForce\AcceptAction;
use TaskForce\CancelAction;
use TaskForce\RejectAction;
use TaskForce\TakeAction;
use TaskForce\ActionException;
use TaskForce\StatusException;

require_once 'vendor/autoload.php';

/*$task = new TaskForce\TaskStrategy(1, 2, 2);
print_r($task->getActionMap()); print_r('<br>');
print_r($task->getNextStatus('cancel')); print_r('<br>');
print_r($task->getActions( 'new')); print_r('<br>');*/


try {
    $task = new TaskForce\TaskStrategy(1, 2, 2);
    print_r($task->getActions( 'newx')); print_r('<br>');
} catch (Exception $e) {
    die($e->getMessage());
};