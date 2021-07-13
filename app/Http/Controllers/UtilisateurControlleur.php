<?php

namespace App\Http\Controllers;

use Hash;
use App\Profil;
use App\session;
use App\utilisateur;
use Illuminate\Http\Request;

class UtilisateurControlleur extends Controller
{
    //
    public function adding()
    {
        return view('/utilisateur/add_user');
    }

    public function disconnect()
    {
        session()->forget('user_id');
        session()->forget('user_name');
        session()->forget('session_name');
        session()->forget('session_id');
        return view('/login');
    }

    public function edit($id)
    {
        $user = Utilisateur::where('id',$id)->firstOrFail();
        return view('/utilisateur.edit',compact('user'));
    }

    public function update(Utilisateur $user)
    {
        request()->validate([
            'nom'=>'required',
            'prenom'=>'required',
            'sexe'=>'required',
            'email'=>'required',
            'adresse'=>'nullable',
            'contact'=>'required|numeric|min:8',
            'login'=>'required',
            'pays' => 'nullable',
            'work' => 'nullable',
            'validity'=>'required|date'
        ]);
        $my_date = date('Y-m-d');
        if( request('validity') > $my_date )
            {
                $is_valid = true;
            }else{
                $is_valid = false;
            }
        if(request('mdp'))
        {
            $donnees = ([
                'nom'=>request('nom'),
                'prenom'=>request('prenom'),
                'sexe'=>request('sexe'),
                'email'=>request('email'),
                'adresse'=>request('adresse'),
                'contact'=>request('contact'),
                'identifiant'=>request('login'),
                'motdepasse'=>Hash::make(request('mdp')),
                'status'=>$is_valid,
                'pays' =>request('pays'),
                'fonction' =>request('work') ,
                'validite'=>request('validity')
            ]);
            $user->update($donnees);
        }else
        {
            \DB::update('update utilisateurs set nom = ? , prenom = ?,sexe = ? ,email = ?,adresse = ?,contact = ?,identifiant = ?,
                        status = ?,pays = ?,fonction = ?,validite = ? where id = ?',
                         [
                            request('nom'),request('prenom'),request('sexe'),request('email'),
                            request('adresse'),request('contact'),request('login'),
                            $is_valid,request('pays'),request('work'),
                            request('validity'),$user->id
                         ]);
            
        }
        return redirect('/focus_user/'.$user->id);
    }

    public function show($id)
    {
        $user = Utilisateur::where('id',$id)->firstOrFail();
        return view('/utilisateur.focus_user',compact('user'));
    }

    public function destroy(Utilisateur $user)
    {
        $user->delete();
        return back()->with('success','Utilisateur supprimé');
    }

    public function index()
    {
        $users = \DB::table('utilisateurs')
                    ->select('utilisateurs.*')
                    ->get();
        return view('/utilisateur/manage',compact('users'));
    }

    public function store(Request $request)
    {
        //Les conditions de validation du formulaire
            request()->validate([
                'nom'=>'required',
                'prenom'=>'required',
                'sexe'=>'required',
                'email'=>'required',
                'contact'=>'required|numeric|min:8',
                'login'=>'required',
                'mdp'=>'required',
                'validity'=>'required|date'
            ]);
        //Recuperer les infos du formulaire
            $nom = request('nom');
            $prenom = request('prenom');
            $sexe = request('sexe');
            $email = request('email');
            $contact = request('contact');
            $login = request('login');
            $mdp = request('mdp');
            $validity = request('validity');
            $my_date = date('Y-m-d');
            $adresse = request('adresse');
            $pays = request('pays');
            $fonction = request('work');
        //Verifier la validite du compte de l'utilisateur
            if( $validity > $my_date )
            {
                $is_valid = true;
            }else{
                $is_valid = false;
            }
        //Creer un nouvel utilisateur
            $user = new Utilisateur();
                $user->nom = $nom;
                $user->prenom = $prenom;
                $user->sexe= $sexe;
                $user->email = $email;
                $user->contact = $contact;
                $user->adresse = $adresse;
                $user->pays = $pays;
                $user->fonction = $fonction;
                $user->identifiant = $login;
                $user->motdepasse = Hash::make($mdp);
                $user->validite = $validity;
                $user->status = $is_valid;
                //$user->id_createur = 1;
                $user->id_createur = session()->get('user_id');

                $user->candidat = request('candidat');
                $user->convocation = request('convocation');
                $user->numero = request('numero');
                $user->note = request('note');
                $user->note_edit = request('note_edit');
                $user->resultat = request('resultat');
                $user->session = request('session');
                $user->utilisateur = request('user');
                $user->releve = request('releve');
                $user->attestation = request('attestation');
                $user->reinscription = request('reinscription');
            $user->save();
        return back()->with('success','Enregistrement de l\'utilisateur effectué');
    }
}
