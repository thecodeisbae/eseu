@extends('layout')
@section('haut')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Générer anonymat</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Numeros</li>
            </ol>
            @include('flash_message')
            <form method="post" action="/generation" enctype="multipart/form-data">
                @csrf
               <div class="form-group">
                  <button class="btn btn-success text-light col-12" type="submit">Générer les numéros de tables et codes secrets</button>
               </div>
            </form>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des étudiants</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered btn-sm" style="font-size:80%;" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Identifiant</th>
                                                <th>N° de table</th>
                                                <th>Code secret</th>
                                                <th>Nom prenoms</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($data as $obj)
                                                    <tr>
                                                        <td>{{ $obj->identifiant }}</td>
                                                        <td>{{ $obj->numero_table }}</td>
                                                        <td>{{ $obj->code_secret }}</td>
                                                        <td>{{ $obj->cdt_nom.' '.$obj->prenoms }}</td>
                                                        <td>{{ $obj->contact }}</td>
                                                        <td>{{ $obj->email }}</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Identifiant</th>
                                                <th>N° de table</th>
                                                <th>Code secret</th>
                                                <th>Nom prenoms</th>
                                                <th>Contact</th>
                                                <th>Email</th>
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

        $('#option').change(function()
        {
            $('tbody').empty();

            if($(this).val() != '')
            {
                var value = $(this).val();
                //var dependent = $(this).data('dependent');
                $.ajax({
                    url:'/show',
                    type:'post',
                    data:{value:value},
                    success:function(result)
                    {
                        //alert('retour');
                        $('tbody').html(result);
                    }
                });
            }

        });
    });

</script>
@endsection
<i class="fa fa4-click"></i>
