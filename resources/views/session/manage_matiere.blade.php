@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Gérer les matieres</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Matieres/Gérer</li>
            </ol>
            @include('flash_message')
            <a href="add_matiere" class="btn btn-lg btn-primary col-12 mb-4">Ajouter une matière</a>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des matières</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" style="font-size:80%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Code matiere</th>
                                                <th>Option</th>
                                                <th>Nom</th>
                                                <th>Coef</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($matieres as $mat)
                                               <tr>
                                                <td>{{ $mat->code }}</td>
                                                <td>{{ $mat->opt_nom }}</td>
                                                <td>{{ $mat->nom }}</td>
                                                <td>{{ $mat->coef }}</td>
                                                <td>{{ $mat->principal == 1 ? 'Obligatoire' : 'Au choix' }}</td>
                                                <th class="text-center">
                                                    <a href="/edit_matiere/{{ $mat->id }}/edit" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="delete_matiere/{{ $mat->id }}" onclick="return confirm('Confirmer la suppression de cette matiere ?');" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </th>
                                               </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code matiere</th>
                                                <th>Option</th>
                                                <th>Nom</th>
                                                <th>Coef</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                    </div>
            </div>
    </div>
</main>
@endsection
