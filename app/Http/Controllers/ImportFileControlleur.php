<?php

namespace App\Http\Controllers;

use App\Imports\NotesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportFileControlleur extends Controller
{
    //
    public function index()
    {
        return view('candidat.import');
    }

    public function export(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            Excel::import(new NotesImport,request('file'));
            echo 'Succès';
        }
    }
}
