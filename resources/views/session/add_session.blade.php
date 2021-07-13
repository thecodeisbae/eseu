@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Créer une session</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Session/Créer</li>
            </ol>
        @include('flash_message')
        <form action="add_session" method="post" enctype="multipart/form-data">
            @csrf
            @include('session/session_forms')
            <button type="reset" class="btn btn-lg btn-primary col-md-12 mb-4">Annuler</button>
            <button type="submit" class="btn btn-lg btn-success col-md-12">Enregistrer la session</button>
        </form>
    </div>
</main>
@endsection
