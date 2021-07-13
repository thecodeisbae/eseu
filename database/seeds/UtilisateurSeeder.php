<?php

use Illuminate\Database\Seeder;
use App\utilisateur;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Utilisateur::class, 1)->create();
    }
}
