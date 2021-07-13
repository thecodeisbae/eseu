@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Exporter</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Résultats/Exporter</li>
            </ol>
        <div class="card-deck" >
            <div class="col-3"></div>
           <div class="card bg-secondary text-light col-6">
               <div class="card-body">
                   <h5 class="card-title">Critère d'exportation</h5>
                   <hr>
                   <form action="/exportResult" method="POST" target="_blank" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label for="option" class="small">Option</label>
                           <select class="custom-select my-2" name="option" id="option">
                               <option value="0" selected>Tous</option>
                               @foreach($options as $opt)
                                    <option value="{{ $opt->id }}">{{ $opt->nom }}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="form-group">
                           <button class="btn btn-outline-light col-12" type="submit">Aller à l'exportation / la prévisualisation </button>
                       </div>
                   </form>
               </div>
           </div>
        </div>
    </div>
</main>
@endsection
