<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\session;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        //
        'nom'=>'Session de '.random_int(2018,2030),
        'start'=>$faker->date(),
        'end'=>$faker->date(),
        'numero'=>'UAC/VR-AA/SEOU',
        'current'=>'0',
        'seuilOral'=>random_int(10,12),
        'datetimeOral'=>$faker->dateTime(),
        'datetimeEcrit'=>$faker->dateTime(),
        'viceRecteur'=>$faker->firstName.' '.$faker->lastName,
        'viceRectorat'=>'chargé des affaires académiques',
        'service'=>'Scolarité centrale',
        'moyenne_passage'=>random_int(10,12),
        'position'=>'0'
    ];
});
