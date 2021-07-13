@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Gérer</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Sessions/Gérer</li>
            </ol>
            @include('flash_message')
            <a href="focus_session/{{ session()->get('session_id') }}" class="btn btn-lg btn-success col-12 mb-4">Session active</a>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des sessions</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Date debut</th>
                                                <th>Date fin</th>
                                                <th>Active</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sessions as $session)
                                               <tr>
                                                <td>{{ $session->nom }}</td>
                                                <td>{{ $session->start }}</td>
                                                <td>{{ $session->end }}</td>
                                                <td>{{ $session->current == 1 ? 'En cours' : 'Cloturée'}}</td>
                                                <th class="text-center">
                                                    <a href="/focus_session/{{ $session->id }}" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="/edit_session/{{ $session->id }}/edit" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="/delete_session/{{ $session->id }}" onclick="return confirm('Confirmer la suppression de cette session ?');" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </th>
                                               </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Date debut</th>
                                                <th>Date fin</th>
                                                <th>Active</th>
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
