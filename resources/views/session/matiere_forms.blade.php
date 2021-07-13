         <div class="card bg-transparent text-black" >
             <div class="card-body" style="margin:30px;" >
                <h3 class="card-title">Formulaire</h3>
                <hr>
                <div class="form-group row" style="margin:20px;">
                    <label for="option" class="small mb-1">Option</label>
                    <select id="option" class="custom-select @error('option') is-invalid @enderror my-2" type="text" name="option" value="{{ old('value')}}">
                       @foreach($options as $opt)
                         <option value="{{ $opt->id }}" {{ ($mat->option_id ?? '') == ($opt->id ?? '0') ? 'selected' : '' }}>{{ $opt->nom }}</option>
                       @endforeach
                    </select>
                    @error('option')
                        <div class="invalid-feedback">
                            Veuiller ajouter des options
                        </div>
                    @enderror
                </div>
                <div class="form-group row" style="margin:20px;">
                    <label for="option" class="small mb-1">Session</label>
                    <select id="session" class="custom-select @error('session') is-invalid @enderror my-2" type="text" name="session" value="{{ old('value')}}">
                       @foreach($sessions as $session)
                         <option value="{{ $session->id }}" {{ ($mat->session_id ?? '') == ($session->id ?? '0') ? 'selected' : '' }}>{{ $session->nom }}</option>
                       @endforeach
                    </select>
                    @error('session')
                        <div class="invalid-feedback">
                            Veuiller ajouter des sessions
                        </div>
                    @enderror
                </div>
                <div class="form-group row" style="margin:20px;">
                    <label for="type" class="small mb-1">Type de matiere</label>
                    <select id="type" class="custom-select my-2" type="text" name="type">
                        <option value="forced" {{ ($mat->principal ?? '') == '1' ? 'selected' : '' }}>Obligatoire</option>
                        <option value="choice" {{ ($mat->principal ?? '') == '0' ? 'selected' : '' }}>Au choix</option>
                    </select>
                </div>
                <div class="form-group row" style="margin:20px;">
                    <label for="code_mat" class="small mb-1">Code de la matiere</label>
                    <input id="code_mat" class="form-control @error('code_mat') is-invalid @enderror my-2" type="text" name="code_mat" value="{{ old('value') ?? $mat->code ?? '' }}">
                    @error('code_mat')
                        <div class="invalid-feedback">
                            {{ $errors->first('code_mat') }}
                        </div>
                    @enderror
                </div>
                <div class="form-group row" style="margin:20px;">
                    <label for="nom_mat" class="small mb-1">Nom de la matière</label>
                    <input id="nom_mat" class="form-control my-2" type="text" name="nom_mat" value="{{ old('value') ?? $mat->nom ?? '' }}">
                    @error('code_mat')
                        <div class="invalid-feedback">
                            {{ $errors->first('code_mat') }}
                        </div>
                    @enderror
                </div>
                <div class="form-group row" style="margin:20px;">
                    <label for="coef" class="small mb-1">Coefficient</label>
                    <input id="coef" class="form-control @error('coef') is-invalid @enderror my-2" type="number" min="1" max="10" name="coef" value="{{ old('value') ?? $mat->coef ?? '' }}">
                    @error('coef')
                        <div class="invalid-feedback">
                            {{ $errors->first('coef') }}
                        </div>
                    @enderror
                </div>
            </div>
         </div>
         <br>
