@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Ajouter une matière</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Matieres/Ajouter</li>
            </ol>
            @include('flash_message')
            <form action="add_matiere" method="post" enctype="multipart/form-data">
                @csrf
                @include('session/matiere_forms')
                <div class="form-group">
                    <button type="reset" class="btn btn-lg btn-danger col-12 ">Annuler</button>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-success col-12">Enregistrer la matiere</button>
                </div>
            </form>
    </div>
</main>
@endsection
