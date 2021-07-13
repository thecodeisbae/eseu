<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\utilisateur;
use App\session;
use Carbon\Carbon;
use Hash;

class LoginControlleur extends Controller
{
    //
    public function index()
    {
        /*$pwd = Hash::make('kpmm2000');
        echo $pwd;*/
        return view('/login');
    }

    public function updateStatus()
    {
        $date = date('Y-m-d');
        //echo $date;
        \DB::update('update utilisateurs set status=0 where validite < ?',[$date]);
        \DB::update('update utilisateurs set status=1 where validite > ?', [$date]);
    }

    public function control(Request $request)
    {
        $this->updateStatus();
        request()->validate(
            [
                'login'=>'required|string|max:255',
                'pwd'=>'required'
            ]
        );
        $login = request('login');
        $pwd = request('pwd');
        $model = Utilisateur::where('identifiant', $login)->first();
        if ($model != null) {
            if (Hash::check($pwd, $model->motdepasse, []))
            {
                $user_id = Utilisateur::select('id')
                                        ->where('identifiant','=',$login)
                                        ->first();
                $session_name = Session::select('nom')
                                        ->where('current','=','1')
                                        ->latest('created_at')
                                        ->first();
                $session_id = Session::select('id')
                                        ->where('current','=','1')
                                        ->latest('created_at')
                                        ->first();
                session()->put('user_id',$user_id->id);
                session()->put('user_name',$login);
                session()->put('session_name',$session_name->nom);
                session()->put('session_id',$session_id->id);
                if( $model->status )
                    return redirect('/index')->with('info','Bon retour sur votre tableau de bord '.$login);
                else
                    return redirect('/disabled');
            }
        }

        return back()->with('warning','Vérifier vos paramètres de connexion');
    }

}
