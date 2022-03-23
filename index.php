<?php

use TaskForce\AcceptAction;
use TaskForce\CancelAction;
use TaskForce\RejectAction;
use TaskForce\TakeAction;
use TaskForce\Exception\ActionException;
use TaskForce\Exception\StatusException;
use TaskForce\Converter\ConverterCsvSql;

require_once 'vendor/autoload.php';

/*$task = new TaskForce\TaskStrategy(1, 2, 2);
print_r($task->getActionMap()); print_r('<br>');
print_r($task->getNextStatus('cancel')); print_r('<br>');
print_r($task->getActions( 'new')); print_r('<br>');*/


/*try {
    $task = new TaskForce\TaskStrategy(1, 2, 2);
    print_r($task->getActions( 'newx')); print_r('<br>');
} catch (Exception $e) {
    die($e->getMessage());
};*/

$category = new \TaskForce\Converter\ConverterCsvSql('data/category.csv');
$category->import();

$city = new ConverterCsvSql('data/city.csv');
$city->import();



/*if(is_numeric(55.89976)){
    print_r(1);
};*/