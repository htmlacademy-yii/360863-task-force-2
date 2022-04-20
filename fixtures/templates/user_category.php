<?php

/**
 * @var $faker \Faker\Generator
 */

return [
    'category_id' => $faker->numberBetween(1, 8),
    'user_id' => $faker->unique()->numberBetween(1, 100)
];
