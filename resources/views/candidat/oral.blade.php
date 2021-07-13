@extends('layout')
@section('haut')
@endsection
@section('content')
<main>
            <div class="container-fluid">
                <h3 class="mt-4">Oral</h3>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Oral</li>
                    </ol>
                     @include('flash_message')
                <div class="card-deck" >
                       <div class="card">
                           <div class="card-body">
                               <h3 class="card-title">Exporter liste</h3>
                               <hr>
                                <form target="_blank" action="/oralExport" method="post" enctype="multipart/form-data">
                                 @csrf
                                        <label class="my-1 mr-2" for="">Option</label>
                                        <select name="option" class="custom-select my-2 mr-sm-2">
                                            <option value="0" selected>Tous</option>
                                            @foreach($options as $opt)
                                                <option value="{{ $opt->id }}" {{ $opt->id == '2' ? 'disabled' : ''}}>{{ $opt->nom }}</option>
                                            @endforeach
                                        </select>
                                <h3 class="card-title" style="margin-top:5%;">Formats</h3>
                                <hr style="background-color:white;">
                                    <br>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="pdf" name="pdf"  >
                                        <label class="custom-control-label" for="pdf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pdf (*.pdf)</label>
                                    </div>
                                    <br>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="excel" name="excel">
                                        <label class="custom-control-label" for="excel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Excel (*.xslx)</label>
                                    </div><br><br>
                                    <button class="btn btn-outline-primary btn-lg col-md-12 " type="submit" >Lancer l'exportation</button>
                                    <br>
                                </form>
                           </div>
                       </div>
                       <div class="card">
                           <div class="card-body">
                               <h3 class="card-title">Importer liste</h3>
                               <hr>
                               <form action="/oralImport" method="post" enctype="multipart/form-data">
                                 @csrf
                                        <label class="my-1 mr-2" for="">Fichier au format excel</label><br>
                                        <input name="file" id="file" class="custom-file-control my-2 mr-sm-2" type="file" />
                                <h3 class="card-title" style="margin-top:7.5%;">Informations</h3>
                                <hr style="background-color:white;">
                                    <br>
                                    <span class="text-danger" style="font-size: 98%;">*</span>&nbsp;Assurez-vous que le fichier est bien au format excel (*.xslx) <br>
                                    <span class="text-danger" style="font-size: 98%;">*</span>&nbsp;Assurez-vous que les notes sont bien renseignées selon la colonne correspondante du fichier exporté<br>
                                    <br><br>
                                    <button class="btn btn-outline-success btn-lg col-md-12 " style="margin-top:1%;" type="submit" >Lancer l'importation</button>
                                    <br>
                                </form>
                           </div>
                       </div>
                </div>
            </div>
</main>
@endsection
