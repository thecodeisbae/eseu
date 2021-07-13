@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Editer la matiere <strong class="text-primary">{{ $mat->nom }}</strong> </h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Matieres/Editer</li>
            </ol>
        <form action="/edit_matiere/{{ $mat->id }}" method="post" entype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('/session/matiere_forms')
            <button type="submit" class="btn btn-lg btn-primary col-md-12">Mettre à jour la matiere</button>
        </form>
    </div>
</main>
@endsection
<i class="fa fa4-click"></i>
