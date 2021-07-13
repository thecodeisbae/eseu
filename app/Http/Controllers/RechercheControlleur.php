<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidat;
use App\inscription;
use App\option;

class RechercheControlleur extends Controller
{
    //
    public function searchResult(Request $request)
    {
        request()->validate(
            [
                'search'=>'required'
            ]
        );
        $datas = null;
        $find = 0;
        $motif = request('search');

        //Vérifier s'il agit d'un nom
        $data = Candidat::where('nom','like', '%' . $motif . '%')->get();
        if($data->isEmpty())
        {
            $data = Candidat::where('prenoms','like', '%' . $motif . '%')->get();
            if($data->isEmpty())
            {
                $data = Candidat::where('identifiant','like', '%' . $motif . '%')->get();
                if($data->isEmpty())
                {
                    $data = Inscription::where('numero_table','like', '%' . $motif . '%')->get();
                    if(!$data->isEmpty())
                    {
                        $find = 1;
                        $datas = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
                            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                            ->join('options', 'inscriptions.option_id', '=', 'options.id')
                            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                            ->select('options.nom as option', 'sessions.id as sessid', 'sessions.nom as session', 'candidats.identifiant', 'candidats.nom as cdt_nom', 'candidats.prenoms as cdt_prenoms', 'images.miniature', 'inscriptions.numero_table as n_table', 'inscriptions.moyenne', 'inscriptions.decision','inscriptions.oralAdmis')
                            ->where('inscriptions.numero_table', 'like', '%' . $motif . '%')
                            ->get();
                    }
                }
                else
                {
                    $find = 1;
                    $datas = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
                    ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                    ->join('options', 'inscriptions.option_id', '=', 'options.id')
                        ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                        ->select('options.nom as option', 'sessions.id as sessid', 'sessions.nom as session', 'candidats.identifiant', 'candidats.nom as cdt_nom', 'candidats.prenoms as cdt_prenoms', 'images.miniature', 'inscriptions.numero_table as n_table', 'inscriptions.moyenne','inscriptions.decision', 'inscriptions.oralAdmis')
                        ->where('candidats.identifiant', 'like', '%' . $motif . '%')
                        ->get();
                }
            }
            else
            {
                $find = 1;
                $datas = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                    ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                    ->select('options.nom as option', 'sessions.id as sessid', 'sessions.nom as session', 'candidats.identifiant', 'candidats.nom as cdt_nom', 'candidats.prenoms as cdt_prenoms', 'images.miniature', 'inscriptions.numero_table as n_table', 'inscriptions.moyenne','inscriptions.decision', 'inscriptions.oralAdmis')
                    ->where('candidats.prenoms', 'like', '%' . $motif . '%')
                    ->get();
            }
        }
        else
        {
            $find=1;
            $datas = Candidat::join('images','candidats.id','=','images.candidat_id')
                            ->join('inscriptions','candidats.id','=','inscriptions.candidat_id')
                            ->join('options','inscriptions.option_id','=','options.id')
                            ->join('sessions','inscriptions.session_id','=','sessions.id')
                            ->select('options.nom as option','sessions.id as sessid','sessions.nom as session','candidats.identifiant','candidats.nom as cdt_nom','candidats.prenoms as cdt_prenoms','images.miniature','inscriptions.numero_table as n_table','inscriptions.moyenne','inscriptions.decision', 'inscriptions.oralAdmis')
                            ->where('candidats.nom','like','%'.$motif.'%')
                            ->get();
        }
        if($find)
        {
            $search = request('search');
            $n = $datas->count();
            return view('search',compact('datas','search','n'));
        }
        else
        {
            return redirect('/empty');
        }
        return back();
    }

    function focus()
    {
        $id = request('value');
        $session = request('session');
        $obj = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
                        ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                        ->join('sessions','inscriptions.session_id','=','sessions.id')
                        ->select('candidats.*', 'images.chemin', 'inscriptions.option_id as opt_id','inscriptions.moyenne','sessions.nom as session')
                        ->where('candidats.identifiant', $id)
                        ->where('inscriptions.session_id',$session)
                        ->firstOrFail();
        $opt = Option::where('id', $obj->opt_id)
                        ->select('id', 'nom')
                        ->firstOrFail();
        return view('details',compact('obj','opt'));
    }
}
