<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\inscription;

class AccueilControlleur extends Controller
{
    //
    public function index()
    {
        $opta1 = Inscription::where('option_id',1)
                            ->where('session_id',session()->get('session_id'))
                            ->count();
        $opta2 = Inscription::where('option_id', 2)
                            ->where('session_id', session()->get('session_id'))
                            ->count();
        $optb =  Inscription::where('option_id', 3)
                            ->where('session_id', session()->get('session_id'))
                            ->count();
        $optc =  Inscription::where('option_id', 4)
                            ->where('session_id', session()->get('session_id'))
                            ->count();
        $data = ([
            'a1' => $opta1,
            'a2' => $opta2,
            'b' => $optb,
            'c' => $optc
        ]);
        return view('/index',compact('data'));
    }
}
