<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
        'activation_token' => str_random(32),
        'activated' => false,
        'avatar' => '',
        'is_admin' => false,
        'created_at' => $faker->date() . ' ' . $faker->time(),
        'updated_at' => $faker->date() . ' ' . $faker->time()
    ];
});
