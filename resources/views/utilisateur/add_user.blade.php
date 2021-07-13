@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Enregistrer un utilisateur</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Utilisateurs/Enregistrer</li>
            </ol>
            @include('flash_message')
        <form action="/add_user" method="post" entype="multipart/form-data">
            @csrf
            @include('utilisateur/forms')
            <button type="reset" class="btn btn-lg btn-danger col-md-12 mb-4">Annuler</button>
            <button type="submit" class="btn btn-lg btn-success col-md-12">Enregistrer l'utilisateur</button>
        </form>
    </div>
</main>
@endsection
<i class="fa fa4-click"></i>
