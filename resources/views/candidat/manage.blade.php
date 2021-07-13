@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Gérer</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Candidats/Gérer</li>
            </ol>
            @include('flash_message')
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des étudiants</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Identifiant</th>
                                                <th>Nom Prenoms</th>
                                                <th>Option</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Oral</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $obj)
                                               <tr>
                                                <td><img src="{{ $obj->miniature }}" width="80px" height="90px" /></td>
                                                <td class="text-center"><br>{{ $obj->identifiant }}</td>
                                                <td class="text-center "><br>{{ $obj->cdt_nom.' '.$obj->prenoms }}</td>
                                                <td class="text-center"><br>{{ $obj->opt_nom }}</td>
                                                <td class="text-center"><br>{{ $obj->sexe == 'm' ? 'Homme' : 'Femme' }}</td>
                                                <td class="text-center"><br>{{ $obj->contact }}</td>
                                                <td class="text-center"><br>{{ $obj->email }}</td>
                                                <td class="text-center"><br>{{ $obj->opt_nom == 'A2' ? 'Dispensé' : ($obj->oralAdmis == '1' ? 'Admis' : 'Refusé') }}</td>
                                                <th class="text-sm-center"><br>
                                                    <a href="/edit_candidat/{{ $obj->id }}/edit" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="/delete_candidat/{{ $obj->id }}" onclick="return confirm('Confirmer la suppression de ce candidat ?');" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a  href="/focus_candidat/{{ $obj->id }}" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </th>
                                               </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Image</th>
                                                <th>Identifiant</th>
                                                <th>Nom Prenoms</th>
                                                <th>Option</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Oral</th>
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
