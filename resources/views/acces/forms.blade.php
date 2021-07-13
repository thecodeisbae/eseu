<div class="card-deck">
    <div class="card bg-transparent text-black mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Nouveau profil</h3>
            <hr>
            <div class="form-group row" > 
                <label class="small mb-1" for="nom">Nom<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('nom') is-invalid @enderror my-2" name="nom" id="nom" type="text" value="{{ old('value') ?? $profil->nom ?? '' }}" />
                @error('nom')
                    <div class="invalid-feedback">
                        {{ $errors->first('nom') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row" > 
                <label class="small mb-1" for="contact">Desciption<span class="text-danger" style="font-size:20px;">*</span></label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror my-2" cols="30" rows="8">{{ old('value') ?? $profil->description ?? '' }}
                </textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="card bg-transparent text-black mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Accès autorisés</h3>
            <hr>
            <div class="custom-control custom-checkbox">
                    <input id="candidat" class="custom-control-input" type="checkbox" name="candidat" value="1" {{ ($profil->candidat ?? '' == '1') ? 'checked' : '' }} >
                    <label for="candidat" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Candidats</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="convocation" class="custom-control-input" type="checkbox" name="convocation" value="1" {{ ($profil->convocation ?? '' == '1') ? 'checked' : '' }}>
                    <label for="convocation" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Convocations</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="numero" class="custom-control-input" type="checkbox" name="numero" value="1" {{ ($profil->numero ?? '' == '1') ? 'checked' : '' }}>
                    <label for="numero" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numeros</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="note" class="custom-control-input" type="checkbox" name="note" value="1" {{ ($profil->note ?? '' == '1') ? 'checked' : '' }}>
                    <label for="note" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Notes</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="resultat" class="custom-control-input" type="checkbox" name="resultat" value="1" {{ ($profil->resultat ?? '' == '1') ? 'checked' : '' }}>
                    <label for="resultat" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Resultats</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="session" class="custom-control-input" type="checkbox" name="session" value="1" {{ ($profil->session ?? '' == '1') ? 'checked' : '' }}>
                    <label for="session" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sessions</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="user" class="custom-control-input" type="checkbox" name="user" value="1" {{ ($profil->utilisateur ?? '' == '1') ? 'checked' : '' }}>
                    <label for="user" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utilisateurs</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="profil" class="custom-control-input" type="checkbox" name="profil" value="1" {{ ($profil->acces ?? '' == '1') ? 'checked' : '' }}>
                    <label for="profil" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acces</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="supplement" class="custom-control-input" type="checkbox" name="supplement" value="1" {{ ($profil->supplement ?? '' == '1') ? 'checked' : '' }}>
                    <label for="supplement" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplements</label>
            </div><br>
            <div class="custom-control custom-checkbox">
                    <input id="reinscription" class="custom-control-input" type="checkbox" name="reinscription" value="1" {{ ($profil->reinscription ?? '' == '1') ? 'checked' : '' }}>
                    <label for="reinscription" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reinscriptions</label>
            </div>
        </div>
    </div>
</div>