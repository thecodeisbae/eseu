<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\option;
use App\session;
use App\Candidat;
use App\Note;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\inscription;

class ResultatControlleur extends Controller
{
    //
    public function index()
    {
        $data = \DB::table('candidats')
                    ->join('inscriptions','candidats.id','=','inscriptions.candidat_id')
                    ->join('images','candidats.id','=','images.candidat_id')
                    ->join('options','inscriptions.option_id','=','options.id')
                    ->join('sessions','inscriptions.session_id','=','sessions.id')
                    ->select('candidats.*','options.nom as option','inscriptions.numero_table','inscriptions.moyenne','sessions.moyenne_passage','images.miniature')
                    ->where('inscriptions.session_id','=',session()->get('session_id'))
                    ->get();
        $options = Option::all();
        return view('/resultat.manage',compact('data','options'));
    }

    public function getAll()
    {
            $crit = request('crit');
            $value = request('value');
            $data = $this->getArray($value,$crit);
            $output = '';
            foreach ($data as $user) {
                $output .= '<tr>
                    <td><img src="' . $user->miniature . '"/ width="80px" height="90px"></td>
                    <td>' . $user->identifiant . '</td>
                    <td>' . $user->numero_table . '</td>
                    <td>' . $user->nom . ' ' . $user->prenoms . '</td>
                    <td>' . $user->option . '</td>';
                if ($user->moyenne >= $user->moyenne_passage)
                    $output .= '<td class="text-success" >' . $user->moyenne . '</td>';
                else
                    $output .= '<td class="text-danger" >' . $user->moyenne . '</td>';
                $output .=  '<td>' . $user->contact . '</td>';
                if ($user->moyenne != null) {
                    if ($user->moyenne > $user->moyenne_passage)
                        $output .= '<td>Admis</td>';
                    else
                        $output .= '<td>Refusé</td>';
                } else
                    $output .= '<td>Incertain</td>';
                $output .=  '<th class="text-center">
                        <a href="/focus_result/' . $user->id . '" target="_blank" class="btn btn-outline-success">
                        <i class="fa fa-eye"></i>
                        </a>
                    </th>
                    </tr>';
            }
        echo $output;
    }

    public function getArray($opt,$value)
    {
        $moy_passage = Session::where('id', session()->get('session_id'))->firstOrFail();
        if( $value == 1 )
        {
           return \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->select('candidats.*', 'options.nom as option', 'inscriptions.numero_table', 'inscriptions.moyenne', 'sessions.moyenne_passage', 'images.miniature')
            ->where('inscriptions.session_id', '=', session()->get('session_id'))
            ->where('options.id', '=', $opt)
            ->where('inscriptions.moyenne','>=',$moy_passage->moyenne_passage)
            ->get();
        }
        if( $value == 3 )
        {
            return \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->select('candidats.*', 'options.nom as option', 'inscriptions.numero_table', 'inscriptions.moyenne', 'sessions.moyenne_passage', 'images.miniature')
            ->where('inscriptions.session_id', '=', session()->get('session_id'))
            ->where('options.id', '=', $opt)
            ->where('inscriptions.moyenne', '<=',$moy_passage->moyenne_passage)
            ->get();
        }
        if( $value == 2)
        {
            return \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->select('candidats.*', 'options.nom as option', 'inscriptions.numero_table', 'inscriptions.moyenne', 'sessions.moyenne_passage', 'images.miniature')
            ->where('inscriptions.session_id', '=', session()->get('session_id'))
            ->where('options.id', '=', $opt)
            ->get();
        }
    }

    public function extract()
    {
        $options = Option::all();
        return view('resultat.export',compact('options'));
    }

    public function getPDF()
    {
        ini_set('max_execution_time', 300);
        $old = ini_set('memory_limit', '254M');
        $id = request('option');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));

        $fil = "";
        if ($id != 0) {
            $candidat_data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('inscriptions.numero_table', 'inscriptions.decision', 'images.nom as img','candidats.id as id_cdt', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.sexe', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->where('inscriptions.option_id', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->get();

            $opt = Option::where('id', $id)->select('nom')->first();
            $fil = $opt->nom;
        } else {
            $candidat_data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->select('inscriptions.numero_table','inscriptions.decision','images.nom as img','candidats.id as id_cdt','candidats.date_naissance','candidats.lieu_naissance','candidats.sexe', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->orderBy('inscriptions.option_id')
            ->get();

            $fil = "A1 - A2 - B - C";
        }
        $the_session = \DB::table('sessions')
        ->select('sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
        ->first();
        $output = '
        <html>
                <style>
                    .pied
                    {
                        position: fixed;
                        //color:black;
                        bottom: -15px;
                        left: 0px;
                        right: 0px;
                        height: 50px;
                        text-align: center;
                    }
                    .entete
                    {
                        display: inline;
                    }
                    #logo
                    {
                        margin-top:10px;
                        width:35%;
                        height:90%;
                    }
                    #rb
                    {
                        display:inline-block;
                        #border:2px solid black;
                        width:30%;
                        height:100px;
                    }
                    #uac
                    {
                        display:inline-block;
                        #border:2px solid blue;
                        width:35%;
                        height:100px;
                    }
                    #avatar
                    {

                    }
                    #pic
                    {
                        margin-top:-100px;
                        margin-left:20px;
                        width:40%;
                        height:130%;
                    }
                    #date
                    {
                        display:inline-block;
                        #border:2px solid red;
                        width:35%;
                        height:100px;
                    }
                    #option
                    {
                        border:2px solid black;
                        padding:2%;
                    }

                    @font-face {
                        font-family: "century";
                        src: local("CenturyGothicRegular"), url("fonts/CenturyGothicRegular.ttf") format("truetype");
                        font-weight: normal;
                        font-style: normal;
                    }

                </style>
                <body>

            <footer class="pied" style="font-size:70%;font-family:century;">
                <hr>
                        <div>Campus Universitaire d\'Abomey-Calavi<br>
                        Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
            </footer>
                <main>
                <div class="entete" align="center" style="font-family:century;" >
                    <div id="rb" align="center">
                        République du Bénin<br><hr style="width:30px;">
                        Université d\'Abomey-Calavi<br><hr style="width:30px;">
                        Vice rectorat ' . $the_session->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:150%;">Procès verbal de délibération</strong><br>
                        <div id="option">Option : '.$fil. '<br><hr>
                        ' . $the_session->session . '
                        </div>
                    </div>
                </div>
                ';
        $output .=
        '
        <div style="margin-top:8%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                       <table class="table table-bordered btn-sm" id="dataTable" width="100%" cellspacing="0"  style="margin-bottom:5%;font-size:80%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:2px;">Identifiant</th>
                                <th style="border:1px solid;padding:2px;">Nom Prenoms Date et lieu de naissance</th>';
        $n = \DB::table('matieres')->where('session_id',session()->get('session_id'))->where('option_id',1)
                    ->where('principal',1)->count();
        for($i=1;$i<=$n;$i++)
            $output .= '<th style="border:1px solid;padding:2px;">Note '.$i.'</th>';
                        $output .='<th style="border:1px solid;padding:2px;">Resultat</th>
                            </tr>
                        </thead>
                        <tbody align="center">
        ';
        foreach ($candidat_data as $data)
        {
            $id_matieres = Note::where('candidat_id', $data->id_cdt)
                ->where('session_id', session()->get('session_id'))
                ->select('matiere_id', 'note')
                ->get();
            $date = strftime('%d %B %Y', strtotime($data->date_naissance));
            if($data->decision)
                $result = 'Admis';
            else
                $result = 'Refusé';
            $output .= '
                <tr>
                    <td style="border:1px solid;padding:2px;">' . $data->identifiant . '</td>
                    <td style="border:1px solid;padding:4px;" align="justify">' . $data->cdt_nom . ' ' . $data->prenoms . '<br>
                         Né(e) le ' . $date . ' à ' . $data->lieu_naissance . '
                    </td>';
            foreach($id_matieres as $element)
            {
                if(is_null($element->note))
                    $output .= '<td style="border:1px solid;padding:2px;"> - </td>';
                else
                    $output .= '<td style="border:1px solid;padding:2px;">' . $element->note . '</td>';
            }
            if($data->decision)
                $output .= '<td style="border:1px solid;padding:2px;"><span style="color:#28a745;">' . $result . '</span></td>';
            else
                $output .= '<td style="border:1px solid;padding:2px;"><span style="color:#dc3545;">' . $result . '</span></td>';
            $output .='</tr>';
        }
        $output .= '
             </tbody>
            </table>
           </div>
           </div>
         </main>
         <!-- <div align="center" style="position:fixed;bottom:90px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,' . $the_session->viceRectorat . '</div><br><br><br><br>
                    <div>' . $the_session->viceRecteur . '</div>
            </div> -->
        </body>
        </html>
        ';
        $opt_nom = Option::where('id', $id)->select('nom')->first();
        if ($id != 0) $nom = 'PV-'.session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = 'PV-'.session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($output);
        /*$size = array(0,0,900,612);
        $dompdf->setPaper($size,'portrait');*/
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    public function show($id)
    {
        $obj = Candidat::where('id',$id)->first();
        $matieres = Note::where('candidat_id', $obj->id)
                            ->join('matieres','notes.matiere_id','=','matieres.id')
                            ->where('notes.session_id', session()->get('session_id'))
                            ->select('matieres.*', 'note')
                            ->get();
        $total = 0;
        $obtenu = 0;
        $moy = Inscription::where('candidat_id',$id)
                            ->where('session_id',session()->get('session_id'))
                            ->select('moyenne')
                            ->first();
        //Recuperer les matieres du candidat d'id $id
        $matieres_cdt = Note::where('candidat_id', $id)
        ->where('session_id', session()->get('session_id'))
        ->get();
        if ($matieres_cdt != null) {
            //Verifier si toutes les matieres ont des notes associes
            $ok = true;
            foreach ($matieres_cdt as $mat)
                if ($mat->note == null)
                    $ok = false;

            //Recuperer les notes du candidat
            $notes = array();
            foreach ($matieres as $cdt)
                array_push($notes, $cdt->note);

            //Recuperer les coefficients pour les notes
            $coefs = array();
            $coef_totale = 0;
            foreach ($matieres as $cdt) {
                array_push($coefs, $cdt->coef);
                $coef_totale += $cdt->coef;
            }

            //Calculer la moyenne
            if ($coefs != null && $notes != null && count($coefs) == count($notes))
            {
                $sum = 0;
                for ($x = 0; $x < count($notes); $x++) {
                    $sum += $coefs[$x] * $notes[$x];
                }
                $obtenu = number_format($sum,2);
                $total = number_format($coef_totale*20,2);

            }
            else
            {
                $obtenu = 0;
                $total = number_format($coef_totale*20,2);
            }
        }
         else
        {
        }

        return view('/resultat.focus',compact('obj','matieres','obtenu','total','moy'));


    }

    public function getByCriteres()
    {
            $opt = request('opt');
            $value = request('value');
            $data = $this->getArray($opt,$value);
            $output = '';
            foreach ($data as $user) {
                $output .= '<tr>
                    <td align="center"><img src="' . $user->miniature . '" width="80px" height="90px"/></td>
                    <td>' . $user->identifiant . '</td>
                    <td>' . $user->numero_table . '</td>
                    <td>' . $user->nom . ' ' . $user->prenoms . '</td>
                    <td>' . $user->option . '</td>';
                if ($user->moyenne >= $user->moyenne_passage)
                    $output .= '<td class="text-success" >' . $user->moyenne . '</td>';
                else
                    $output .= '<td class="text-danger" >' . $user->moyenne . '</td>';
                $output .=  '<td>' . $user->contact . '</td>';
                if ($user->moyenne != null) {
                    if ($user->moyenne > $user->moyenne_passage)
                        $output .= '<td>Admis</td>';
                    else
                        $output .= '<td>Refusé</td>';
                } else
                    $output .= '<td>Incertain</td>';
                $output .=  '<th class="text-center">
                        <a href="/focus_result/' . $user->id . '" target="_blank" class="btn btn-outline-success">
                        <i class="fa fa-eye"></i>
                        </a>
                    </th>
                    </tr>';
            }
        echo $output;
    }
}
