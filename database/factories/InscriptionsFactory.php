<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\inscription;
use App\Candidat;
use Faker\Generator as Faker;

$factory->define(Inscription::class, function (Faker $faker) {
    return [
        'session_id'=>random_int(1,4),
        'option_id'=>random_int(1,4),
        'user_id'=>1
    ];
});
