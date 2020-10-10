<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Status;
use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => function(){
          return factory(User::class)->create();
        },
        'status_id' => function(){
          return factory(Status::class)->create();
        },
        'body' => $faker->paragraph
    ];
});
