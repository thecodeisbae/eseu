<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\utilisateur;
use Faker\Generator as Faker;
//use Hash;

$factory->define(Utilisateur::class, function (Faker $faker) {
    return [
        //
        'id'=>1,
        'nom'=>'KOUKE',
        'prenom'=>'Prince',
        'sexe'=>'m',
        'email'=>'koukeprince@gmail.com',
        'contact'=>'91538328',
        'adresse'=>'Cotonou',
        'pays'=>'bj',
        'fonction'=>'Developpeur',
        'identifiant'=>'koukeprince@gmail.com',
        'motdepasse'=>Hash::make('12345678'),
        'validite'=>'2020-12-12',
        'status'=>'1',
        'id_createur'=>'0',
        'candidat'=>'1',
        'convocation'=>'1',
        'numero'=>'1',
        'note'=>'1',
        'note_edit'=>'1',
        'resultat'=>'1',
        'session'=>'1',
        'utilisateur'=>'1',
        'reinscription'=>'1',
        'releve'=>'1',
        'attestation'=>'1',
        'created_at'=>'2020-10-13 00:00:00',
        'updated_at'=>'2020-10-13 00:00:00',
    ];
});
