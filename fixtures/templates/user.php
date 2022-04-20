<?php
/**
 * @var $faker \Faker\Generator
 */
return [
    'registration_date' => "$faker->date $faker->time",
    'name' => $faker->firstName,
    'email' => $faker->unique()->email,
    'password' => md5($faker->word()),
    'avatar' => $faker->imageUrl(200, 200),
    'birth_date' => $faker->date('Y-m-d', '2000-10-05'),
    'telephone' => $faker->unique()->phoneNumber,
    'telegram' => "@{$faker->unique()->word}",
    'description' => $faker->Realtext(100),
    'city_id' => $faker->numberBetween(1, 500)
];