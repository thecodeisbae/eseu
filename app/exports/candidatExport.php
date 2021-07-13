<?php

namespace App\Exports;

use App\Option;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CandidatExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;
    protected $candidats;

    public function headings(): array
    {
        return [
            'Nom *',
            'Prenoms *',
            'Sexe *',
            'Date naissance *',
            'Lieu de naissance',
            'Adresse',
            'Pays',
            'Situation matrimoniale',
            'Enfants',
            'Fonction',
            'Lieu_travail',
            'Email *',
            'Contact *',
            'Option *',
            'Matiere au choix **'
        ];
    }

    public function query()
    {
        return Option::where('id',100)->get();
    }
}
