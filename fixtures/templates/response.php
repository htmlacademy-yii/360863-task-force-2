<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'message' => $faker->Realtext(100),
    'price' => $faker->numberBetween(100, 10000),
    'creation_date' => $faker->date,
    'task_id' => $faker->numberBetween(1, 100),
    'user_id' => $faker->numberBetween(1, 100)
];