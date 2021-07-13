@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Editer les informations</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Convocation/Editer</li>
            </ol>
        @include('flash_message')
        <div class="card bg-transparent text-dark" style="padding:50px;">
            <h3>Formulaire</h3>
            <hr>
            <form style="padding:20px;" action="/edit_data/{{ session()->get('session_id') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="session" class="small ">Nom de la session</label>
                    <input id="session" class="form-control" type="text" name="session" value="{{ old('value') ?? ( $data->nom ?? '' ) }}">
                </div>
                <div class="form-group">
                    <label for="oraldate" class="small ">Date des épreuves orales éliminatoires ( A1,B,C )</label>
                    <input id="oraldate" class="form-control" type="datetime-local" name="oraldate" value="{{ old('value') ?? ( $other['dateOral'] ?? '' ) }}">
                </div>
                <div class="form-group">
                    <label for="ecritDate" class="small ">Date des épreuves écrites ( Toutes les options )</label>
                    <input id="ecritDate" class="form-control" type="datetime-local" name="ecritDate" value="{{ old('value') ?? ( $other['dateEcrit'] ?? '' ) }}">
                </div>
                <div class="form-group">
                    <label for="vicerecteur" class="small ">Titre Nom et Prénoms du vice-recteur</label>
                    <input id="vicerecteur" class="form-control mb-4" type="text" name="vicerecteur" value="{{ old('value') ?? ( $data->viceRecteur ?? '' ) }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg col-12">Mettre à jour les informations</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
