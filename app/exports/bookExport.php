<?php

namespace App\Exports;

use App\Candidat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $books;

    public function headings(): array
    {
        return [
            'Identifiant',
            'Option',
            'Nom',
            'Prenoms',
            'Sexe',
            'Contact',
            'Email'
        ];
    }

    public function __construct(int $id)
    {
        $this->option_id = $id;
    }

    public function forOption(int $opt)
    {
        $this->option = $opt;
    }

    public function forResult(int $result)
    {
        $this->result = $result;
    }

    public function query()
    {
        if($this->option_id == 0)
        {
            return Candidat::query()
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.identifiant', 'options.nom', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.sexe', 'candidats.contact', 'candidats.email')
                ->where('inscriptions.session_id', '=', session()->get('session_id'))
                ->orderBy('options.nom')
                ->orderBy('candidats.identifiant');
        }else
        {
            return Candidat::query()
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->join('images', 'candidats.id', '=', 'images.candidat_id')
                ->join('options', 'inscriptions.option_id', '=', 'options.id')
                ->select('candidats.identifiant', 'options.nom', 'candidats.nom as cdt_nom', 'candidats.prenoms', 'candidats.sexe', 'candidats.contact', 'candidats.email')
                ->where('inscriptions.session_id', '=', session()->get('session_id'))
                ->where('inscriptions.option_id',$this->option_id)
                ->orderBy('options.nom')
                ->orderBy('candidats.identifiant');
        }
    }
}
