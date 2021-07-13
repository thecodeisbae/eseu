<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NotifMail;
use App\Candidat;

class MailController extends Controller
{
    //
    public function index()
    {
        /*$data = Candidat::join('inscriptions','candidats.id','=','inscriptions.candidat_id')
                        ->join('options','inscriptions.option_id','=','options.id')
                        ->join('sessions','inscriptions.session_id','=','sessions.id')
                        ->select('candidats.email','candidats.nom','candidats.prenoms','options.nom as opt','sessions.nom as session','sessions.datetimeOral','sessions.datetimeEcrit')
                        ->where('candidats.id',3)
                        ->first();*/
        $details = [
            'nom' => 'KOUKE',
            'prenoms' => 'Prince',
            'option' => 'A1',
            'session' => 'Session de juin 2020',
            'oral' => '2020-12-03',
            'ecrit' => '2020-12-04'
        ];
        //dd($details);
        \Mail::to('koukeprince@gmail.com')->send(new NotifMail($details));
        dd("Email is Sent.");
    }
}
