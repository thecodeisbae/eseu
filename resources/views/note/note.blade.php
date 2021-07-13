@extends('layout')
@section('haut')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Notes</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Notes/Gérer</li>
            </ol>
            @include('flash_message')
            <div class="row">
                <div class="col-2"></div>
                <div class="form-group col-6">
                    <label for="code" class="text-danger">Code secret</label>
                    <input type="text" class="form-control btn-lg my-1" name="code" id="code">
                </div>
                <div class="form-group col-2">
                    <label for="code" class="text-primary">Chercher</label>
                    <button id="search" class="btn btn-outline-primary btn-lg col-sm-8 form-control my-1"><i class="fa fa-search"></i></button>
                </div>
                <div class="col-2"></div>
            </div>
            <div class="card bg-primarycol-12 text-center text-light bg-primary my-4"><span class="card-body" style="font-size: 200%;font-weight: bold;" id="displayCode"></span></div>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Liste des étudiants</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size:80%;" id="#dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Code Matiere</th>
                                                <th>Matiere</th>
                                                <th>Coef</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code Matiere</th>
                                                <th>Matiere</th>
                                                <th>Coef</th>
                                                <th>Note</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <button onclick="save()" class="col-12 btn btn-lg btn-primary">Enregistrer&nbsp;<i class="fa fa-save"></i></button>
                                </div>
                    </div>
            </div>
            <div class="card-deck" id="foot" hidden>
                <div class="card bg-primary text-light">
                    <div class="card-body">
                        <h5 class="card-title">Point totale obtenus </h5>
                        <hr>
                        <p class="card-text text-right" id="point"></p>
                    </div>
                </div>
                <div class="card bg-success text-light">
                    <div class="card-body">
                        <h5 class="card-title">Moyenne  </h5>
                        <hr>
                        <p class="card-text text-right" id="moyenne"></p>
                    </div>
                </div>'
            </div>
    </div>
</main>
<script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function save()
        {
            $('#point').empty();
            $('#moyenne').empty();
            var cdt = $('#idtf').val();
            if( cdt != '' )
            {
                $.ajax({
                    url:'/saveNote',
                    type:'post',
                    data:{cdt:cdt},
                    dataType:'json',
                    success:function(result)
                    {
                        var cont = true;
                        var notes = new Array();
                        result.forEach(element => {
                            if($('#note'+element['matiere_id']).val() == '' )
                            {
                                cont = false;
                            }
                        });
                        if(cont)
                        {
                            result.forEach(element => {
                                notes.push($('#note'+element['matiere_id']).val());
                            });
                            $.ajax({
                                url:'/saving',
                                type:'post',
                                data:{notes:notes,cdt:cdt},
                                dataType:'json',
                                success:function(result)
                                {
                                    if(result == 1)
                                        alert("Notes enregistrées");
                                    else
                                        alert("Vérifier les informations");
                                }
                            });
                        }
                        else
                        {
                            alert('Renseignez toutes les notes');
                        }
                        //alert(result);
                        /*alert('Note enregistrée');
                        if(result != '')
                        {
                            var obtenu = result.obtenu;
                            var total = result.total;
                            var moy = result.moy;
                            $('#point').html('<span style="font-size:400%">'+total+'</span><span style="font-size:175%">/'+obtenu+'</span>');
                            $('#moyenne').html('<span style="font-size:400%">'+moy+'</span><span style="font-size:175%;">/20</span>');
                        }*/
                    }

                });
            }else{

            }
        }

        function getResult()
        {
            var cdt = $('#idtf').text();
            $.ajax({
                    url:'/getNoteResult',
                    type:'post',
                    data:{cdt:cdt},
                    dataType:'json',
                    success:function(result)
                    {
                        if(result != '')
                        {
                            var obtenu = result.obtenu;
                            var total = result.total;
                            var moy = result.moy;
                            $('#point').html('<span style="font-size:400%">'+total+'</span><span style="font-size:175%">/'+obtenu+'</span>');
                            $('#moyenne').html('<span style="font-size:400%">'+moy+'</span><span style="font-size:175%;">/20</span>');
                        }
                    }
                });
        }

    $(document).ready(function()
    {
        $('#search').click(function(){
            $('#displayCode').text('');
            $('tbody').empty();
            $('#point').empty();
            $('#moyenne').empty();
            var code = $('#code').val();
            if(code != '')
            {
                $.ajax({
                    url:'/verifyCode',
                    type:'post',
                    data:{value:code},
                    success:function(result)
                    {
                        if(result == 1)
                        {
                            $('#displayCode').text(code);
                            $.ajax({
                                url:'/getMatiereCode',
                                type:'post',
                                data:{value:code},
                                success:function(result)
                                {
                                    $('tbody').html(result);
                                    //getResult();
                                }
                            });
                        }
                        else
                        {
                            alert('Ce code secret est erroné');
                            $('#code').val('');
                        }
                    }
                });
            }
            else
            {
                alert('Veuiller saisir un code');
            }

        });
    });

</script>
@endsection
