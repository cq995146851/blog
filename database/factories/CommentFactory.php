<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Comment::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'content' => $faker->paragraph(),
        'is_new' => $faker->boolean(),
        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
});
