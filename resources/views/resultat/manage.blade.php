@extends('layout')
@section('haut')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Voir</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Resultats/Voir</li>
            </ol>
            @include('flash_message')
            <div class="row">
                <div class="form-group col-6">
                    <label for="opt" class="text-success">Option</label>
                    <select id="opt" class="custom-select my-1" data-dependent="code" name="opt">
                        <option value="0" selected>Selectionner une option</option>
                        @foreach($options as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="code" class="text-danger">Criteres</label>
                    <select id="critere" class="custom-select my-1" name="critere">
                        <option id="setted" value="2" selected>Tous</option>
                        <option value="1">Admissible</option>
                        <option value="3">Refuse</option>
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Resultats</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table" style="font-size:80%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Identifiant</th>
                                                <th>N° de table</th>
                                                <th>Nom Prenoms</th>
                                                <th>Option</th>
                                                <th>Moyenne</th>
                                                <th>Contact</th>
                                                <th>Admissibilité</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Image</th>
                                                <th>Identifiant</th>
                                                <th>N° de table</th>
                                                <th>Nom Prenoms</th>
                                                <th>Option</th>
                                                <th>Moyenne</th>
                                                <th>Contact</th>
                                                <th>Admissibilité</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                    </div>
            </div>
    </div>
</main>
<script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function()
    {
        $('#opt').change(function()
        {
            if($(this).val() != 0)
            {
                var value = $(this).val();
                var crit = $('#critere').val();
                $.ajax({
                    url:'/getAll',
                    type:'post',
                    data:{crit:crit,value:value},
                    success:function(result)
                    {
                        $('#table').DataTable().destroy();
                        $('tbody').html(result);
                        $('#table').dataTable();
                    }
                });
            }else{
                $('tbody').empty();
            }
        });

        $('#critere').change(function()
        {
            if($(this).val() != 0)
            {
                var value = $(this).val();
                var opt = $('#opt').val();
                $.ajax({
                    url:'/getByCriteres',
                    type:'post',
                    data:{opt:opt,value:value},
                    success:function(result)
                    {
                        $('#table').DataTable().destroy();
                        $('tbody').html(result);
                        $('#table').DataTable();
                    }
                });
            }else{
                $('tbody').empty();
            }
        });
    });

</script>
@endsection
