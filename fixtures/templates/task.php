<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'title' => $faker->realText(30),
    'description' => $faker->Realtext(100),
    'budget' => $faker->numberBetween(100, 10000),
    'creation_date' => $faker->dateTimeBetween('-1 week')->format('Y-m-d H:i:s'),
    'expiration_date' => $faker->dateTimeBetween('-1 week', '+10 week')->format('Y-m-d H:i:s'),
    'status' => $faker->numberBetween(1, 5),
    'category_id' => $faker->numberBetween(1, 8),
    'customer_id' => $faker->numberBetween(1, 100),
    'worker_id' => $faker->numberBetween(1, 100),
    'city_id' => $faker->numberBetween(1, 500),
];