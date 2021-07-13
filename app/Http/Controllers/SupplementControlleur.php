<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\option;
use App\Candidat;
use App\inscription;
use App\session;
use App\Note;

class SupplementControlleur extends Controller
{
     //
    function indexReleves()
    {
        $options = Option::all();
        return view('/supplement.releve',compact('options'));
    }

    function indexAttestations()
    {
        $options = Option::all();
        return view('/supplement.attestation', compact('options'));
    }

    function verifyReleve()
    {
        $id = request('value');
        $data = Inscription::join('candidats','inscriptions.candidat_id','=','candidats.id')
                            ->where('candidats.identifiant',$id)
                            ->where('inscriptions.session_id',session()->get('session_id'))
                            ->first();
        if(is_null($data))
            echo '0';
        else
            echo '1';
    }

    function verifyAttestation()
    {
        $id = request('value');
        $data = Inscription::join('candidats', 'inscriptions.candidat_id', '=', 'candidats.id')
                            ->where('candidats.identifiant', $id)
                            ->where('inscriptions.session_id', session()->get('session_id'))
                            ->first();
        $seuil = Session::where('id',session()->get('session_id'))->first();
        if (is_null($data))
            echo '0';
        elseif($data->moyenne >= $seuil->moyenne_passage)
            echo '1';
        else
            echo '2';
    }

    function singleReleve()
    {
        $id = request('value');
        $session = request('session');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $year = Carbon::now()->year;
        $twoDigits = $year%100;
        //echo date("jS F, Y", strtotime("11.12.10"));
        //echo $date1 = Carbon::today()->toDateString();

        if(is_null($session))
            $session = session()->get('session_id');

        $fil = "";
        $data = \DB::table('candidats')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('sessions.numero','sessions.moyenne_passage','candidats.identifiant', 'candidats.id as cdt_id', 'inscriptions.numero_table', 'images.nom as img', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
            ->where('inscriptions.session_id', $session)
            ->where('candidats.identifiant',$id)
                ->orderBy('inscriptions.option_id')
                ->first();
        $outputs = '';
            $mats = $this->getMatieres($data->cdt_id);
            $date = strftime('%d %B %Y', strtotime($data->date_naissance));
            $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
            $ecrit = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
            $outputs .= '
            <html>
                <style>
                    .page_break
                    {
                        page-break-before: always;
                    }
                    .pied
                    {
                        position: fixed;
                        //color:black;
                        bottom: 0px;
                        left: 0px;
                        right: 0px;
                        height: 50px;
                        text-align: center;
                    }
                    .numero
                    {
                        position: fixed;
                        left: 5px;
                        top:200px;
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
                    #titre
                    {
                        margin-top:-5%;
                        display:inline-block;
                        #border:2px solid blue;
                        width:35%;
                        height:100px;
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
                    }

                    #presentation
                    {
                        #background:#28a745;
                        width:70%;
                        margin-top:-16%;
                        margin-left:12%;
                        height:125px;
                        border:2px solid black;
                        #color:white;
                    }

                    @font-face {
                        font-family: "century";
                        src: local("CenturyGothicRegular"), url("fonts/CenturyGothicRegular.ttf") format("truetype");
                        font-weight: normal;
                        font-style: normal;
                    }

                </style>
             <body>
                ';
            $outputs .= '<main>';
            $outputs .= '<div class="entete" align="center" style="font-family:century;" >';
            $outputs .= '
                    <div id="rb" align="center">
                        République du Bénin<br><hr style="width:30px;">
                        Université d\'Abomey-Calavi<br><hr style="width:30px;">
                        Vice recteur ' . $data->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="titre" align="center">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Relevés de notes</strong><br>
                    </div>
                    <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                </div>
                <div class="numero"><span style="font-size:90%;">N°................-' . $twoDigits . '/' . $data->numero . '</div>
                <div align="justify" id="presentation" style="font-family:century;font-size:80%;padding-left:6%;padding-top:1%;">
                    <div><span style="font-size:500%;float:right;color:#28a745;">' . $data->opt_nom . '</span></div>
                    <div>Nom et prénoms : <span style="font-size:110%;color:#007bff;">' . $data->cdt_nom . ' ' . $data->prenoms . '</span></div>
                    <div>Né(e) le ' . $date . ' à ' . $data->lieu_naissance . ' </div>
                    <div>Identifiant : <span style="font-size:110%;color:#007bff;">'.$data->identifiant.'</span> </div>
                    <div>N° d\'inscription : <span style="font-size:110%;color:#dc3545;">' . $data->numero_table . '</span></div>
                    <div style="font-size:110%;">' . $data->session . '</div>
                </div>
                <div class="table-responsive" style="font-family:century;" align="center" >
                    <table class="table table-bordered btn-sm" cellspacing="0" style="font-family:century;font-size:80%;width:100%;padding-left:8%;padding-right:8%;margin-top:0%;" >
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:20px;">Matieres</th>
                                <th style="border:1px solid;padding:12px;">Note/20</th>
                                <th style="border:1px solid;padding:12px;">Coef</th>
                                <th style="border:1px solid;padding:12px;">Points obtenus</th>
                                <th style="border:1px solid;padding:12px;">Sur</th>
                            </tr>
                        </thead>
                        <tbody>';
            $coef_totale = 0;
            $obtenus = 0;
            $surs = 0;
            foreach ($mats as $obj) {
                $obtenu = number_format($obj->coef * $obj->note, 2);
                $sur = number_format($obj->coef * 20, 2);

                $obtenus += $obtenu;
                $surs += $sur;
                $coef_totale += $obj->coef;

                $outputs .= '
                <tr align="center">
                    <td style="border:1px solid;padding:12px;">' . $obj->nom . '</td>
                    <td style="border:1px solid;padding:12px;">' . $obj->note . '</td>
                    <td style="border:1px solid;padding:12px;">' . $obj->coef . '</td>
                    <td style="border:1px solid;padding:12px;">' . $obtenu . '</td>
                    <td style="border:1px solid;padding:12px;">' . $sur . '</td>
                </tr>';
            }

            $moy = Inscription::where('candidat_id', $data->cdt_id)
                ->where('session_id', $session)
                ->select('moyenne')
                ->first();
            
            if ($moy->moyenne > $data->moyenne_passage) {
                $decision = 'Admis';
                $ok = true;
            } else {
                $decision = 'Refusé';
                $ok = false;
            }

            if ($moy->moyenne >= 10 && $moy->moyenne < 12)
                $mention = 'Passable';
            elseif ($moy->moyenne >= 12 && $moy->moyenne < 14)
                $mention = 'Assez-bien';
            elseif ($moy->moyenne >= 14 && $moy->moyenne < 16)
                $mention = 'Bien';
            elseif ($moy->moyenne >= 16 && $moy->moyenne < 18)
                $mention = 'Très-bien';
            elseif ($moy->moyenne >= 18 && $moy->moyenne <= 20)
                $mention = 'Excellent';
            else
                $mention = 'Médiocre';
            
            $outputs .= '</tbody>
                <tfoot>
                    <tr>
                        <th style="border:1px solid;padding:12px;">Total</th>
                        ';
            if(!is_null($moy))
                $outputs .= '
                        <th style="border:1px solid;padding:12px;">' . $moy->moyenne . '</th>';
            else
                $outputs .= '<th style="border:1px solid;padding:12px;"> -- </th>';

            $outputs .='<th style="border:1px solid;padding:12px;">' . $coef_totale . '</th>
                        <th style="border:1px solid;padding:12px;">' . $obtenus . '</th>
                        <th style="border:1px solid;padding:12px;">' . $surs . '</th>
                    </tr>
                </tfoot>
            </table>
            <br>
             </div>
                <div style="font-size:90%;padding-bottom:1%;padding-left:1%;font-family:century;width:30%;float:left;height:100px;border:2px solid black;margin-left:8%;">';

            if ($ok) {
                $outputs .=
                    '<div>Décision du jury : <span style="font-size:150%;color:#28a745;">' . $decision . '</span> </div>
                    <div>Moyenne : <span style="font-size:150%;color:#28a745;">' . $moy->moyenne . '</span><span>/20</span></div>
                    <div>Mention : <span style="font-size:150%;color:#28a745;">' . $mention . '</span></div>';
            } else {
                $outputs .=
                    '<div>Décision du jury : <span style="font-size:150%;color:#dc3545;">' . $decision . '</span> </div>
                   <div>Moyenne : <span style="font-size:150%;color:#dc3545;">' . $moy->moyenne . '</span><span>/20</span></div>
                   <div>Mention : <span style="font-size:150%;color:#dc3545;">' . $mention . '</span></div>';
            }

            $outputs .= '</div>
                <div align="center" style="margin-right:8%;position:fixed;bottom:100px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,' . $data->viceRectorat . '</div><br><br><br><br>
                    <div>' . $data->viceRecteur . '</div>
                </div>
             <div>
             </div>
             <div class="pied" style="font-size:70%;font-family:century;">
             <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de ce relevé</p>
             <hr>
                    <div>Campus Universitaire d\'Abomey-Calavi<br>
                    Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
             </div>
             </main>
            </body>
            </html>';
        /*if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';*/
        $nom = $data->cdt_nom.' '.$data->prenoms.' Releve de notes';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($outputs);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    function singleAttestation()
    {
        $id = request('value');
        $session = request('session');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $year = Carbon::now()->year;
        $twoDigits = $year%100;

        if(is_null($session))
            $session = session()->get('session_id');

        $fil = "";

            $data = \DB::table('candidats')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('sessions.numero','sessions.moyenne_passage','candidats.identifiant', 'candidats.id as cdt_id', 'inscriptions.numero_table', 'images.nom as img', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
            ->where('inscriptions.session_id', $session)
            ->where('candidats.identifiant', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->first();
        
                $moy = Inscription::where('candidat_id', $data->cdt_id)
                ->where('session_id', $session)
                ->select('moyenne')
                ->first();

        if($moy->moyenne >= $data->moyenne_passage)
        {
            $outputs = '';
                $mats = $this->getMatieres($data->cdt_id);
                $date = strftime('%d %B %Y', strtotime($data->date_naissance));
                $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
                $ecrit = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
                $outputs .= '
                <html>
                    <style>
                        .page_break
                        {
                            page-break-before: always;
                        }
                        .pied
                        {
                            position: fixed;
                            //color:black;
                            bottom: 0px;
                            left: 0px;
                            right: 0px;
                            height: 50px;
                            text-align: center;
                        }
                        .numero
                        {
                            position: fixed;
                            left: 5px;
                            top:200px;
                        }
                        .entete
                        {
                            display: inline;
                        }
                        #logo
                        {
                            margin-top:20px;
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
                        #titre
                        {
                            margin-top:-1%;
                            display:inline-block;
                            #border:2px solid blue;
                            width:38%;
                            height:100px;
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
                        }

                        #presentation
                        {
                            #background:#28a745;
                            width:70%;
                            margin-top:-16%;
                            margin-left:12%;
                            height:100px;
                            border:2px solid black;
                            #color:white;
                        }

                        @font-face {
                            font-family: "century";
                            src: local("CenturyGothicRegular"), url("fonts/CenturyGothicRegular.ttf") format("truetype");
                            font-weight: normal;
                            font-style: normal;
                        }

                    </style>
                <body>
                    ';
                $outputs .= '<main>';
                    $outputs .= '<div class="entete" align="center" style="font-family:century;" >';
                $outputs .= '
                        <div id="rb" align="center">
                            République du Bénin<br><hr style="width:30px;">
                            Université d\'Abomey-Calavi<br><hr style="width:30px;">
                            Vice recteur ' . $data->viceRectorat . '<br>
                        </div>
                        <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                        <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                    </div><br>
                    <div class="entete" style="font-family:century;">
                        <div id="rb" align="center">
                        </div>
                        <div id="titre" align="center">
                            <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                            <strong style="font-size:180%;">Attestation de succès</strong><br>
                        </div>
                        <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                    </div>
                    <div class="numero"><span style="font-size:90%;">N°................-' . $twoDigits . '/' . $data->numero . '</div>
                    ';
                
                if ($moy->moyenne > $data->moyenne_passage) {
                    $decision = 'Admis';
                    $ok = true;
                } else {
                    $decision = 'Refusé';
                    $ok = false;
                }

                if ($moy->moyenne >= 10 && $moy->moyenne < 12)
                    $mention = 'Passable';
                elseif ($moy->moyenne >= 12 && $moy->moyenne < 14)
                    $mention = 'Assez-bien';
                elseif ($moy->moyenne >= 14 && $moy->moyenne < 16)
                    $mention = 'Bien';
                elseif ($moy->moyenne >= 16 && $moy->moyenne < 18)
                    $mention = 'Très-bien';
                elseif ($moy->moyenne >= 18 && $moy->moyenne <= 20)
                    $mention = 'Excellent';
                else
                    $mention = 'Médiocre';
                
                $outputs .= '
                        <div style="margin-top:-12%;font-family:century;width:100%;margin-left:1%;margin-right:1%;font-size:110%;line-height:30px;" align="justify">
                            <p>Je soussigné le <span>Vice-Recteur</span>, ' . $data->viceRectorat . ' de
                                l\'Université d\'Abomey-Calavi atteste que :
                                <span style="#margin-left:5%;#margin-right:5%;">
                                <span style="#font-size:120%;">Mme. / M.</span>
                                <span style="#font-size:120%;color:#007bff;">' . $data->prenoms . ' ' . $data->cdt_nom . '</span>
                                , né le <span>' . $date . '</span> à <span style="#font-size:120%;color:#007bff;">' . $data->lieu_naissance . '</span>
                                </span>a participé avec succès à l\'Examen Spécial d\'Entrée à l\'Université (ESEU)
                                <span style="#font-size:120%;color:#28a745">' . $data->session . '</span> en
                                <span style="#font-size:120%;color:#007bff;">Option </span><span style="color:#007bff;"> ' . $data->opt_nom . '</span> avec
                                l\'<span style="#font-size:120%;">identifiant</span><span style="#font-size:120%;color:#007bff;" > ' . $data->identifiant . '</span>
                                au terme duquel il obtient
                                la moyenne de </span><span style="#font-size:120%;color:#28a745">' . $moy->moyenne . '<span style="color:black;font-size:80%;"> / 20</span></span>
                                avec la mention </span><span style="#font-size:120%;color:#dc3545;">' . $mention . '</span>.
                                <br><br>En foi de quoi, la présente attestation de succès lui est délivrée pour servir et valoir ce que de droit.
                            </p>
                        </div>
                    ';


                $outputs .= '
                <br>
                </div>';
                $outputs .= '
                    <div align="center" style="position:fixed;bottom:80px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                        <div>Le Vice-Recteur,' . $data->viceRectorat . '</div><br><br><br><br>
                        <div>' . $data->viceRecteur . '</div>
                    </div>
                <div>
                </div>
                <div class="pied" style="font-size:70%;font-family:century;">
                <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de cette attestation</p>
                <hr>
                        <div>Campus Universitaire d\'Abomey-Calavi<br>
                        Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
                </div>
                </main>
                </body>
                </html>';
            $nom = $data->cdt_nom.' '.$data->prenoms.' Attestation';
            $dompdf = new Dompdf();
            $dompdf->loadHTML($outputs);
            $dompdf->render();
            $dompdf->stream($nom, array("Attachment" => false));
        }
        else
        {
            echo 'Pas d\'attestation disponible pour ce candidat';
        }
    }

    function getMatieres($id)
    {
        $obj = Candidat::where('id',$id)->first();
        $matieres = Note::where('candidat_id', $obj->id)
                            ->join('matieres','notes.matiere_id','=','matieres.id')
                            ->where('matieres.session_id', session()->get('session_id'))
                            ->select('matieres.*', 'note')
                            ->get();
        return $matieres;
    }

    function getReleves()
    {
        ini_set('max_execution_time', 500);
        $old = ini_set('memory_limit', '254M');
        $id = request('option');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $year = Carbon::now()->year;
        $twoDigits = $year%100;
        //echo date("jS F, Y", strtotime("11.12.10"));
        //echo $date1 = Carbon::today()->toDateString();

        $fil = "";
        if ($id != 0) {
            $candidat_data = \DB::table('candidats')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('sessions.numero','sessions.moyenne_passage', 'candidats.identifiant','candidats.id as cdt_id','inscriptions.numero_table','images.nom as img','candidats.date_naissance','candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('inscriptions.option_id', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->get();
        } else {
            $candidat_data = \DB::table('candidats')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('sessions.numero','sessions.moyenne_passage','candidats.identifiant', 'candidats.id as cdt_id', 'inscriptions.numero_table', 'images.nom as img', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->orderBy('inscriptions.option_id')
                ->get();
        }
        $outputs = '';
        $tmp = 0;
        $outputs .= '
        <html>
            <style>
                .page_break
                {
                    page-break-before: always;
                }
                .pied
                {
                    position: fixed;
                    //color:black;
                    bottom: 0px;
                    left: 0px;
                    right: 0px;
                    height: 50px;
                    text-align: center;
                }
                .numero
                {
                    position: fixed;
                    left: 5px;
                    top:190px;
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
                #titre
                {
                    margin-top:-5%;
                    display:inline-block;
                    #border:2px solid blue;
                    width:35%;
                    height:100px;
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
                }

                #presentation
                {
                    #background:#28a745;
                    width:70%;
                    margin-top:-16%;
                    margin-left:12%;
                    height:125px;
                    border:2px solid black;
                    #color:white;
                }

                @font-face {
                    font-family: "century";
                    src: local("CenturyGothicRegular"), url("fonts/CenturyGothicRegular.ttf") format("truetype");
                    font-weight: normal;
                    font-style: normal;
                }

            </style>
         <body>
            ';
        foreach ($candidat_data as $data) {
            $mats = $this->getMatieres($data->cdt_id);
            $date = strftime('%d %B %Y', strtotime($data->date_naissance));
            $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
            $ecrit = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
          
            $outputs.='<main>';
            if ($tmp != 0)
                $outputs .= '<div class="entete page_break" align="center" style="font-family:century;" >';
            else
                $outputs .= '<div class="entete" align="center" style="font-family:century;" >';
            $outputs .= '
                    <div id="rb" align="center">
                        République du Bénin<br><hr style="width:30px;">
                        Université d\'Abomey-Calavi<br><hr style="width:30px;">
                        Vice recteur ' . $data->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="titre" align="center">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Relevés de notes</strong><br>
                    </div>
                    <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                </div>
                <div class="numero"><span style="font-size:90%;">N°................-' . $twoDigits . '/' . $data->numero . '</div>
                <div align="justify" id="presentation" style="font-family:century;font-size:80%;padding-left:6%;padding-top:1%;">
                    <div><span style="font-size:500%;float:right;color:#28a745;">'.$data->opt_nom. '</span></div>
                    <div>Nom et prénoms : <span style="font-size:110%;color:#007bff;">'.$data->cdt_nom.' '.$data->prenoms. '</span></div>
                    <div>Né(e) le '.$date.' à '.$data->lieu_naissance. ' </div>
                    <div>Identifiant : <span style="font-size:110%;color:#007bff;">' . $data->identifiant . '</span> </div>
                    <div>N° d\'inscription : <span style="font-size:110%;color:#dc3545;">'.$data->numero_table. '</span></div>
                    <div style="font-size:110%;">'.$data->session. '</div>
                </div>
                <div class="table-responsive" style="font-family:century;" align="center" >
                    <table class="table table-bordered btn-sm" cellspacing="0" style="font-family:century;font-size:80%;width:100%;padding-left:8%;padding-right:8%;margin-top:0%;" >
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:20px;">Matieres</th>
                                <th style="border:1px solid;padding:12px;">Note/20</th>
                                <th style="border:1px solid;padding:12px;">Coef</th>
                                <th style="border:1px solid;padding:12px;">Points obtenus</th>
                                <th style="border:1px solid;padding:12px;">Sur</th>
                            </tr>
                        </thead>
                        <tbody>';
            $coef_totale = 0;
            $obtenus = 0;
            $surs = 0;
            foreach($mats as $obj)
            {
                $obtenu = number_format($obj->coef*$obj->note,2);
                $sur = number_format($obj->coef*20,2);

                $obtenus += $obtenu;
                $surs += $sur;
                $coef_totale += $obj->coef;

            $outputs .='
                <tr align="center">
                    <td style="border:1px solid;padding:12px;">'.$obj->nom.'</td>
                    <td style="border:1px solid;padding:12px;">'.$obj->note.'</td>
                    <td style="border:1px solid;padding:12px;">'.$obj->coef.'</td>
                    <td style="border:1px solid;padding:12px;">'.$obtenu.'</td>
                    <td style="border:1px solid;padding:12px;">'.$sur.'</td>
                </tr>';
            }

            $moy = Inscription::where('candidat_id', $data->cdt_id)
            ->where('session_id', session()->get('session_id'))
            ->select('moyenne')
                ->first();

            if($moy->moyenne > $data->moyenne_passage)
            {
                $decision = 'Admis';
                $ok = true;
            }
            else
            {
                $decision = 'Refusé';
                $ok = false;
            }
            
            if( $moy->moyenne >= 10 && $moy->moyenne < 12 )
                $mention = 'Passable';
            elseif( $moy->moyenne >=12 && $moy->moyenne < 14 )
                $mention = 'Assez-bien';
            elseif( $moy->moyenne >=14 && $moy->moyenne < 16 )
                $mention = 'Bien';
            elseif( $moy->moyenne >=16 && $moy->moyenne < 18 )
                $mention = 'Très-bien';
            elseif ($moy->moyenne >= 18 && $moy->moyenne <= 20)
                $mention = 'Excellent';
            else
                $mention = 'Médiocre';

            $outputs .= '</tbody>
                <tfoot>
                    <tr>
                        <th style="border:1px solid;padding:12px;">Total</th>';
                        if(!is_null($moy))
                        $outputs .= '
                                <th style="border:1px solid;padding:12px;">' . $moy->moyenne . '</th>';
                    else
                        $outputs .= '<th style="border:1px solid;padding:12px;"> -- </th>';
            $outputs .='<th style="border:1px solid;padding:12px;">'.$coef_totale. '</th>
                        <th style="border:1px solid;padding:12px;">'.$obtenus. '</th>
                        <th style="border:1px solid;padding:12px;">'.$surs. '</th>
                    </tr>
                </tfoot>
            </table>
            <br>
             </div>
                <div style="font-size:90%;padding-bottom:1%;padding-left:1%;font-family:century;width:30%;float:left;height:100px;border:2px solid black;margin-left:8%;">';

            if($ok)
            {
                $outputs .=
                '<div>Décision du jury : <span style="font-size:150%;color:#28a745;">'.$decision. '</span> </div>
                    <div>Moyenne : <span style="font-size:150%;color:#28a745;">'.$moy->moyenne. '</span><span>/20</span></div>
                    <div>Mention : <span style="font-size:150%;color:#28a745;">'.$mention.'</span></div>';
            }else{
                $outputs .=
                '<div>Décision du jury : <span style="font-size:150%;color:#dc3545;">' . $decision . '</span> </div>
                   <div>Moyenne : <span style="font-size:150%;color:#dc3545;">' . $moy->moyenne . '</span><span>/20</span></div>
                   <div>Mention : <span style="font-size:150%;color:#dc3545;">' . $mention . '</span></div>';
            }

            $outputs .= '</div>
                <div align="center" style="margin-right:8%;position:fixed;bottom:100px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,' . $data->viceRectorat . '</div><br><br><br><br>
                    <div>' . $data->viceRecteur . '</div>
                </div>
             <div>
             </div>
             <div class="pied" style="font-size:70%;font-family:century;">
             <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de ce relevé</p>
             <hr>
                    <div>Campus Universitaire d\'Abomey-Calavi<br>
                    Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
             </div>
             </main>
            ';
            $tmp++;
        }
        $outputs .= '
            </body>
            </html>';
        $opt_nom = Option::where('id', $id)->select('nom')->first();
        if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($outputs);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    function getAttestations()
    {
        ini_set('max_execution_time', 500);
        $old = ini_set('memory_limit', '254M');
        $id = request('option');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $year = Carbon::now()->year;
        $twoDigits = $year%100;
        $moy = Session::where('id',session()->get('session_id'))->first();

        $fil = "";
        if ($id != 0) {
            $candidat_data = \DB::table('candidats')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('sessions.numero','sessions.moyenne_passage','sessions.numero','candidats.identifiant', 'candidats.id as cdt_id', 'inscriptions.numero_table', 'images.nom as img', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('inscriptions.option_id', '=', $id)
                ->where('inscriptions.moyenne', '>=', $moy->moyenne_passage)
                ->orderBy('inscriptions.option_id')
                ->get();
        } else {
            $candidat_data = \DB::table('candidats')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('sessions.numero', 'sessions.moyenne_passage','candidats.identifiant', 'candidats.id as cdt_id', 'inscriptions.numero_table', 'images.nom as img', 'candidats.date_naissance', 'candidats.lieu_naissance', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('inscriptions.moyenne', '>=', $moy->moyenne_passage)
                ->orderBy('inscriptions.option_id')
                ->get();
        }
        $outputs = '';
        $tmp = 0;
        $outputs .= '
        <html>
            <style>
                .page_break
                {
                    page-break-before: always;
                }
                .pied
                {
                    position: fixed;
                    bottom: 0px;
                    left: 0px;
                    right: 0px;
                    height: 50px;
                    text-align: center;
                }
                .numero
                {
                    position: fixed;
                    left: 5px;
                    top:200px;
                }
                .entete
                {
                    display: inline;
                }
                #logo
                {
                    margin-top:20px;
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
                #titre
                {
                    margin-top:-3%;
                    display:inline-block;
                    #border:2px solid blue;
                    width:38%;
                    height:100px;
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
                }

                #presentation
                {
                    #background:#28a745;
                    width:70%;
                    margin-top:-16%;
                    margin-left:12%;
                    height:100px;
                    border:2px solid black;
                    #color:white;
                }

                @font-face {
                    font-family: "century";
                    src: local("CenturyGothicRegular"), url("fonts/CenturyGothicRegular.ttf") format("truetype");
                    font-weight: normal;
                    font-style: normal;
                }

            </style>
         <body>
            ';
        foreach ($candidat_data as $data) {
            $mats = $this->getMatieres($data->cdt_id);
            $date = strftime('%d %B %Y', strtotime($data->date_naissance));
            $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
            $ecrit = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
         
            $outputs .= '<main>';
            if ($tmp != 0)
                $outputs .= '<div class="entete page_break" align="center" style="font-family:century;" >';
            else
                $outputs .= '<div class="entete" align="center" style="font-family:century;" >';
            $outputs .= '
                    <div id="rb" align="center">
                        République du Bénin<br><hr style="width:30px;">
                        Université d\'Abomey-Calavi<br><hr style="width:30px;">
                        Vice recteur ' . $data->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="titre" align="center">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:180%;">Attestation de succès</strong><br>
                    </div>
                    <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                </div>
                <div class="numero"><span style="font-size:90%;">N°................-'.$twoDigits.'/'.$data->numero.'</span></div>
                ';
            $moy = Inscription::where('candidat_id', $data->cdt_id)
            ->where('session_id', session()->get('session_id'))
            ->select('moyenne')
                ->first();

            if ($moy->moyenne > $data->moyenne_passage) {
                $decision = 'Admis';
                $ok = true;
            } else {
                $decision = 'Refusé';
                $ok = false;
            }

            if ($moy->moyenne >= 10 && $moy->moyenne < 12)
                $mention = 'Passable';
            elseif ($moy->moyenne >= 12 && $moy->moyenne < 14)
                $mention = 'Assez-bien';
            elseif ($moy->moyenne >= 14 && $moy->moyenne < 16)
                $mention = 'Bien';
            elseif ($moy->moyenne >= 16 && $moy->moyenne < 18)
                $mention = 'Très-bien';
            elseif ($moy->moyenne >= 18 && $moy->moyenne <= 20)
                $mention = 'Excellent';
            else
                $mention = 'Médiocre';
            
            $outputs .='
                    <div style="margin-top:-12%;font-family:century;width:100%;margin-left:1%;margin-right:1%;font-size:110%;line-height:30px;" align="justify">
                        <p>Je soussigné le <span>Vice-Recteur</span>, '.$data->viceRectorat. ' de
                            l\'Université d\'Abomey-Calavi atteste que :
                            <span style="#margin-left:5%;#margin-right:5%;">
                             <span style="#font-size:120%;">Mme. / M.</span>
                              <span style="#font-size:120%;color:#007bff;">'.$data->prenoms.' '.$data->cdt_nom.'</span>
                             , né le <span>'.$date. '</span> à <span style="#font-size:120%;color:#007bff;">'.$data->lieu_naissance. '</span>
                            </span>a participé avec succès à l\'Examen Spécial d\'Entrée à l\'Université (ESEU)
                            <span style="#font-size:120%;color:#28a745">' . $data->session . '</span> en
                            <span style="#font-size:120%;color:#007bff;">Option </span><span style="color:#007bff;"> ' . $data->opt_nom . '</span> avec
                            l\'<span style="#font-size:120%;">identifiant : </span><span style="#font-size:120%;color:#007bff;" > ' . $data->identifiant . '</span>
                            au terme duquel il obtient
                            la moyenne de </span><span style="#font-size:120%;color:#28a745">'. $moy->moyenne .'<span style="color:black;font-size:80%;"> / 20</span></span>
                            avec la mention </span><span style="#font-size:120%;color:#dc3545;">'. $mention .'</span>.
                            <br><br>En foi de quoi, la présente attestation de succès lui est délivrée pour servir et valoir ce que de droit.
                        </p>
                    </div>
                ';


            $outputs .= '
            <br>
             </div>';
            $outputs .= '
                <div align="center" style="position:fixed;bottom:80px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,'.$data->viceRectorat.'</div><br><br><br><br>
                    <div>' . $data->viceRecteur . '</div>
                </div>
             <div>
             </div>
             <div class="pied" style="font-size:70%;font-family:century;">
             <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de cette attestation</p>
             <hr>
                    <div>Campus Universitaire d\'Abomey-Calavi<br>
                    Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
             </div>
             </main>
            ';
            $tmp++;
        }
        $outputs .= '
            </body>
            </html>';
        $opt_nom = Option::where('id', $id)->select('nom')->first();
        if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($outputs);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

}
