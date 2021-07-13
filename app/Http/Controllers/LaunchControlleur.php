<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LaunchControlleur extends Controller
{
    //
    public function index()
    {
        $mdp = Hash::make('kpmm2000');
        echo $mdp;
    }
}
