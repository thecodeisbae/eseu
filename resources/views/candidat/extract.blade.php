@extends('layout')
@section('content')
<main>
            <div class="container-fluid">
                <h3 class="mt-4">Extraire liste</h3>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Candidats/Extraire liste</li>
                    </ol>
                     @include('flash_message')
                <div class="card-deck" >
                        <div class="card bg-transparent text-black mb-4">
                            <div class="card-body">
                                <h3 class="card-title">Critères</h3>
                                <hr style="background-color:black;">
                                 <form target="_blank" action="/extract" method="post" enctype="multipart/form-data">
                                 @csrf
                                        <label class="my-1 mr-2" for="">Option</label>
                                        <select name="option" class="custom-select my-1 mr-sm-2">
                                            <option value="0" selected>Tous</option>
                                            @foreach($options as $opt)
                                                <option value="{{ $opt->id }}" >{{ $opt->nom }}</option>
                                            @endforeach
                                        </select>
                            </div>
                        </div>
                        <div class="card bg-transparent text-black mb-4">
                          <div class="card-body">
                                <h3 class="card-title">Formats</h3>
                                <hr style="background-color:black;">
                                    <br>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="pdf" name="pdf"  >
                                        <label class="custom-control-label" for="pdf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pdf (*.pdf)</label>
                                    </div>
                                    <br>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="excel" name="excel">
                                        <label class="custom-control-label" for="excel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel (*.xslx)</label>
                                    </div>
                                    <br>

                          </div>
                        </div>
                </div>
                <button class="btn btn-outline-secondary btn-lg col-md-12 " type="submit" >Lancer l'exportation</button>
                </form>
            </div>
</main>
@endsection
