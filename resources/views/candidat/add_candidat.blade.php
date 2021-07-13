@extends('layout')
@section('haut')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="css/imgareaselect.css" />
    <script src="{{ asset('js/jquery.imgareaselect.js') }}"></script>
    <script src="{{ asset('js/crop.js') }}"></script>
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Enregistrer un candidat</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Candidats/Enregistrer</li>
            </ol>
        @include('flash_message')
        <form action="/add_candidat" method="post" enctype="multipart/form-data">
            @csrf
            @include('/candidat/forms')
            <button type="reset" class="btn btn-lg btn-danger col-md-12 mb-4">Annuler</button>
            <button type="submit" class="btn btn-lg btn-success col-md-12">Enregistrer le candidat</button>
        </form>
    </div>
</main>
@endsection
