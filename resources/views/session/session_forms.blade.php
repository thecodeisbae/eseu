<div class="card-deck">
    <div class="card bg-transparent text-black mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Informations de la session</h3>
            <hr>
            <div class="form-group row">
                <label class="small mb-1" for="nom">Nom de la session<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('nom') is-invalid @enderror my-2" name="nom" id="nom" type="text" value="{{ old('value') ?? $session->nom ?? ''  }}"  />
                @error('nom')
                    <div class="invalid-feedback">
                        {{ $errors->first('nom') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="begin_date">Date de début<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('begin_date') is-invalid @enderror my-2" name="begin_date" id="begin_date" type="date" value="{{ old('value') ?? $session->start ?? ''  }}"  />
                @error('begin_date')
                    <div class="invalid-feedback">
                        {{ $errors->first('begin_date') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="end_date">Date de fin<span class="text-danger"  style="font-size:20px;">*</span></label>
                <input class="form-control @error('end_date') is-invalid @enderror my-2" name="end_date" id="date" type="date" value="{{ old('value') ?? $session->end ?? ''  }}"  />
                @error('end_date')
                    <div class="invalid-feedback">
                        {{ $errors->first('end_date') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="status">Définir la session comme : <span class="text-danger"  style="font-size:20px;">*</span></label>
                <select class="custom-select @error('status') is-invalid @enderror my-2" name="status" id="status"  value="{{ old('value') }}" >
                    <option value="e" {{ ($session->current ?? '' ) == '1' ? 'selected' : '' }} >Active</option>
                    <option value="d" {{ ($session->current ?? '' ) == '0' ? 'selected' : '' }} >Non active</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="login">Numero<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('numero') is-invalid @enderror" name="numero" id="numero" type="text"  value="{{ old('value') ?? $session->numero ?? ''  }}"  />
                @error('numero')
                    <div class="invalid-feedback">
                        {{ $errors->first('numero') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="oral">Moyenne orale<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('oral') is-invalid @enderror my-2" name="oral" id="oral" type="number" min="0" max="20"  value="{{ old('value') ?? $session->seuilOral ?? ''  }}"  />
                @error('oral')
                    <div class="invalid-feedback">
                        {{ $errors->first('oral') }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="card bg-transparent text-black mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Informations clés</h3>
            <hr>
            <div class="form-group row">
                <label class="small mb-1" for="vr">Titre Nom et prénoms du Vice recteur<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('vr') is-invalid @enderror my-2" name="vr" id="vr" type="text"  value="{{ old('value') ?? $session->viceRecteur ?? ''  }}"  />
                @error('vr')
                    <div class="invalid-feedback">
                        {{ $errors->first('vr') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="vrt">Nom complet du vice rectorat<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control @error('vrt') is-invalid @enderror my-2" name="vrt" id="vrt" type="text"  value="{{ old('value') ?? $session->viceRectorat ?? ''  }}"  />
                @error('vrt')
                    <div class="invalid-feedback">
                        {{ $errors->first('vrt') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="service_etude" class="small mb-1">Nom complet du service des études<span class="text-danger" style="font-size:20px;">*</span></label>
                <input id="service_etude" class="form-control @error('service_etude') is-invalid @enderror my-2" type="text" name="service_etude"  value="{{ old('value') ?? $session->service ?? ''  }}"  />
                @error('service_etude')
                    <div class="invalid-feedback">
                        {{ $errors->first('service_etude') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="date_oral">Date des épreuves orales éliminatoire (A1,B,C) <span class="text-danger"  style="font-size:20px;">*</span></label>
                <input class="form-control @error('date_oral') is-invalid @enderror my-2" name="date_oral" id="date_oral" type="datetime-local" value="{{ old('value') ?? $other['dateOral'] ?? ''  }}" />
                @error('date_oral')
                    <div class="invalid-feedback">
                        {{ $errors->first('date_oral') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="date_ecrit">Date des épreuves écrites (Toute option) <span class="text-danger"  style="font-size:20px;">*</span></label>
                <input class="form-control @error('date_ecrit') is-invalid @enderror my-2" name="date_ecrit" id="date_ecrit" type="datetime-local" value="{{ old('value') ?? $other['dateEcrit'] ?? ''  }}" />
                @error('date_ecrit')
                    <div class="invalid-feedback">
                        {{ $errors->first('date_ecrit') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="passage_moyenne" class="small mb-1">Moyenne de passage <span class="text-danger" style="font-size:20px;">*</span></label>
                <input id="passage_moyenne" class="form-control @error('passage_moyenne') is-invalid @enderror my-2" type="number" min="10" max="20" name="passage_moyenne" value="{{ old('value') ?? $session->moyenne_passage ?? ''  }}">
                @error('passage_moyenne')
                    <div class="invalid-feedback">
                        {{ $errors->first('passage_moyenne') }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
