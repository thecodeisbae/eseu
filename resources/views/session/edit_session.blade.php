@extends('/layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Editer <strong class="text-primary">{{ $session->nom }}</strong> </h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Sessions/Editer</li>
            </ol>
            @include('/flash_message')
        <form action="/edit_session/{{ $session->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('/session/session_forms')
            <button type="submit" class="btn btn-lg btn-primary col-md-12">Mettre à jour la session</button>
        </form>
    </div>
</main>
@endsection
<i class="fa fa4-click"></i>
