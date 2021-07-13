@extends('/layout')
@section('content')
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Créer un profil</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Accès/Créer</li>
            </ol>
        @include('/flash_message')
        <form action="add_profil" method="post" enctype="multipart/form-data">
            @csrf
            @include('/acces/forms')
            <button type="reset" class="btn btn-lg btn-danger col-md-12 mb-4">Annuler</button>
            <button type="submit" class="btn btn-lg btn-success col-md-12">Enregistrer le profil</button>
        </form>
    </div>
</main>
@endsection
