@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Gérer les profils</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Accès/Gérer</li>
            </ol>
            @include('flash_message')
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des profils</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Description</th>
                                                <th>Acces autorises</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($profils as $profil)
                                               <tr> 
                                                <td>{{ $profil->nom }}</td>
                                                <td>{{ $profil->description }}</td>
                                                <td class="text-danger">
                                                    {{ $profil->candidat == 1 ? 'Candidats' : '' }} 
                                                        @if(!$profil->candidat == null)<br>@endif
                                                    {{ $profil->convocation == 1 ? 'Convocations' : '' }}
                                                        @if(!$profil->convocation == null)<br>@endif
                                                    {{ $profil->numero == 1 ? 'Numero' : '' }}
                                                        @if(!$profil->numero == null)<br>@endif
                                                    {{ $profil->note == 1 ? 'Notes' : '' }}
                                                        @if(!$profil->note == null)<br>@endif
                                                    {{ $profil->resultat == 1 ? 'Resultats' : '' }}
                                                        @if(!$profil->resultat == null)<br>@endif
                                                    {{ $profil->utilisateur == 1 ? 'Utilisateurs' : '' }}
                                                        @if(!$profil->utilisateur == null)<br>@endif
                                                    {{ $profil->acces == 1 ? 'Acces' : '' }}
                                                        @if(!$profil->acces == null)<br>@endif
                                                    {{ $profil->supplement == 1 ? 'Supplements' : '' }}
                                                        @if(!$profil->supplement == null)<br>@endif
                                                    {{ $profil->reinscription == 1 ? 'Reinscriptions' : '' }}
                                                        @if(!$profil->reinscription == null)<br>@endif                     
                                                </td>
                                                <th class="text-center">
                                                    <a href="/edit_acces/{{ $profil->id }}/edit" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="/delete_acces/{{ $profil->id }}"  onclick="return confirm('Confirmer la suppression de ce profil ?');"  class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </th>
                                               </tr> 
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Description</th>
                                                <th>Acces autorises</th>
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