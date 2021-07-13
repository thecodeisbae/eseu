<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\option;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\codeExport;
use App\Candidat;
use App\inscription;
use PDF;
use Dompdf\Dompdf;

class NumeroControlleur extends Controller
{
    //
    public function index()
    {
        $data = \DB::table('candidats')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant', 'inscriptions.numero_table', 'inscriptions.code_secret', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->get();
        return view('/numero.generate', compact('data'));
    }

    public function show()
    {
        $id = request('value');
        $output = '';
        if ($id == 0) {
            $data = \DB::table('candidats')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.code', 'inscriptions.numero_table', 'inscriptions.code_secret', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->get();
            foreach ($data as $obj) {
                $output .= '<tr>
                            <td>' . $obj->code . '</td>
                            <td>' . $obj->numero_table . '</td>
                            <td>' . $obj->code_secret . '</td>
                            <td>' . $obj->cdt_nom . ' ' . $obj->prenoms . '</td>
                            <td>' . $obj->contact . '</td>
                            <td>' . $obj->email . '</td>
                          </tr>';
            }
        } else {
            $data = \DB::table('candidats')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.code', 'inscriptions.numero_table', 'inscriptions.code_secret', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('options.id', $id)
                ->get();
            foreach ($data as $obj) {
                $output .= '<tr>
                            <td>' . $obj->code . '</td>
                            <td>' . $obj->numero_table . '</td>
                            <td>' . $obj->code_secret . '</td>
                            <td>' . $obj->cdt_nom . ' ' . $obj->prenoms . '</td>
                            <td>' . $obj->contact . '</td>
                            <td>' . $obj->email . '</td>
                        </tr>';
            }
        }
        echo $output;
    }

    public function extract()
    {
        $options = Option::all();
        return view('/numero.extract', compact('options'));
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
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant', 'inscriptions.numero_table', 'inscriptions.code_secret', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
                ->where('inscriptions.session_id', session()->get('session_id'))
                ->where('inscriptions.option_id', '=', $id)
                ->orderBy('inscriptions.option_id')
                ->get();

            $opt = Option::where('id', $id)->select('nom')->first();
            $fil = $opt->nom;
        }
        else
        {
            $candidat_data = \DB::table('candidats')
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.identifiant', 'inscriptions.numero_table', 'inscriptions.code_secret', 'options.nom as opt_nom', 'candidats.contact', 'candidats.email')
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
                    <div id="date"><br>Abomey-Calavi,le ' . $currentDate . '</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">Listes des candidats</strong><br>
                        <div id="option">Option<br><hr>
                            <strong style="font-size:200%;">' . $fil . '</strong>
                        </div>
                    </div>
                </div>
                ';
        $output .= '
        <div style="margin-top:5%;">
              <div class="table-responsive" align="center" style="#background-color:cyan;font-size:80%;font-family:century;">
                    <table class="table table-bordered btn-sm" id="dataTable" width="100%" cellspacing="0" style="margin-bottom:5%;">
                        <thead>
                            <tr>
                                <th style="border:1px solid;padding:12px;">Identifiant</th>
                                <th style="border:1px solid;padding:12px;">N° de table</th>
                                <th style="border:1px solid;padding:12px;">Code secret</th>
                                <th style="border:1px solid;padding:12px;">Nom Prenoms</th>
                                <th style="border:1px solid;padding:12px;">Contact</th>
                                <th style="border:1px solid;padding:12px;">Email</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        foreach ($candidat_data as $data) {
            $output .= '
                <tr>
                    <td style="border:1px solid;padding:12px;">' . $data->identifiant . '</td>
                    <td style="border:1px solid;padding:12px;">' . $data->numero_table . '</td>
                    <td style="border:1px solid;padding:12px;">' . $data->code_secret . '</td>
                    <td style="border:1px solid;padding:12px;">' . $data->cdt_nom . ' ' . $data->prenoms . '</td>
                    <td style="border:1px solid;padding:12px;">' . $data->contact . '</td>
                    <td style="border:1px solid;padding:12px;">' . $data->email . '</td>
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
        $dompdf->stream($nom,array("Attachment" => false));

    }

    public function startExtract(Request $request)
    {
        request()->validate([
            'option' => 'required',
            'excel' => 'required_if:pdf,null',
            'pdf' => 'required_if:excel,null'
        ]);
        $id = request('option');
        if (request('excel') == "on") {
            $book = new codeExport($id);
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

    public function generate()
    {
        //Recuperer les id des candidats dans les differentes options pour la generation des codes secrets
        $option1 = \DB::table('inscriptions')
            ->where('option_id', '1')
            ->where('session_id', session()->get('session_id'))
            ->select('id')
            ->get();
        $option2 = \DB::table('inscriptions')
            ->where('option_id', '2')
            ->where('session_id', session()->get('session_id'))
            ->select('id')
            ->get();
        $option3 = \DB::table('inscriptions')
            ->where('option_id', '3')
            ->where('session_id', session()->get('session_id'))
            ->select('id')
            ->get();
        $option4 = \DB::table('inscriptions')
            ->where('option_id', '4')
            ->where('session_id', session()->get('session_id'))
            ->select('id')
            ->get();

        $annee = \DB::table('sessions')
            ->where('id', session()->get('session_id'))
            ->select('start')
            ->first();

        //Recuperer l'annee d'ouverture de la session
        $an = new Carbon($annee->start);
        $an = $an->year;

        //Ajouter les codes secrets et n° de table
        $this->add_code($option1, $an, 'A1');
        $this->add_code($option2, $an, 'A2');
        $this->add_code($option3, $an, 'B');
        $this->add_code($option4, $an, 'C');

        return back()->with('success', 'Generation des numeros de table et des codes secrets effectues avec succes');
    }

    function random_str(int $length = 6, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    function is_exists(string $code)
    {
        return \DB::table('inscriptions')->where('code_secret', '=', $code)->count();
    }

    function add_code(Object $table, $an, $opt_nom)
    {
        $n = 1;
        foreach ($table as $opt) {
            //Generer le numero de table
            $mat = str_pad($n, 4, '0', STR_PAD_LEFT);
            $numero = "$an-$opt_nom-$mat";

            //Generer le code secret unique
            $ok = true;
            do {
                $code = $this->random_str(6);
                if ($this->is_exists($code) > 0)
                    $ok = false;
                else
                    $ok = true;
            } while (!$ok);
            \DB::update('update inscriptions set numero_table=?,code_secret=? where id=?', [$numero, $code, $opt->id]);
            $n++;
        }
    }
}
