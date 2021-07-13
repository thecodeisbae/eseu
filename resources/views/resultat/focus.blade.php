@extends('layout')
@section('haut')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Details</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Resultats/Details</li>
            </ol>
            <div class="card bg-primary col-12 text-center text-light bg-primary my-4"><span class="card-body" style="font-size: 200%;font-weight: bold;" id="displayCode">{{ $obj->identifiant.' : '.$obj->nom.' '.$obj->prenoms }}</span></div>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Matieres</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" style="font-size:80%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Code Matiere</th>
                                                <th>Matiere</th>
                                                <th>Coef</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($matieres as $mat)
                                                <tr>
                                                    <td>{{ $mat->code }}</td>
                                                    <td>{{ $mat->nom }}</td>
                                                    <td>{{ $mat->coef }}</td>
                                                    <td>{{ $mat->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code Matiere</th>
                                                <th>Matiere</th>
                                                <th>Coef</th>
                                                <th>Note</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                    </div>
            </div>
            <div class="card-deck" id="foot">
                <div class="card bg-primary text-light">
                    <div class="card-body">
                        <h5 class="card-title">Point totale obtenus </h5>
                        <hr>
                        <p class="card-text text-right" id="point">
                            <span style="font-size:400%">{{ $obtenu }}</span>
                            <span style="font-size:175%">/{{ $total }}</span>
                        </p>
                    </div>
                </div>
                <div class="card bg-success text-light">
                    <div class="card-body">
                        <h5 class="card-title">Moyenne  </h5>
                        <hr>
                        <p class="card-text text-right" id="moyenne">
                            <span style="font-size:400%">{{ $moy->moyenne }}</span>
                            <span style="font-size:175%;">/20</span>
                        </p>
                    </div>
                </div>'
            </div>
    </div>
</main>
@endsection
