<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Round;
use Faker\Generator as Faker;

$factory->define(Round::class, function (Faker $faker) {
    return [
        "name"=> "Round".$faker->dayOfMonth,
        "starting_date" => "2020-12-01 14:36:38",
        "ending_date" => "2020-12-05 14:36:38",
    ];
});
