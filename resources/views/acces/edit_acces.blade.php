@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Editer le profil <strong class="text-primary">{{ $profil->nom }}</strong> </h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Matieres/Editer</li>
            </ol>
        <form action="/edit_acces/{{ $profil->id }}" method="post" entype="multipart/form-data">            
            @csrf
            @method('PATCH')
            @include('/acces/forms')
            <button type="submit" class="btn btn-lg btn-primary col-md-12">Mettre à jour le profil</button>
        </form>
    </div>        
</main>
@endsection
<i class="fa fa4-click"></i>