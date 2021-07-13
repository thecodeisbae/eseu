@extends('layout')
@section('haut')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Editer les informations de <strong class="text-primary">{{ $obj->nom.' '.$obj->prenoms }}</strong> </h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Candidats/Editer</li>
            </ol>
        <form action="/edit_candidat/{{ $obj->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('/candidat/forms')
            <button type="submit" class="btn btn-lg btn-primary col-md-12">Mettre à jour les informations</button>
        </form>
    </div>
</main>
@endsection
<i class="fa fa4-click"></i>

