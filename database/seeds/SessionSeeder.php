<?php

use Illuminate\Database\Seeder;
use App\session;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Session::class, 4)->create();
    }
}
