<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\option;
use App\Note;
use App\session;
use App\inscription;
use App\Matiere;
use App\Candidat;
use Illuminate\Contracts\Routing\ResponseFactory;

class NoteControlleur extends Controller
{
    //

    public function index()
    {
        $options = Option::all();
        return view('/note.note', compact('options'));
    }

    function editIndex()
    {
        $options = Option::all();
        return view('/note.edit', compact('options'));
    }

    public function getCode(Request $request)
    {
        $value = request('value');
        $data = \DB::table('inscriptions')
            ->where('option_id', $value)
            ->where('session_id', '=', session()->get('session_id'))
            ->get();
        $output = '<option value="0">Selectionner un code</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->code_secret . '</option>';
        }
        echo $output;
    }

    public function store()
    {
        $cdt_id = request('cdt');

        $id_matieres = Note::where('candidat_id', $cdt_id)
            ->where('session_id', session()->get('session_id'))
            ->select('matiere_id', 'note')
            ->get();
        $elements = array();
        foreach($id_matieres as $element)
            array_push($elements,$element->matiere_id);
        echo $id_matieres;
    }

    public function saving()
    {
        $cdt_id = request('cdt');
        $notes = request('notes');
        $id_matieres = Note::where('candidat_id', $cdt_id)
            ->where('session_id', session()->get('session_id'))
            ->select('matiere_id', 'note')
            ->get();
        if(count($notes)==count($id_matieres))
        {
            foreach($notes as $i => $note)
            {
                \DB::update(
                    'update notes set note = ? where candidat_id = ? and matiere_id = ? and session_id = ? ',
                    [$note, $cdt_id, $id_matieres[$i]->matiere_id, session()->get('session_id')]
                );
            }
            if($this->canCalculateMoyenne($cdt_id))
                echo "1";
            else
                echo "0";
        }
        else
            echo "0";
    }

    public function view()
    {
        $cdt = request('cdt');
        //$this->canCalculateMoyenne($cdt);
    }

    function canCalculateMoyenne($id)
    {
        //Recuperer les matieres du candidat d'id $id
        $matieres_cdt = Note::where('candidat_id', $id)
            ->where('session_id', session()->get('session_id'))
            ->get();
        if ($matieres_cdt != null)
        {
            //Verifier si toutes les matieres ont des notes associes
            foreach ($matieres_cdt as $mat)
                if ($mat->note == null)
                    {
                        echo json_encode('');
                        return ;
                    }

            //Recuperer les notes du candidat
            $notes = array();
            foreach ($matieres_cdt as $cdt)
                array_push($notes, $cdt->note);

            //Recuperer les coefficients pour les notes
            $coefs = array();
            $coef_totale = 0;
            foreach ($matieres_cdt as $cdt) {
                $coef = Matiere::where('id', $cdt->matiere_id)
                    ->select('coef')
                    ->first();
                array_push($coefs, $coef->coef);
                $coef_totale += $coef->coef;
            }

            //Calculer la moyenne
            if ($coefs != null && $notes != null && count($coefs) == count($notes)) {
                $sum = 0;
                for ($x = 0; $x < count($notes); $x++) {
                    $sum += $coefs[$x] * $notes[$x];
                }
                $moy = $sum / $coef_totale;

                //Enregistrer la valeur en Base de données
                \DB::update('update inscriptions set moyenne=? where candidat_id=? and session_id=?',[number_format($moy,2),$id,session()->get('session_id')]);

                $sess = Session::where('id',session()->get('session_id'))->first();
                if($moy > $sess->moyenne_passage)
                    \DB::update('update inscriptions set decision = ? where candidat_id =? and session_id=?', [1,$id,session()->get('session_id')]);
                else
                    \DB::update('update inscriptions set decision = ? where candidat_id =? and session_id=?', [0, $id, session()->get('session_id')]);

                //Afficher la note totale et la moyenne dans la sortie html
                /*$data = [
                    'obtenu' => number_format($coef_totale * 20, 2),
                    'total' => number_format($sum, 2),
                    'moy' => number_format($moy, 2)
                ];*/
                return 1;
            }
        } else {
            return 0;
        }
    }

    function verifyCode()
    {
        $id = request('value');
        $data = Inscription::where('code_secret', $id)
                            ->where('session_id',session()->get('session_id'))
                            ->first();
        if (is_null($data))
            echo '0';
        else
            echo '1';
    }

    public function getMatieres(Request $request)
    {
        if( request('value') != '' )
        {
            $donnees = Inscription::where('code_secret', request('value'))
                                    ->where('session_id', session()->get('session_id'))
                                    ->select('candidat_id', 'option_id')
                                    ->first();

            $id  = $donnees->candidat_id;
            $opt = $donnees->option_id;

            $id_matieres = Note::where('candidat_id', $id)
                                    ->where('session_id', session()->get('session_id'))
                                    ->select('matiere_id', 'note')
                                    ->get();
            $output = '<input id="idtf" type="text" hidden value="' . $id . '" />';
            foreach ($id_matieres as $id_mat)
            {
                $mat = Matiere::where('id', $id_mat->matiere_id)
                                ->firstOrFail();
                $output .= '
                <form method="post" action = "#">
                    <tr>
                        <td hidden>' . $mat->id . '</td>
                        <td>' . $mat->code . '</td>
                        <td>' . $mat->nom . '</td>
                        <td>' . $mat->coef . '</td>
                        <td class="text-center">';
                        if($id_mat->note == '')
                            $output .= '<input class="form-control btn-sm" value="' . $id_mat->note . '" type="number" min="0" max="20" id="note' . $id_mat->matiere_id . '" name="note' . $id_mat->matiere_id . '">';
                        else
                            $output .= '<input class="form-control btn-sm" value="' . $id_mat->note . '" type="number" min="0" max="20" id="note' . $id_mat->matiere_id . '" name="note' . $id_mat->matiere_id . '" disabled>';
                        $output .='</td>
                    </tr>
                </form>
            ';
            }
            echo $output;
        } else {
            echo 'Merde';
        }
    }

    public function getMatieresEdit(Request $request)
    {
        if (request('value') != '') {
            $donnees = Inscription::where('code_secret', request('value'))
                ->where('session_id', session()->get('session_id'))
                ->select('candidat_id', 'option_id')
                ->first();

            $id  = $donnees->candidat_id;
            $opt = $donnees->option_id;

            $id_matieres = Note::where('candidat_id', $id)
                ->where('session_id', session()->get('session_id'))
                ->select('matiere_id', 'note')
                ->get();
            $output = '<input id="idtf" type="text" hidden value="' . $id . '" />';
            foreach ($id_matieres as $id_mat) {
                $mat = Matiere::where('id', $id_mat->matiere_id)
                    ->firstOrFail();
                $output .= '
                <form method="post" action = "#">
                    <tr>
                        <td hidden>' . $mat->id . '</td>
                        <td>' . $mat->code . '</td>
                        <td>' . $mat->nom . '</td>
                        <td>' . $mat->coef . '</td>
                        <td class="text-center">
                            <input class="form-control btn-sm" value="' . $id_mat->note . '" type="number" min="0" max="20" id="note' . $id_mat->matiere_id . '" name="note' . $id_mat->matiere_id . '">
                        </td>
                    </tr>
                </form>
            ';
            }
            echo $output;
        } else {
            echo 'Merde';
        }
    }

}
