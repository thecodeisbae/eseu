@extends('layout')
@section('content')
<main class="btn-sm">
    <div class="container-fluid">
        <h3 class="mt-4"><strong class="text-success">{{ $session->nom }}</strong></h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Session/Gérer/Active</li>
            </ol>
        <a href="/edit_session/{{ $session->id }}/edit" class="btn btn-lg btn-success col-md-12">Editer cette session</a><br><br>
        <form>
            @csrf
            <div class="card-deck">
                <div class="card bg-transparent text-black mb-4">
                    <div class="card-body" style="margin:30px;">
                        <h3 class="card-title">Informations de la session</h3>
                        <hr>
                        <div class="form-group row">
                            <label class="small mb-1" for="nom">Nom de la session<span class="text-danger" style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="nom" id="nom" type="text" disabled value="{{ $session->nom }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="begin_date">Date de début<span class="text-danger"  style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="begin_date" id="begin_date" type="date" disabled value="{{ $session->start }}"  />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="end_date">Date de fin<span class="text-danger"  style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="end_date" id="date" type="date" disabled value="{{ $session->end }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="status">Définir la session comme : <span class="text-danger"  style="font-size:20px;">*</span></label>
                            <select class="custom-select   my-2" name="status" id="status" disabled >
                                <option value="e" {{ $session->current == '1' ? 'e' : 'd'  }}>{{ $session->current == '1' ? 'Active' : 'Non active' }}</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="login">Lieu<span class="text-danger" style="font-size:20px;"></span></label>
                            <input class="form-control my-2" name="lieu" id="lieu" type="text" disabled value="{{ $session->lieu }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="oral">Moyenne orale<span class="text-danger" style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="oral" id="oral" type="number" min="0" max="20" disabled value="{{ $session->seuilOral }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="vr">Titre Nom et prénoms du Vice recteur<span class="text-danger" style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="vr" id="vr" type="text" disabled value="{{ $session->viceRecteur }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="vrt">Nom complet du vice rectorat<span class="text-danger" style="font-size:20px;">*</span></label>
                            <input class="form-control   my-2" name="vrt" id="vrt" type="text" disabled value="{{ $session->viceRectorat }}" />
                        </div>
                        <div class="form-group row">
                            <label for="service_etude" class="small mb-1">Nom complet du service des études<span class="text-danger" style="font-size:20px;">*</span></label>
                            <input id="service_etude" class="form-control   my-2" type="text" name="service_etude" disabled value="{{ $session->service }}" >
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="date_oral">Date des épreuves orales éliminatoire (A1,B,C) <span class="text-danger"  style="font-size:20px;">*</span></label>
                            <input class="form-control my-2" name="date_oral" id="date_oral" type="text" disabled value="{{ $session->datetimeOral }}" />
                        </div>
                        <div class="form-group row">
                            <label class="small mb-1" for="date_ecrit">Date de épreuves écrites (Toute option) <span class="text-danger"  style="font-size:20px;">*</span></label>
                            <input class="form-control my-2" name="date_ecrit" id="date_ecrit" type="text" disabled value="{{ $session->datetimeEcrit }}" />
                        </div>
                        <div class="form-group row">
                            <label for="passage_moyenne" class="small mb-1">Moyenne de passage <span class="text-danger" style="font-size:20px;">*</span></label>
                            <input id="passage_moyenne" class="form-control   my-2" type="number" min="10" max="20" name="passage_moyenne" disabled value="{{ $session->moyenne_passage }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
