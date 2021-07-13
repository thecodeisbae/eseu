<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Profil;

class AccesControlleur extends Controller
{
    //
    public function adding()
    {
        return view('/acces.add_profil');
    }

    public function edit($id)
    {
        $profil = Profil::where('id',$id)->firstOrFail();
        return view('/acces.edit_acces',compact('profil'));
    }

    public function update(Profil $acces)
    {
        request()->validate([
            'nom'=>'required',
            'description'=>'required'
        ]);

        $data = ([
            'nom' => request('nom'),
            'description' => request('description'),
            'candidat' => request('candidat'),
            'convocation' => request('convocation'),
            'numero' => request('numero'),
            'note' => request('note'),
            'resultat' => request('resultat'),
            'session' => request('session'),
            'utilisateur' => request('user'),
            'acces' => request('profil'),
            'supplement' => request('supplement'),
            'reinscription' => request('reinscription')
        ]);

        $acces->update($data);
        return redirect('/manage_profil')->with('success','Edition de profil effectuée');

    }

    public function destroy(Profil $acces)
    {
        $acces->delete();
        return back()->with('success','Suppression effectuee avec succès');
    }

    public function index()
    {
        $profils = \DB::table('profils')
                        ->select('id','profils.nom','profils.description','candidat','convocation','numero','note','resultat','session','utilisateur','acces','supplement','reinscription')
                        ->get();
        return view('/acces/manage',compact('profils'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'nom'=>'required',
            'description'=>'required'
        ]);

        $profil = new Profil();
            $profil->nom = request('nom');
            $profil->description = request('description');
            $profil->candidat = request('candidat');
            $profil->convocation = request('convocation');
            $profil->numero = request('numero');
            $profil->note = request('note');
            $profil->resultat = request('resultat');
            $profil->session = request('session');
            $profil->utilisateur = request('user');
            $profil->acces = request('profil');
            $profil->supplement = request('supplement');
            $profil->reinscription = request('reinscription');
        $profil->save();

        return back()->with('success','Nouveau profil enregistré');
    }
}
