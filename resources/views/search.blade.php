@extends('layout')
@section('content')
<main>
<div class="container-fluid">
        <h3 class="mt-4">Résultats de recherches pour : <span class="text-success">{{ $search }} </span><span style="font-size: 60%;" class="text-bold">( {{ $n }} correspondance(s) )</span></h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Recherche</li>
            </ol>
    <div class="card-columns">
    @foreach($datas as $data)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <img align="left" src="{{ $data->miniature }}" alt="" width="85px" height="100px"  srcset="">
                    <span align="right" style="font-size: 70%;">{{ $data->cdt_prenoms.' '.$data->cdt_nom }} (Option <span class="text-warning text-bold">{{ $data->option }}</span>)</span>
                </h5>
                <hr>
                <p class="card-text" align="right">
                    <span class="text-success">{{ $data->session }}</span><br>
                    Identifiant : <span class="text-danger">{{ $data->identifiant }}</span> <br>
                    N° table : <span class="text-primary">{{ $data->n_table }}</span> <br>
                    Admissibilité oral : {{ $data->oralAdmis ? 'Admis' : 'Refusé' }}<br>
                    Moyenne : {{ $data->moyenne }} <br>
                    Decision jury : {{ $data->decision ? 'Admis' : 'Refusé' }}
                </p> <hr>
                <div align="center" class="row">
                    <div class="col-6">
                        <form target="_blank" method="POST" action="/focus">
                            @csrf
                                <input type="text" hidden value="{{ $data->identifiant }}" name="value" id="value">
                                <input type="text" hidden value="{{ $data->sessid }}" name="session" id="session">
                                <button type="submit" class="btn btn-outline-primary col-12" align="center">Détails</button>
                        </form>
                    </div>
                    <div class="btn-group dropright col-6 ">
                        <button class="btn btn-success col-12 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu btn-sm" aria-labelledby="dropdownMenuButton">
                            <form target="_blank" method="POST" action="/singleAttestation">
                                @csrf
                                <input type="text" hidden value="{{ $data->identifiant }}" name="value" id="value">
                                <input type="text" hidden value="{{ $data->sessid }}" name="session" id="session">
                                <button class="dropdown-item" type="submit">Attestation</button>
                            </form>
                            <form target="_blank" method="POST" action="/singleConvocation">
                                @csrf
                                <input type="text" hidden value="{{ $data->identifiant }}" name="value" id="value">
                                <input type="text" hidden value="{{ $data->sessid }}" name="session" id="session">
                                <button class="dropdown-item" type="submit">Convocation</button>
                            </form>
                            <form target="_blank" method="POST" action="/singleReleve">
                                @csrf
                                <input type="text" hidden value="{{ $data->identifiant }}" name="value" id="value">
                                <input type="text" hidden value="{{ $data->sessid }}" name="session" id="session">
                                <button class="dropdown-item" type="submit">Relevé</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
</main>
@endsection
