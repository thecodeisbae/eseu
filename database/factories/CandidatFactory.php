<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Candidat;
use App\session;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Candidat::class, function (Faker $faker)
{
    $session_id = random_int(1,4);
    $pos = Session::where('id', $session_id)
        ->select('position', 'start')
        ->first();
    $index = str_pad($pos->position + 1, 4, '0', STR_PAD_LEFT);
    $last = Carbon::createFromDate($pos->start)->year;
    $code = "ESEU-" . $index . '-' . $last;
    \DB::update(
        'update sessions set position = ? where id = ?',
        [$pos->position + 1, $session_id]
    );
    return [
        'identifiant' => $code,
        'nom'=> $faker->firstName,
        'prenoms'=> $faker->lastName,
        'sexe'=> $faker->text[0],
        'date_naissance'=>$faker->date,
        'email'=>$faker->email,
        'contact'=>$faker->e164PhoneNumber
    ];
});
