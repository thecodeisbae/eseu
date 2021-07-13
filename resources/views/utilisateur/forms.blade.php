<div class="card-deck">
    <div class="card  bg-transparent text-black mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Informations personnelles</h3>
            <hr>
            <div class="form-group row">
                <label class="small mb-1" for="nom">Nom<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('nom') is-invalid @enderror" name="nom" id="nom" type="text" value="{{ old('value') ??  $user->nom ?? '' }}"  />
                 @error('nom')
                    <div class="invalid-feedback">
                        {{ $errors->first('nom') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="prenom">Prenoms<span class="text-danger"  style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('prenom') is-invalid @enderror" name="prenom" id="prenom" type="text" value="{{ old('value') ??  $user->prenom ?? ''  }}"  />
                 @error('prenom')
                    <div class="invalid-feedback">
                        {{ $errors->first('prenom') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="sexe">Sexe<span class="text-danger"  style="font-size:20px;">*</span></label>
                <select class="custom-select my-2 @error('sexe') is-invalid @enderror" name="sexe" id="sexe" value="{{ old('value') }}">
                    <option value='m' {{ ($user->sexe ?? '') == 'm' ? 'selected' : '' }} >Homme</option>
                    <option value='f' {{ ($user->sexe ?? '') == 'f' ? 'selected' : '' }}>Femme</option>
                </select>
                 @error('sexe')
                    <div class="invalid-feedback">
                        {{ $errors->first('sexe') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="email">Email<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('email') is-invalid @enderror" name="email" id="email" type="email" value="{{ old('value') ??  $user->email ?? ''  }}" />
                 @error('email')
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="contact">Contact<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('contact') is-invalid @enderror" name="contact" id="contact" type="text" value="{{ old('value') ??  $user->contact ?? ''  }}" />
                 @error('contact')
                    <div class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="adresse">Adresse</label>
                <input class="form-control my-2" name="adresse" id="adresse" type="text" value="{{ old('value') ??  $user->adresse ?? ''  }}"  />
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="login">Pays d'origine</label>
                <select class="custom-select my-2" name="pays" id="pays" value="{{ old('value')}}">
                    <option value="AF">Afghanistan</option>
                    <option value="AX">Åland Islands</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ" selected>Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia, Plurinational State of</option>
                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CG">Congo</option>
                    <option value="CD">Congo, the Democratic Republic of the</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Côte d'Ivoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CW">Curaçao</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (Malvinas)</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HM">Heard Island and McDonald Islands</option>
                    <option value="VA">Holy See (Vatican City State)</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran, Islamic Republic of</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea, Democratic People's Republic of</option>
                    <option value="KR">Korea, Republic of</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People's Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia, Federated States of</option>
                    <option value="MD">Moldova, Republic of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestinian Territory, Occupied</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Réunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">Rwanda</option>
                    <option value="BL">Saint Barthélemy</option>
                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="MF">Saint Martin (French part)</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and the Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SX">Sint Maarten (Dutch part)</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                    <option value="SS">South Sudan</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan, Province of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania, United Republic of</option>
                    <option value="TH">Thailand</option>
                    <option value="TL">Timor-Leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US">United States</option>
                    <option value="UM">United States Minor Outlying Islands</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela, Bolivarian Republic of</option>
                    <option value="VN">Viet Nam</option>
                    <option value="VG">Virgin Islands, British</option>
                    <option value="VI">Virgin Islands, U.S.</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select>
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="login">Fonction</label>
                <input class="form-control my-2" name="work" id="work" type="text" value="{{ old('value') ??  $user->fonction ?? ''  }}" />
            </div>
        </div>
    </div>
    <div class="card  bg-transparent text-black  mb-4">
        <div class="card-body" style="margin:10px;">
            <h3 class="card-title">Informations du Compte</h3>
            <hr>
            <div class="form-group row">
                <label class="small mb-1" for="login">Identifiant<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('login') is-invalid @enderror" name="login" id="login" type="text" value="{{ old('value') ??  $user->identifiant ?? ''  }}" />
                 @error('login')
                    <div class="invalid-feedback">
                        {{ $errors->first('login') }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="small mb-1" for="mdp">Mot de passe<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('mdp') is-invalid @enderror" name="mdp" id="mdp" type="password" value="{{ old('value') ??  $user->motdepasse ?? ''  }}" />
            </div>
             @error('mdp')
                    <div class="invalid-feedback">
                        {{ $errors->first('mdp') }}
                    </div>
                @enderror
            <div class="form-group row">
                <label class="small mb-1" for="validity">Délai de validité<span class="text-danger" style="font-size:20px;">*</span></label>
                <input class="form-control my-2 @error('validity') is-invalid @enderror" name="validity" id="validity" type="date" value="{{ old('value') ??  $user->validite ?? ''  }}"  />
                 @error('validity')
                    <div class="invalid-feedback">
                        {{ $errors->first('validity') }}
                    </div>
                @enderror
            </div>
             <h5 class="card-title">Accès autorisés</h5>
            <hr>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="candidat" class="custom-control-input" type="checkbox" name="candidat" value="1" {{ ($user->candidat ?? '' == '1') ? 'checked' : '' }} >
                    <label for="candidat" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Candidats</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="convocation" class="custom-control-input" type="checkbox" name="convocation" value="1" {{ ($user->convocation ?? '' == '1') ? 'checked' : '' }}>
                    <label for="convocation" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Convocations</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="numero" class="custom-control-input" type="checkbox" name="numero" value="1" {{ ($user->numero ?? '' == '1') ? 'checked' : '' }}>
                    <label for="numero" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numeros</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="note" class="custom-control-input" type="checkbox" name="note" value="1" {{ ($user->note ?? '' == '1') ? 'checked' : '' }}>
                    <label for="note" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Notes</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="note_edit" class="custom-control-input" type="checkbox" name="note_edit" value="1" {{ ($user->note_edit ?? '' == '1') ? 'checked' : '' }}>
                    <label for="note_edit" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edition de notes</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="resultat" class="custom-control-input" type="checkbox" name="resultat" value="1" {{ ($user->resultat ?? '' == '1') ? 'checked' : '' }}>
                    <label for="resultat" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Resultats</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="session" class="custom-control-input" type="checkbox" name="session" value="1" {{ ($user->session ?? '' == '1') ? 'checked' : '' }}>
                    <label for="session" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sessions</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="user" class="custom-control-input" type="checkbox" name="user" value="1" {{ ($user->utilisateur ?? '' == '1') ? 'checked' : '' }}>
                    <label for="user" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utilisateurs</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="user" class="custom-control-input" type="checkbox" name="releve" value="1" {{ ($user->releve ?? '' == '1') ? 'checked' : '' }}>
                    <label for="user" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relevés</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="supplement" class="custom-control-input" type="checkbox" name="attestation" value="1" {{ ($user->attestation ?? '' == '1') ? 'checked' : '' }}>
                    <label for="supplement" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Attestations</label>
            </div><br>
            <div class="custom-control custom-checkbox" style="margin-left:-6%;">
                    <input id="reinscription" class="custom-control-input" type="checkbox" name="reinscription" value="1" {{ ($user->reinscription ?? '' == '1') ? 'checked' : '' }}>
                    <label for="reinscription" class="custom-control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reinscriptions</label>
            </div>
            <hr>
        </div>
    </div>
</div>
