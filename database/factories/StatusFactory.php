<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;
use App\User;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        'user_id' => function(){
          return factory(User::class)->create();
        }
    ];
});
