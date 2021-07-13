@extends('layout')
@section('haut')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Attestations</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Supplements/Attestations</li>
            </ol>
        <div class="card-deck" >
            <div class="card bg-secondary text-light col-12">
               <div class="card-body">
                    <h5 class="card-title">Impression Unique</h5>
                   <hr>
                        <div class="form-group">
                           <label for="identifiant" class="small">Identifiant</label>
                           <input type="text" class="form-control my-2 @error('identifiant') is-invalid @enderror" name="identifiant" id="identifiant">
                        </div>
                        <div class="form-group" >
                           <button class="btn btn-outline-light col-12"  style="margin-top:1.8%;" id="valider" >Aller à l'impression</button>
                        </div>
               </div>
           </div>
           <div class="card bg-primary text-light col-12">
               <div class="card-body">
                   <h5 class="card-title">Impression collective</h5>
                   <hr>
                   <form action="/attestations" method="POST" target="_blank" enctype="multipart/form-data">
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
                           <button class="btn btn-outline-light col-12" type="submit">Aller à l'impression </button>
                       </div>
                   </form>
               </div>
           </div>
           
            <form action="/singleAttestation" target="_blank" id="apply" method="POST" hidden="true">
                @csrf
                <input type="text" id="hideId" hidden name="value" />
            </form>
        </div>
    </div>
</main>

<script>

    $.ajaxSetup({

        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $(document).ready(function()
    {
        $('#valider').click(
            function()
            {
               var value = $('#identifiant').val();
                    $.ajax({
                            url:'/verifyAttestation',
                            type:'post',
                            data:{value:value},
                            success:function(result)
                            {
                                if(result == '1')
                                {
                                    $('#hideId').attr("value",value);
                                    document.getElementById("apply").submit();
                                }
                                else
                                {
                                    if(result == '2')
                                    {
                                        alert('Ce candidat ne peut pas recevoir d\'attestation');
                                        $('#identifiant').val('');
                                    }
                                    else
                                    {
                                        alert('Identifiant inconnu');
                                        $('#identifiant').val('');
                                    }
                                }
                            },
                            failed:function(result)
                            {
                                alert('Une erreur s\'est produite côté serveur');
                            }
                        });
                }

        );
    });

</script>
@endsection
