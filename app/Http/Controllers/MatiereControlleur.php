<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\option;
use App\Matiere;
use App\session;

class MatiereControlleur extends Controller
{
    //
    public function adding()
    {
        $options = Option::all();
        $sessions = Session::all();
        return view('/session/add_matiere',compact('options','sessions'));
    }

    public function index()
    {
        $matieres = \DB::table('matieres')
                        ->join('options','matieres.option_id','=','options.id')
                        ->select('options.nom as opt_nom','matieres.id','matieres.code','matieres.nom','matieres.coef','matieres.principal')
                        ->where('matieres.session_id',session()->get('session_id'))
                        ->get();
        return view('/session/manage_matiere',compact('matieres'));
    }

    public function update(Matiere $matiere)
    {
        request()->validate([
            'option'=>'required',
            'session'=>'required',
            'type'=>'required',
            'code_mat'=>'required',
            'nom_mat'=>'required',
            'coef'=>'required|numeric'
        ]);

        if(request('type')=='forced'){
            $type=true;
        }else{
            $type=false;
        }

        $data = ([
            'option_id'=>request('option'),
            'session_id'=>request('session'),
            'nom'=>request('nom_mat'),
            'code'=>request('code_mat'),
            'principal'=>$type,
            'coef'=>request('coef')
        ]);
        $matiere->update($data);
        return redirect('/manage_matiere')->with('success','Edition effectuée');
    }

    public function edit($id)
    {
        $mat = Matiere::where('id',$id)->firstOrFail();
        $options = Option::all();
        $sessions = Session::all();
        return view('/session.edit_matiere',compact('mat','options','sessions'));
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();
        return back()->with('success','Suppression effectuée');
    }

    public function store(Request $request)
    {
        request()->validate([
            'option'=>'required',
            'session'=>'required',
            'type'=>'required',
            'code_mat'=>'required',
            'nom_mat'=>'required',
            'coef'=>'required|numeric'
        ]);

        if(request('type')=='forced'){
            $type=true;
        }else{
            $type=false;
        }

        $mat = new Matiere();
            $mat->code = request('code_mat');
            $mat->nom = request('nom_mat');
            $mat->principal = $type;
            $mat->coef = request('coef');
            $mat->option_id = request('option');
            $mat->session_id = request('session');
        $mat->save();

        return back()->with('success','Nouvelle matière ajoutée');
    }
}
