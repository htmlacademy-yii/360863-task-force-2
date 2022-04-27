<?php
/**
 * @var $faker \Faker\Generator
 */

use yii\db\Query;

$tasksCompleted = [];
$query = new Query();
$query->select(['id'])->from('task')->where(['status' => 5]);
$rows = $query->all();
foreach ($rows as $row) {
    $tasksCompleted[] = $row['id'];
}

return [
    'description' => $faker->Realtext(100),
    'creation_date' => $faker->date,
    'grade' => $faker->numberBetween(1, 10),
    'task_id' => array_rand($tasksCompleted),
];
