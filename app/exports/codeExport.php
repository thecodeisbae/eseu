<?php

namespace App\Exports;

use App\Candidat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class codeExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $books;

    public function headings(): array
    {
        return [
            'Identifiant',
            'N° de table',
            'Code secret',
            'Nom',
            'Prenoms',
            'Email',
            'Contact'
        ];
    }

    public function __construct(int $option)
    {
        $this->option_id = $option;
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
        if( $this->option_id != 0 )
        {    return Candidat::query()
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->where('inscriptions.option_id', '=', $this->option_id)
                ->where('inscriptions.session_id', '=', session()->get('session_id'))
                ->select('Candidats.identifiant', 'Inscriptions.numero_table', 'Inscriptions.code_secret', 'Candidats.nom', 'Candidats.prenoms', 'Candidats.email', 'Candidats.contact')
                ->orderBy('Inscriptions.numero_table');
        }
        else
        {
            return Candidat::query()
                ->join('inscriptions', 'candidats.id', '=', 'inscriptions.candidat_id')
                ->where('inscriptions.session_id', '=', session()->get('session_id'))
                ->select('Candidats.identifiant', 'Inscriptions.numero_table', 'Inscriptions.code_secret', 'Candidats.nom', 'Candidats.prenoms', 'Candidats.email', 'Candidats.contact')
                ->orderBy('Inscriptions.numero_table');
        }
    }
}
