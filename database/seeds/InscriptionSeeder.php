<?php

use Illuminate\Database\Seeder;
use App\inscription;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 500) as $i) {
            // Generate 5 entries each time
            factory(Inscription::class, 1)->create([
                // Since all steps have a number 1-12 grab the step by the number column and get it's ID
                'candidat_id' =>$i,
            ]);
        }
    }
}
