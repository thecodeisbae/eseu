<?php

namespace App\Imports;
use App\Candidat;
use App\Inscription;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class NotesImport implements ToModel
{
    public function model(array $row)
    {
        if($row[0] != 'Identifiant')
        {
            $id = Candidat::where('identifiant',$row[0])->firstOrFail();
            //dd($id->id);
            \DB::update('update inscriptions set oral = ? where candidat_id = ? and session_id= ?', [$row[5],$id->id,session()->get('session_id')['id']]);
        }
    }
}
