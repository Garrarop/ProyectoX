<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Like;
use App\Models\Status;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    $status = factory(Status::class)->create();
    return [
        'user_id' => function(){
          return factory(User::class)->create();
        },
        'likeable_id' => $status->id,
        'likeable_type' => get_class($status)
    ];
});
