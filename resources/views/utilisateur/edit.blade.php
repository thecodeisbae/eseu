    @extends('layout')
    @section('content')
    <main>
        <div class="container-fluid">
            <h3 class="mt-4">Editer le profil de <strong class="text-primary">{{ $user->identifiant }}</strong> </h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Utilisateurs/Editer</li>
                </ol>
                @include('flash_message')
            <form action="/edit_user/{{ $user->id }}" method="post" entype="multipart/form-data">
                @csrf
                @method('PATCH')
                @include('utilisateur/forms')
                <button type="submit" class="btn btn-lg btn-primary col-md-12">Mettre à jour le profil</button>
            </form>
        </div>
    </main>
    @endsection
    <i class="fa fa4-click"></i>
