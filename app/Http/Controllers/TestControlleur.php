<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Matiere;
use App\Candidat;
use App\Note;

class TestControlleur extends Controller
{
    //
    function test()
    {
        /*
        $dompdf = new Dompdf();
        $dompdf->loadHTML('<h1>Preview</h1>', 'UTF-8');
        $dompdf->render();
        $dompdf->stream();*/
        return '<iframe src = "http://localhost:9000/storage/cahier_de_charge_eseu.pdf   " width=\'700\' height=\'550\' allowfullscreen webkitallowfullscreen></iframe>';
    }

    function addRecords($id)
    {
        $cdts  = Candidat::join('Inscriptions','Candidats.id','=','Inscriptions.candidat_id')
                        ->where('inscriptions.option_id',$id)
                        ->select('candidats.id','inscriptions.session_id as session')
                        ->get();
        $matieres = Matiere::select('id', 'nom')
                            ->where('option_id', $id)
                            ->where('principal', '1')
                            ->where('session_id',session()->get('session_id')['id'])
                            ->get();
        foreach($cdts as $cdt)
        {
            foreach ($matieres as $mat)
            {
                $note = new Note();
                $note->session_id = $cdt->session;
                $note->candidat_id = $cdt->id;
                $note->matiere_id = $mat->id;
                $note->save();
            }
        }
    }

    function set()
    {
        for($i=1;$i<=500;$i++)
        {
        \DB::insert('INSERT INTO `images`(candidat_id,nom_original,rogne,nom,`type`,chemin,miniature,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?)',
             [
                 $i, 'avatar.jpg', 0, 'avatar.jpg', 'jpg',
                  'http://localhost:8000/storage/candidats_images/avatar.jpg', 'http://localhost:8000/storage/candidats_images/thumbs/avatar.jpg', '2020-08-05 11:07:45', '2020-08-05 11:07:45'
             ]);
        }
    }
}
