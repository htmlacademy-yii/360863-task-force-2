<?php

/** @var yii\web\View $this */

$this->title = 'Task-Force';

use TaskForce\Exception\ActionException;
use TaskForce\Exception\StatusException;
use TaskForce\Converter\ConverterCsvSql;


//$task = new TaskForce\TaskStrategy(1, 2, 2);
//print_r($task->getActionMap()); print_r('<br>');

print_r(scandir('/'));
$category = new TaskForce\Converter\ConverterCsvSql('/src/data/category.csv');
try {
    $category->import();
} catch (\TaskForce\Exception\SourceFileException $e) {
    print_r($e->getMessage());
}


?>


