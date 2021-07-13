<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\session;
use App\Candidat;
use App\option;
use Dompdf\Dompdf;
use Carbon\Carbon;

class ConvocationControlleur extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $options = Option::all();
        return view('/convocation.print_convocation',compact('options'));
    }

    function getPDF()
    {
        ini_set('max_execution_time', 300);
        $old = ini_set('memory_limit', '254M');
        $id = request('option');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        //echo date("jS F, Y", strtotime("11.12.10"));
        //echo $date1 = Carbon::today()->toDateString();

        $fil = "";
        if ($id != 0) {
            $candidat_data = \DB::table('candidats')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('images.nom as img', 'candidats.identifiant','candidats.nom as cdt_nom', 'candidats.prenoms','options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral','sessions.datetimeEcrit','sessions.service','sessions.viceRecteur','sessions.viceRectorat')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->where('inscriptions.option_id', '=', $id)
            ->orderBy('inscriptions.option_id')
            ->get();

        } else {
            $candidat_data = \DB::table('candidats')
            ->join('images','candidats.id','=','images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('images.nom as img','candidats.identifiant','candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
            ->where('inscriptions.session_id', session()->get('session_id'))
            ->orderBy('inscriptions.option_id')
            ->get();
        }
        $outputs = '';
        $tmp = 0;
        foreach($candidat_data as $data) {
            $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
            $ecrit= strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
            $outputs .= '
            <html>
                <style>
                .pied
                    {
                        position: fixed;
                        bottom: 0px;
                        left: 0px;
                        right: 0px;
                        height: 50px;
                        text-align: center;
                    }
                    .page_break
                    {
                        page-break-before: always;
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
                <main>
                ';
            if($tmp != 0)
                $outputs .='<div class="entete page_break" align="center" style="font-family:century;" >';
            else
                $outputs .= '<div class="entete" align="center" style="font-family:century;" >';
            $outputs .='
                    <div id="rb" align="center">
                        République du Bénin<br><hr style="width:30px;">
                        Université d\'Abomey-Calavi<br><hr style="width:30px;">
                        Vice recteur '.$data->viceRectorat.'<br>
                    </div>
                    <div id="uac" align="center"><img src="assets/img/logo.jpg" id="logo"></div>
                    <div id="date" style="font-size:80%;"><br>Abomey-Calavi, le '.$currentDate.'</div>
                </div><br>
                <div class="entete" style="font-family:century;">
                    <div id="rb" align="center">
                    </div>
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">CONVOCATION</strong><br>
                        <div id="option">Option<br><hr>
                            <strong style="font-size:200%;">'.$data->opt_nom. '</strong>
                            </div>
                    </div>
                    <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                </div>
                <div style="font-family:century;margin-top:-8%;">
                    <div>
                        <p>Mme./M. <strong>'.$data->prenoms.' '.$data->cdt_nom. '</strong> <br>
                            Candidat(e) à l\'Examen Spécial d\'Entrée à l\'Université (ESEU) enregistré
                            sous l\'identifiant<strong> '.$data->identifiant.'</strong>,inscrit pour la <strong>'.$data->session. '</strong>
                            est invité(e) à se présenter au campus universitaire d\'Abomey-Calavi pour y subir les épreuves dudit examen qui se dérouleront
                            conformément au calendrier ci-dessous:
                        </p><br>
                        <div style="display:inline;" align="center">
                                <div style="display:inline-block;width:40%;border:1px solid black;margin-left:10%;" align="center">
                                    <strong>Epreuves orales éliminatoire (A1,B et C)</strong>
                                    <hr>
                                    <span style="font-size:80%;">'.$oral. '</span>
                                </div>
                                <div style="display:inline-block;width:40%;border:1px solid black;">
                                    <strong>Epreuves écrites (Toutes options)</strong>
                                    <hr>
                                    <span style="font-size:80%;">'.$ecrit. '</span>
                                </div>
                        </div>
                        <span align="center" style="font-size:150%;">Avis important</span>
                        <div style="font-size:90%;" align="justify">
                            - Les candidats ne sont admis dans la salle que sur présentation de leur convocation et de leur carte nationale d\'identité ou de leur passeport en cours de validité.
                            <br>- Les feuilles de composition et les feuilles de brouillon sont fournies par l\'administration.
                            <br>- Pendant toute la durée des compositions, les téléphones portables ne sont pas admis dans la salle d\'examen. Les documents, de quelque nature que ce soit, autres que ceux autorisés, devront être tenus à l\'écart.
                            <br>- Tout candidat surpris en flagrant délit de fraude sera sanctionné conformément aux dispositions en vigueur.
                        </div>
                        <div>

                <div align="center" style="position:fixed;bottom:80px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,' . $data->viceRectorat . '</div><br><br><br><br>
                    <div>' . $data->viceRecteur . '</div>
                </div>
                        </div>
                    </div>
                </div>
                <div class="pied" style="font-size:70%;font-family:century;">
                <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de cette convocation</p>
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

    function verifyId()
    {
        $id = request('value');
        $data = Candidat::join('inscriptions','candidats.id','=','inscriptions.candidat_id')
                        ->where('candidats.identifiant',$id)
                        ->first();
        if(is_null($data))
            echo '0';
        else
            echo '1';
    }

    function getHisPDF()
    {
        $id = request('value');
        $session = request('session');
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        $currentDate = strftime('%d %B %Y', strtotime(Carbon::now()));
        $fil = "";
        if (is_null($session))
            $session = session()->get('session_id');
            $data = \DB::table('candidats')
            ->join('images', 'candidats.id', '=', 'images.candidat_id')
            ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
            ->join('sessions', 'inscriptions.session_id', '=', 'sessions.id')
            ->join('options', 'inscriptions.option_id', '=', 'options.id')
            ->select('images.nom as img', 'candidats.identifiant', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'options.nom as opt_nom', 'sessions.nom as session', 'sessions.datetimeOral', 'sessions.datetimeEcrit', 'sessions.service', 'sessions.viceRecteur', 'sessions.viceRectorat')
            ->where('inscriptions.session_id', $session)
            ->where('candidats.identifiant',$id)
                ->orderBy('inscriptions.option_id')
                ->first();
            $oral = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeOral));
            $ecrit = strftime('Le %A %d %B %Y à %Hh%M', strtotime($data->datetimeEcrit));
            $outputs = '
            <html>
                <style>
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
                    .page_break
                    {
                        page-break-before: always;
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
                <main>
                <div class="entete" align="center" style="font-family:century;" >
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
                    <div id="uac" align="center" style="margin-top:-5%;">
                        <span>Examen Spécial d\'Entrée à l\'Université (ESEU)</span><br><hr style="width:30px;">
                        <strong style="font-size:175%;">CONVOCATION</strong><br>
                        <div id="option">Option<br><hr>
                            <strong style="font-size:200%;">' . $data->opt_nom . '</strong>
                        </div>
                    </div>
                    <div id="uac" align="center"><img src="storage/candidats_images/thumbs/' . $data->img . '" id="pic"></div>
                </div>
                <div style="font-family:century;margin-top:-8%;">
                    <div>
                        <p>Mme./M. <strong>' . $data->prenoms . ' ' . $data->cdt_nom . '</strong> <br>
                            Candidat(e) à l\'Examen Spécial d\'Entrée à l\'Université (ESEU) enregistré
                            sous l\'identifiant<strong> ' . $data->identifiant . '</strong>,inscrit pour la <strong>' . $data->session . '</strong>
                            est invité(e) à se présenter au campus universitaire d\'Abomey-Calavi pour y subir les épreuves dudit examen qui se dérouleront
                            conformément au calendrier ci-dessous:
                        </p><br>
                        <div style="display:inline;" align="center">
                                <div style="display:inline-block;width:40%;border:1px solid black;margin-left:10%;" align="center">
                                    <strong>Epreuves orales éliminatoire (A1,B et C)</strong>
                                    <hr>
                                    <span style="font-size:80%;">' . $oral . '</span>
                                </div>
                                <div style="display:inline-block;width:40%;border:1px solid black;">
                                    <strong>Epreuves écrites (Toutes options)</strong>
                                    <hr>
                                    <span style="font-size:80%;">' . $ecrit . '</span>
                                </div>
                        </div>
                        <span align="center" style="font-size:150%;">Avis important</span>
                        <div style="font-size:90%;" align="justify">
                            - Les candidats ne sont admis dans la salle que sur présentation de leur convocation et de leur carte nationale d\'identité ou de leur passeport en cours de validité.
                            <br>- Les feuilles de composition et les feuilles de brouillon sont fournies par l\'administration.
                            <br>- Pendant toute la durée des compositions, les téléphones portables ne sont pas admis dans la salle d\'examen. Les documents, de quelque nature que ce soit, autres que ceux autorisés, devront être tenus à l\'écart.
                            <br>- Tout candidat surpris en flagrant délit de fraude sera sanctionné conformément aux dispositions en vigueur.
                        </div>
                        <div>

                <div align="center" style="position:fixed;bottom:80px;width:30%;float:right;height:100px;#border:2px solid black;font-family:century;font-size:80%;">
                    <div>Le Vice-Recteur,' . $data->viceRectorat . '</div><br><br><br><br>
                    <div>' . $data->viceRecteur . '</div>
                </div>
                        </div>
                    </div>
                </div>
                <div class="pied" style="font-size:70%;font-family:century;">
                <p align="left" style="font-size:80%;margin-top:2%;" >NB : Toute rature ou surcharge annule la validité de cette convocation</p>
                <hr>
                        <div>Campus Universitaire d\'Abomey-Calavi<br>
                        Site web : www.uac.bj 01 BP 526 Cotonou Email:vraaru.uac@uac.bj</div>
                </div>
            </main>
            </body>
            </html>';
        if ($id != 0) $nom = session()->get('session_name') . '-Option-' . $data->opt_nom . '.pdf';
        else $nom = session()->get('session_name') . '-toutes_les_Options.pdf';
        $dompdf = new Dompdf();
        //$outputs = $output.$output;
        $dompdf->loadHTML($outputs);
        //$dompdf->setPaper('A4','Landscape');
        $dompdf->render();
        $dompdf->stream($nom, array("Attachment" => false));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $data = Session::where('id', session()->get('session_id'))
            ->firstOrFail();
        $other = ([
            'dateOral' => $data->getDateOral($data->datetimeOral),
            'dateEcrit' => $data->getDateEcrit($data->datetimeEcrit)
        ]);
        return view('/convocation/edit_data', compact('data', 'other'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        request()->validate(
            [
                'session' => 'required',
                'oraldate' => 'required',
                'ecritDate' => 'required',
                'vicerecteur' => 'required'
            ]
        );
        \DB::update('update sessions set
                            nom=?,
                            datetimeOral=?,
                            datetimeEcrit=?,
                            viceRecteur=?
                     where id=?', [
            request('session'),
            request('oraldate'),
            request('ecritDate'),
            request('vicerecteur'),
            $id
        ]);
        $obj = Session::select('nom')->where('id', '=', $id)->first();
        session()->put('session_name', $obj);
        return back()->with('success', 'Informations éditées avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
