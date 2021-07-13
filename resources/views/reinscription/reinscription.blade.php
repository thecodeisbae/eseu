@extends('layout')
@section('haut')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Réinscriptions</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Réinscriptions</li>
            </ol>
            @include('flash_message')
            <div class="row">
                <div class="col-2"></div>
                <div class="form-group col-6">
                    <label for="code" class="text-danger">Identifiant</label>
                    <input type="text" class="form-control btn-lg my-1" name="code" id="code">
                </div>
                <div class="form-group col-2">
                    <label for="code" class="text-primary">Chercher</label>
                    <button id="search" class="btn btn-outline-primary btn-lg col-sm-8 form-control my-1"><i class="fa fa-search"></i></button>
                </div>
                <div class="col-2"></div>
            </div>
            <br>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table mr-1"></i>Candidat</div>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size:80%;" id="#dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nom prenoms</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Option</th>
                                                <th>Matière au choix</th>
                                                <th>Session</th>
                                                <th>Reinscrire</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nom prenoms</th>
                                                <th>Sexe</th>
                                                <th>Contact</th>
                                                <th>Option</th>
                                                <th>Matière au choix</th>
                                                <th>Session</th>
                                                <th>Reinscrire</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                    </div>
            </div>
    </div>

    <form action="/reinscription" method="post" hidden="true" id="formulaire">
        @csrf
        <input type="text" name="pSession" hidden id="pSession" />
        <input type="text" name="pIdentifiant" hidden id="pIdentifiant" />
        <input type="text" name="pOption" hidden id="pOption" />
        <input type="text" name="pMatiere" hidden id="pMatiere" />
    </form>
</main>

<script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        function save(id,cdt_id)
        {
            $('#point').empty();
            $('#moyenne').empty();
            var note = $('#note'+id).val();
            var id = id;
            var cdt = cdt_id;
            if( note != '' )
            {
                $.ajax({
                    url:'/saveNote',
                    type:'post',
                    data:{note:note,id:id,cdt:cdt},
                    dataType:'json',
                    success:function(result)
                    {
                        alert('Note enregistrée');
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
            }else{
                alert('Entrer une valeur');
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

    function change()
    {
        var opt = $('#option').val();
        $.ajax({
            url:'/getMatiere',
            type:'post',
            data:{value:opt},
            success:function(result)
            {
                $('#matiere').html(result);
            }
        });

    }

    function verify()
    {
        if($('#option').val() != "0" && $('#code').val() != "" && $('#session').val() != "")
        {
            var value = $('#code').val();
            var session = $('#session').val();
            $.ajax({
                url:'/doublon',
                type:'post',
                data:{value:value,session:session},
                success:function(result)
                {
                    if(result == 1)
                        reinscrire();
                    else
                        alert('Ce candidat est déjà enregistré dans cette session');
                }
            });
        }
        else
        {
            alert('Renseigner l\'identifiant,l\'option et la session');
        }
    }

    function reinscrire()
    {
        $('#pIdentifiant').val($('#code').val());
        $('#pOption').val($('#option').val());
        $('#pMatiere').val($('#matiere').val());
        $('#pSession').val($('#session').val());
        //alert($('#pIdentifiant').val()+'-'+$('#pOption').val()+'-'+$('#pMatiere').val()+'-'+$('#pSession').val() );
        if( $('#pIdentifiant').val() != "" && $('#pOption').val() != "0" && $('#pSession').val() != "0" )
        {
            document.getElementById("formulaire").submit();
        }

    }

    $(document).ready(function()
    {

        $('#search').click(function()
        {
            $('tbody').empty();
            var code = $('#code').val();
            if(code != '')
            {
                $.ajax({
                    url:'/verifyIdtf',
                    type:'post',
                    data:{value:code},
                    success:function(result)
                    {
                        if(result == 1)
                        {
                            $.ajax({
                                url:'/getCandidatInfo',
                                type:'post',
                                data:{value:code},
                                success:function(result)
                                {
                                    $('tbody').html(result);
                                    //alert(result);
                                }
                            });
                        }
                        else
                        {
                            alert('Cet identifiant est erroné');
                            $('#code').val('');
                        }
                    }
                });
            }
            else
            {
                alert('Veuiller saisir un identifiant');
            }

        });
    });

</script>
@endsection
