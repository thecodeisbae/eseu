<?php

use Illuminate\Database\Seeder;
use App\Candidat;

class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Candidat::class,500)->create();
    }
}
