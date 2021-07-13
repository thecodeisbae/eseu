<?php

namespace App\Http\Controllers;

use App\Candidat;
use App\option;
use App\Note;
use App\session;
use App\Exports\candidatExport;
use App\Image as Pics;
use App\Matiere;
use App\inscription;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\exports\bookExport;
use App\exports\oralExport;
use App\imports\NotesImport;
use Dompdf\Dompdf;
use Carbon\Carbon;

class CandidatControlleur extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('inscriptions.oralAdmis','candidats.id','candidats.identifiant', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.sexe', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email', 'images.miniature')
            ->where('inscriptions.session_id', '=', session()->get('session_id'))
            ->get();
        return view('/candidat/manage', compact('data'));
    }

    public function is_exists($code)
    {
        $data = Candidat::where('code',$code)
                        ->first();
        if($data != null)
            return true;
        else
            return false;
    }

    function chart()
    {
        $opt1 = \DB::table('inscriptions')
                    ->select(\DB::raw('Count(*) as total') )
                    ->where('option_id', '=', '1')
                    ->where('session_id', '=', session()->get('session_id'))
                    ->first();
        $opt2 = \DB::table('inscriptions')
                    ->select(\DB::raw('Count(*) as total'))
                    ->where('option_id', '=', '2')
            ->where('session_id', '=', session()->get('session_id'))
                    ->first();
        $opt3 = \DB::table('inscriptions')
                    ->select(\DB::raw('Count(*) as total') )
                    ->where('option_id', '=', '3')
            ->where('session_id', '=', session()->get('session_id'))
                    ->first();
        $opt4 = \DB::table('inscriptions')
                    ->select(\DB::raw('Count(*) as total'))
                    ->where('option_id', '=', '4')
                    ->where('session_id', '=', session()->get('session_id'))
                    ->first();
        $result = (
            [
                'Options'=>['Option A1','Option A2','Option B','Option C'],
                'Nombres'=>[$opt1->total, $opt2->total, $opt3->total, $opt4->total]
            ]
        );
        return response()->json($result);
    }

    public function generateCode()
    {
        $session_id = session()->get('session_id');
        $pos = Session::where('id',$session_id)
                        ->select('position','start')
                        ->first();
        $index = str_pad($pos->position+1, 4, '0', STR_PAD_LEFT);
        $last = Carbon::createFromDate($pos->start)->year;
        $code = "ESEU-".$index.'-'.$last;
        return $code;
    }

    function getPDF($id)
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
            ->join('images','candidats.id','=','images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('images.nom as img', 'candidats.sexe', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant','options.nom as opt_nom', 'candidats.contact', 'inscriptions.oralAdmis')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->where('inscriptions.option_id', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->orderBy('candidats.identifiant')
                ->get();

            $opt = Option::where('id', $id)->select('nom')->first();
            $fil = $opt->nom;
        } else {
            $candidat_data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->select('images.nom as img','candidats.sexe','candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant','options.nom as opt_nom', 'candidats.contact', 'inscriptions.oralAdmis')
            ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('inscriptions.option_id', '!=', '2')
            ->orderBy('inscriptions.option_id')
            ->orderBy('candidats.identifiant')
            ->get();

            $fil = "A1 - B - C";
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
                        Vice recteur ' . $the_session->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Résultats des oraux</strong><br>
                        <div id="option">Option<br><hr>
                            <strong style="font-size:200%;">' . $fil . '</strong>
                        </div>
                    </div>
                </div>
                ';
        $output .=
        '
        <div style="margin-top:5%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                       <table class="table table-bordered btn-sm" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0"  style="margin-bottom:5%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:2px;">Photo</th>
                                <th style="border:1px solid;padding:2px;">Identifiant</th>
                                <th style="border:1px solid;padding:2px;">Option</th>
                                <th style="border:1px solid;padding:2px;">Nom Prenoms</th>
                                <th style="border:1px solid;padding:2px;">Contact</th>
                                <th style="border:1px solid;padding:2px;">Décision</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        foreach ($candidat_data as $data)
        {
           if($data->oralAdmis)
                $result = 'Admis';
           else
                $result = 'Refusé';
           $output .= '
                <tr>
                    <td style="border:1px solid;padding:2px;" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" width="80px" height="90px"  ></td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->identifiant . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->opt_nom . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->cdt_nom . ' ' . $data->prenoms . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->contact . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $result . '</td>
                </tr>
            ';
        }
        $output .= '
             </tbody>
            </table>
           </div>
           </div>
         </main>
        </body>
        </html>
        ';
        $opt_nom = Option::where('id', $id)->select('nom')->first();
        if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($output);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    function candidatUpload()
    {
        $this->matiere();
        return view('candidat.upload');
        /*$cdt = new CandidatExport();
        return Excel::download($cdt,'test.xlsx');*/
    }

    function matiere()
    {
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $fil = "";
        $candidat_data = \DB::table('matieres')
                            ->join('options','matieres.option_id','=','options.id')
                            ->select('matieres.*','options.nom as option')
                            ->where('matieres.principal','!=','1')
                            ->orderBy('options.nom')
                            ->get();
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
                <div class="entete" style="font-family:century;" >
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:8%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Liste des matieres au choix</strong><br>
                    </div>
                </div>
                ';
        $output .=
        '
        <div style="margin-top:10%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                       <table class="table table-bordered btn-sm" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0"  style="margin-bottom:5%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:2px;">Id</th>
                                <th style="border:1px solid;padding:2px;">Option</th>
                                <th style="border:1px solid;padding:2px;">Nom</th>
                                <th style="border:1px solid;padding:2px;">Coef</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        foreach ($candidat_data as $data) {
            $output .= '
                <tr>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->id . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->option . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->nom . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->coef . '</td>
                </tr>
            ';
        }
        $output .= '
             </tbody>
            </table>
           </div>
           </div>
         </main>
        </body>
        </html>
        ';
        $nom = 'Liste_options.pdf';
        $dompdf = new Dompdf();
        $dompdf->loadHTML($output);
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    function option()
    {
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $fil = "";
        $candidat_data = \DB::table('options')
                            ->get();
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
                <div class="entete" style="font-family:century;" >
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:8%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Liste des options</strong><br>
                    </div>
                </div>
                ';
        $output .=
        '
        <div style="margin-top:8%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                       <table class="table table-bordered btn-sm" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0"  style="margin-bottom:5%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:2px;">Id</th>
                                <th style="border:1px solid;padding:2px;">Nom</th>
                                <th style="border:1px solid;padding:2px;">Critères</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        foreach ($candidat_data as $data)
        {
            $output .= '
                <tr>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->id . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->nom . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->critere . '</td>
                </tr>
            ';
        }
        $output .= '
             </tbody>
            </table>
           </div>
           </div>
         </main>
        </body>
        </html>
        ';
        $nom = 'Liste_options.pdf';
        $dompdf = new Dompdf();
        $dompdf->loadHTML($output);
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    function getListPDF($id)
    {

        $id = request('option');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));

        $fil = "";
        if ($id != 0) {
            $candidat_data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('images','candidats.id','=','images.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('images.nom as img', 'candidats.sexe', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant','options.nom as opt_nom', 'candidats.contact', 'inscriptions.oralAdmis')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->where('inscriptions.option_id', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->orderBy('candidats.identifiant')
                ->get();

            $opt = Option::where('id', $id)->select('nom')->first();
            $fil = $opt->nom;
        } else {
            $candidat_data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->select('images.nom as img','candidats.sexe','candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant','options.nom as opt_nom', 'candidats.contact', 'inscriptions.oralAdmis')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->orderBy('inscriptions.option_id')
            ->orderBy('candidats.identifiant')
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
                        Vice recteur ' . $the_session->viceRectorat . '<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Liste des étudiants</strong><br>
                        <div id="option">Option<br><hr>
                            <strong style="font-size:200%;">' . $fil . '</strong>
                        </div>
                    </div>
                </div>
                ';
        $output .=
        '
        <div style="margin-top:5%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                       <table class="table table-bordered btn-sm" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0"  style="margin-bottom:5%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:2px;">Photo</th>
                                <th style="border:1px solid;padding:2px;">Identifiant</th>
                                <th style="border:1px solid;padding:2px;">Option</th>
                                <th style="border:1px solid;padding:2px;">Nom Prenoms</th>
                                <th style="border:1px solid;padding:2px;">Sexe</th>
                                <th style="border:1px solid;padding:2px;">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        foreach ($candidat_data as $data)
        {
           $output .= '
                <tr>
                    <td style="border:1px solid;padding:2px;" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" width="80px" height="90px"  ></td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->identifiant . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->opt_nom . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->cdt_nom . ' ' . $data->prenoms . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . strtoupper($data->sexe) . '</td>
                    <td style="border:1px solid;padding:2px;" align="center">' . $data->contact . '</td>
                </tr>
            ';
        }
        $output .= '
             </tbody>
            </table>
           </div>
           </div>
         </main>
        </body>
        </html>
        ';
        $opt_nom = Option::where('id', $id)->select('nom')->first();
        if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($output);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
    }

    public function adding()
    {
        $options = Option::all();
        return view('/candidat/add_candidat', compact('options'));
    }

    public function extraction()
    {
        $options = Option::all();
        return view('/candidat/extract', compact('options'));
    }

    public function getMatieres(Request $request)
    {
        $value = request('value');
        $data = \DB::table('matieres')
            ->where('option_id', $value)
            ->where('session_id',session()->get('session_id'))
            ->where('principal', '!=', '1')
            ->get();
        $output = '<option value="0">Choisir matiere</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->nom . '</option>';
        }
        echo $output;
    }

    public function startExtraction(Request $request)
    {

        request()->validate([
            'option' => 'required',
            'excel' => 'required_if:pdf,null',
            'pdf' => 'required_if:excel,null'
        ]);
        $id = request('option');
        if (request('excel') == "on") {
            $book = new bookExport($id);
            $opt_nom = Option::where('id', $id)->select('nom')->first();
            if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.xlsx';
            else $nom = session()->get('session_name') . '-toutes_les_options.xlsx';
            return Excel::download($book, $nom);
        }
        if (request('pdf') == "on") {
            $this->getListPDF($id);
        }
        return back()->with('warning', 'Veuillez choisir un format');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function oralIndex()
    {
        $options = Option::all();
        return view('candidat.oral',compact('options'));
    }

    public function oralImport(Request $request)
    {
        request()->validate(
            [
                'file'=>'required|file'
            ]
        );
        if ($request->hasFile('file'))
        {
            $path = $request->file('file')->getRealPath();
            Excel::import(new NotesImport, request('file'));
            $seuil = Session::where('id',session()->get('session_id'))->firstOrFail();
            \DB::update('update inscriptions set oralAdmis = ? where oral >= ?', [true,$seuil->seuilOral]);
            \DB::update('update inscriptions set oralAdmis = ? where oral < ?', [false, $seuil->seuilOral]);
            return back()->with('success','Importation effectuée avec succès');
        }
    }

    public function oralExport()
    {
        request()->validate([
            'option' => 'required',
            'excel' => 'required_if:pdf,null',
            'pdf' => 'required_if:excel,null'
        ]);
        $id = request('option');
        if (request('excel') == "on") {
            $book = new OralExport($id);
            $opt_nom = Option::where('id', $id)->select('nom')->first();
            if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $opt_nom->nom . '.xlsx';
            else $nom = session()->get('session_name') . '-toutes_les_options.xlsx';
            return Excel::download($book, $nom);
        }
        if (request('pdf') == "on") {
            $this->getPDF($id);
        }
        return back()->with('warning', 'Veuillez choisir un format');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Verifier les champs du formulaire
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'date' => 'required|date',
            'email' => 'required|email',
            'contact' => 'required|numeric|min:8',
            'opt' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        //Recuperer les valeurs des champs
        $nom = request('nom');
        $prenom = request('prenom');
        $sexe = request('sexe');
        $date_nais = request('date');
        $lieu_nais = request('lieu');
        $adresse = request('adresse');
        $pays = request('pays');
        $sm = request('sitMat');
        $travail = request('work');
        $lieu_travail = request('workplace');
        $child = request('child');
        $code = $this->generateCode();
        $email = request('email');
        $contact = request('contact');
        $option = request('opt');
        $matiere_facult = request('mat');

        //Creer un nouveau candidat avec les informations recuperer
        $candidat = new Candidat();
            $candidat->nom = $nom;
            $candidat->prenoms = $prenom;
            $candidat->sexe = $sexe;
            $candidat->date_naissance = $date_nais;
            $candidat->lieu_naissance = $lieu_nais;
            $candidat->adresse = $adresse;
            $candidat->pays = $pays;
            $candidat->sm = $sm;
            $candidat->fonction = $travail;
            $candidat->enfants = $child;
            $candidat->lieu_travail = $lieu_travail;
            $candidat->identifiant = $code;
            $candidat->email = $email;
            $candidat->contact = $contact;
        $candidat->save();

        $session_id = session()->get('session_id');
        $pos = Session::where('id', $session_id)
            ->select('position', 'start')
            ->first();
        \DB::update('update sessions set position = ? where id = ?',
            [$pos->position+1,$session_id]);

        //Ajouter le candidat comme etant inscrit
        $cdt_id = \DB::table('candidats')
            ->select('id')
            ->where('identifiant', '=', $code)
            ->first();
        $inscrit = new Inscription();
        $inscrit->candidat_id = $cdt_id->id;
        $inscrit->user_id = session()->get('user_id');
        $inscrit->session_id = session()->get('session_id');
        $inscrit->option_id = $option;
        $inscrit->save();

        //Ajouter des lignes dans la table note
        $matieres = Matiere::select('id', 'nom')->where('option_id', $option)->where('principal', '1')->where('session_id',session()->get('session_id'))->get();
        if($matiere_facult != null)
        {
            $note = new Note();
            $note->session_id = session()->get('session_id');
            $note->candidat_id = $cdt_id->id;
            $note->matiere_id = $matiere_facult;
            $note->save();
        }
        foreach ($matieres as $mat) {
            $note = new Note();
            $note->session_id = session()->get('session_id');
            $note->candidat_id = $cdt_id->id;
            $note->matiere_id = $mat->id;
            $note->save();
        }


        //Traitement et stockage de l'image
        if ($request->hasFile('image'))
        {
            //Recuperer les infos du cropping
            $photo = request('image');
            $w = request('w');
            $h = request('h');
            $x1 = request('x1');
            $y1 = request('y1');


            $thumbspaths = '';

            //Nom du fichier et son extension
            $filenamewithextension = $photo->getClientOriginalName();
            //Nom du fichier
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //Nom de l'extension
            $extension = $photo->getClientOriginalExtension();
            //Nom a stocké
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            //Televerser fichier
            $photo->storeAs('public/candidats_images', $filenametostore);
            if (!file_exists(public_path('storage/candidats_images/crop'))) {
                mkdir(public_path('storage/candidats_images/crop'), 0755);
            }
            if (!file_exists(public_path('storage/candidats_images/thumbs'))) {
                mkdir(public_path('storage/candidats_images/thumbs'), 0755);
            }
            // crop image
            if (!($w == null & $h == null & $x1 == null & $y1 == null)) {
                $img = Image::make(public_path('storage/candidats_images/' . $filenametostore));
                $croppath = public_path('storage/candidats_images/crop/' . $filenametostore);
                $img->crop($w, $h, $x1, $y1);
                $img->save($croppath);
                // you can save crop image path below in database
                $path = asset('storage/candidats_images/crop/' . $filenametostore);

                $img = Image::make($photo->getRealPath())->resize(100, 100);
                $thumbspaths = public_path('storage/candidats_images/thumbs/' . $filenametostore);
                $img->save($thumbspaths);

                $crop = true;
            } else {
                $img = Image::make($photo->getRealPath())->resize(100, 100);
                $thumbspaths = public_path('storage/candidats_images/thumbs/' . $filenametostore);
                $img->save($thumbspaths);

                $crop = true;
                $path = asset('storage/candidats_images/' . $filenametostore);
                $thumbspaths = asset('storage/candidats_images/thumbs/' . $filenametostore);
                $crop = false;
            }
            //Stocker les informations
            $pic = new Pics();
            $pic->candidat_id = $cdt_id->id;
            $pic->nom_original = $filenametostore;
            $pic->nom = $filenametostore;
            $pic->type = $extension;
            $pic->miniature = $thumbspaths;
            $pic->chemin = $path;
            $pic->rogne = $crop;
            $pic->save();
        }

        //Revenir sur la page
        return back()->with('success', 'Enregistrement effectué');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $obj = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->select('candidats.*', 'images.chemin', 'inscriptions.option_id as opt_id')
            ->where('candidats.id', $id)->firstOrFail();
        $opt = Option::where('id', $obj->opt_id)
            ->select('id', 'nom')
            ->firstOrFail();
        return view('/candidat/focus_candidat', compact('obj', 'opt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $obj = Candidat::join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->select('candidats.*', 'images.chemin', 'images.nom as img_nom', 'inscriptions.option_id as opt_id')
            ->where('candidats.id', $id)->firstOrFail();
        $opt = Option::where('id', $obj->opt_id)
            ->select('id', 'nom')
            ->firstOrFail();
        $options = Option::all();
        return view('/candidat/edit_candidat', compact('obj', 'options', 'opt'));
    }

    /**..
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Candidat $obj, Request $request)
    {
        //
        /* if(request('image'))
            dd(request('image'));
        */
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'date' => 'required|date',
            'work' => 'nullable',
            'workplace' => 'nullable',
            'sitMat' => 'nullable',
            'adresse' => 'nullable',
            'lieu' => 'nullable',
            'child' => 'nullable',
            'code' => 'required',
            'email' => 'required|email',
            'contact' => 'required|numeric|min:8',
            'opt' => 'required',
            'mat' => 'required',
            'image' => 'required'
        ]);
        $data = ([
            'nom' => request('nom'),
            'prenoms' => request('prenom'),
            'sexe' => request('sexe'),
            'date_naissance' => request('date'),
            'fonction' => request('work'),
            'lieu_travail' => request('workplace'),
            'sm' => request('sitMat'),
            'adresse' => request('adresse'),
            'lieu_naissance' => request('lieu'),
            'enfants' => request('child'),
            'code' => request('code'),
            'email' => request('email'),
            'contact' => request('contact')
        ]);
        $obj->update($data);

        /*$cdt_id = \DB::table('candidats')
            ->select('id')
            ->where('identifiant', '=', request('identifiant'))
            ->first();

        \DB::update('update inscriptions set option_id=? where candidat_id=?', [request('opt'), $cdt_id->id]);*/

        if ($request->hasFile('image')) {
            //Recuperer les infos du cropping
            $photo = request('image');
            $w = request('w');
            $h = request('h');
            $x1 = request('x1');
            $y1 = request('y1');
            //Nom du fichier et son extension
            $filenamewithextension = $photo->getClientOriginalName();
            //Nom du fichier
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //Nom de l'extension
            $extension = $photo->getClientOriginalExtension();
            //Nom a stocké
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            //Televerser fichier
            $photo->storeAs('public/candidats_images', $filenametostore);
            if (!file_exists(public_path('storage/candidats_images/crop'))) {
                mkdir(public_path('storage/candidats_images/crop'), 0755);
            }
            if (!file_exists(public_path('storage/candidats_images/thumbs'))) {
                mkdir(public_path('storage/candidats_images/thumbs'), 0755);
            }
            // crop image
            if (!($w == null & $h == null & $x1 == null & $y1 == null)) {
                $img = Image::make(public_path('storage/candidats_images/' . $filenametostore));
                $croppath = public_path('storage/candidats_images/crop/' . $filenametostore);
                $img->crop($w, $h, $x1, $y1);
                $img->save($croppath);
                // you can save crop image path below in database
                $path = asset('storage/candidats_images/crop/' . $filenametostore);

                $img = Image::make($photo->getRealPath())->resize(100, 100);
                $thumbspath = public_path('storage/candidats_images/thumbs/' . $filenametostore);
                $img->save($thumbspath);

                $crop = true;
            } else {
                $img = Image::make($photo->getRealPath())->resize(100, 100);
                $thumbspath = public_path('storage/candidats_images/thumbs/' . $filenametostore);
                $img->save($thumbspath);

                $crop = true;
                $path = asset('storage/candidats_images/' . $filenametostore);
                $thumbpaths = asset('storage/candidats_images/thumbs/' . $filenametostore);
                $crop = false;
            }
            \DB::update('update images set nom_original=?,nom=?,type=?,miniature=?,chemin=?,rogne=? where candidat_id=?', [$filenametostore, $filenametostore, $extension, $thumbpaths, $path, $crop, $cdt_id->id]);
        }

        return redirect('/focus_candidat/' . $obj->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidat $obj)
    {
        //
        $obj->delete();
        return back()->with('success', 'Suppression du candidat effectué');
    }
}
