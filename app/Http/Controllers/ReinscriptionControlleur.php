<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;
use App\Option;
use App\Candidat;
use App\Inscription;
use App\Matiere;
use App\Note;
use Carbon\Carbon;

class ReinscriptionControlleur extends Controller
{
    //
    public function create()
    {
        $sessions_d = Session::all();
        $sessions = Session::all();
        $options = Option::all();
        return view('/reinscription.reinscription',compact('sessions_d','sessions','options'));
    }

    public function verify()
    {
        $id = request('value');
        $data = Candidat::where('identifiant', $id)
                        ->first();
        if (is_null($data))
            echo '0';
        else
            echo '1';
    }

    public function doublon()
    {
        $session = request('session');
        $idtf = request('value');
        $data = Candidat::join('Inscriptions','Candidats.id','=','Inscriptions.candidat_id')
                        ->where('Inscriptions.session_id',$session)
                        ->where('Candidats.identifiant',$idtf)
                        ->first();
        if (is_null($data))
            echo '1';
        else
            echo '0';
    }

    public function getCandidats()
    {
        $id = request('value');
        //$sessions = Session::where('id','!=',session()->get('session_id')['id']);
        $sessions = Session::all();
        $opts = Option::all();
        $cdt = Candidat::where('identifiant',$id)->first();
        $sexe = '';
        if($cdt->sexe == 'm')
            $sexe = 'Homme';
        else
            $sexe = 'Femme';
        $output = '<tr align="center">
                     <td style="padding-top:2%;">'.$cdt->nom.' '.$cdt->prenoms. '</td>
                     <td style="padding-top:2%;">'.$sexe. '</td>
                     <td style="padding-top:2%;">'.$cdt->contact.'</td>
                     <td>
                        <select class="custom-select" onchange="change()" name="option" id="option">';
        $output .= '<option value="0">Choisir option</option>';
        foreach($opts as $opt)
                $output .= '<option value="'.$opt->id.'">'.$opt->nom.'</option>';
        $output .= '    </select>
                     </td>
                     <td>
                        <select name="matiere" id="matiere" class="custom-select">
                            <option value="0">Choisir matiere</option>
                        </select>
                     </td>
                     <td>
                     <select class="custom-select" name="session" id="session">';
        foreach($sessions as $session)
                $output .= '<option value="'.$session->id.'">'.$session->nom.'</option>';
        $output .= ' </select>
                     </td>
                     <td align="center">
                        <button class="btn btn-outline-dark" onclick="verify()" ><i class="fas fa-arrow-right"></i></button>
                     </td>
                   </tr>';
        echo $output;
    }

    public function store(Request $request)
    {
        //Recuperer les variables postees
            $session = request('pSession');
            $identifiant = request('pIdentifiant');
            $option = request('pOption');
            $matiere = request('pMatiere');

        //Verifier la validite de l'admission a l'oral
            $oral = null;
            $insc = Inscription::join('Candidats','Inscriptions.candidat_id','=','Candidats.id')
                                ->where('Candidats.identifiant', $identifiant)
                                ->latest('Inscriptions.id')
                                ->first();
            $oldSession = Session::where('id',$insc->session_id)->first();
            $oldYear = Carbon::createFromDate($oldSession->start)->year;

            $nowSession = Session::where('id',$session)->first();
            $nowYear = Carbon::createFromDate($nowSession->start)->year;
            if($oldYear+1 == $nowYear)
            {
                if($insc->oral >= $oldSession->seuilOral)
                    $oral = $insc->oral;
            }
            $cdt = Candidat::where('identifiant',$identifiant)->first();

        //Ajout des entrees dans la table inscription
            $inscrit = new Inscription();
            $inscrit->candidat_id = $cdt->id;
            $inscrit->user_id = session()->get('user_id')['id'];
            $inscrit->session_id = $session;
            $inscrit->option_id = $option;
            if(!is_null($oral))
                $inscrit->oral = $oral;
            $inscrit->save();

        //Ajouter des lignes dans la table note
            $matieres = Matiere::select('id', 'nom')
                                ->where('option_id', $option)
                                ->where('principal', '1')->get();
            if ($matiere != "0")
            {
                $note = new Note();
                $note->session_id = $session;
                $note->candidat_id = $cdt->id;
                $note->matiere_id = $matiere;
                $note->save();
            }
            foreach ($matieres as $mat) {
                $note = new Note();
                $note->session_id = $session;
                $note->candidat_id = $cdt->id;
                $note->matiere_id = $mat->id;
                $note->save();
            }


            return back()->with('success','Candidat reinscrit avec succès');

    }

}
