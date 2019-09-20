<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {

    $name = $faker->name;

    return [
        'name'=> $name,
        'slug'=> strtolower(preg_replace('/\s+/', '_', $name))
    ];
});
