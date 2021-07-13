@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Gérer</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Utilisateurs/Gérer</li>
            </ol>
            @include('flash_message')
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des utilisateurs</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" style="font-size:80%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Prenoms</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Validite</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                               <tr>
                                                <td>{{ $user->nom }}</td>
                                                <td>{{ $user->prenom }}</td>
                                                <td>{{ $user->sexe == 'm' ? 'Homme' : 'Femme'}}</td>
                                                <td>{{ $user->contact }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->status == 1 ? 'Actif' : 'Inactif' }}</td>
                                                <th class="text-center">
                                                    <a href="/edit_user/{{ $user->id }}/edit" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="/delete/{{ $user->id }}" class="btn btn-danger" onclick="return confirm('Confirmer la suppression de cet utilisateur ?');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a href="/focus_user/{{ $user->id }}" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </th>
                                               </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Prenoms</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Actif</th>
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
