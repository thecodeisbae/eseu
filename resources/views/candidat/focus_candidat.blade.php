@extends('layout')
@section('content')
<main>
    <div class="container-fluid">
        <h3 class="mt-4">Candidat : <strong class="text-primary">{{ $obj->nom.' '.$obj->prenoms }}</strong> </h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Candidats/Voir</li>
            </ol>
        <form action="/edit_candidat/{{ $obj->id }}" method="post" entype="multipart/form-data">
            @csrf
            <div class="card-deck">
                    <div class="card bg-transparent text-black mb-4">
                        <div class="card-body" style="margin:30px;">
                            <h3 class="card-title">Informations du candidat</h3>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label class="small mb-1" for="show">Photo<span class="text-danger" style="font-size:20px;">*</span></label><br>
                                        <p>
                                            <img style="margin-top:30px;border : 2px solid #E9ECEF;" class="bg-success" src="{{ $obj->chemin }}" />
                                        </p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group row">
                                        <label class="small mb-1" for="code">Identifiant<span class="text-danger" style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('code') is-invalid @enderror my-2" name="code" id="code" type="text"  disabled value="{{ $obj->identifiant }}"  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="opt">Option<span class="text-danger" style="font-size:20px;">*</span></label>
                                        <select class="custom-select @error('opt') is-invalid @enderror my-2" data-dependent="mat" name="opt" id="opt" disabled>
                                            <option value="{{ $opt->id }}">{{ $opt->nom }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="nom">Nom<span class="text-danger" style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('nom') is-invalid @enderror my-2" name="nom" id="nom" type="text" disabled value={{ $obj->nom }}  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="prenom">Prenoms<span class="text-danger"  style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('prenom') is-invalid @enderror my-2" name="prenom" id="prenom" type="text" disabled value={{ $obj->prenoms }} />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="sexe">Sexe<span class="text-danger"  style="font-size:20px;">*</span></label>
                                        <select class="custom-select my-2 @error('sexe')  is-invalid @enderror" name="sexe" id="sexe" disabled>
                                            <option value="m" {{ ($obj->sexe ?? '') == 'm' ? 'selected' : '' }}>Homme</option>
                                            <option value="f" {{ ($obj->sexe ?? '') == 'f' ? 'selected' : '' }}>Femme</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="date">Date de naissance<span class="text-danger"  style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('date') is-invalid @enderror my-2" name="date" id="date" type="date" disabled value="{{ $obj->date_naissance }}"/>
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="lieu">Lieu de naissance<span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <input class="form-control my-2" name="lieu" id="lieu" type="text" disabled value="{{ $obj->lieu_naissance }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Adresse<span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <input class="form-control my-2" name="adresse" id="adresse" type="text" disabled value="{{ $obj->adresse }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Pays d'origine</label>
                                        <select class="custom-select my-2" name="pays" id="pays">
                                            <option value="AF" {{ ( $obj->pays ?? '' ) == 'AF' ? 'selected' : '' }}>Afghanistan</option>
                                            <option value="AX" {{ ( $obj->pays ?? '' ) == 'AX' ? 'selected' : '' }}>Åland Islands</option>
                                            <option value="AL" {{ ( $obj->pays ?? '' ) == 'AF' ? 'selected' : '' }}>Albania</option>
                                            <option value="DZ" {{ ( $obj->pays ?? '' ) == 'DZ' ? 'selected' : '' }}>Algeria</option>
                                            <option value="AS" {{ ( $obj->pays ?? '' ) == 'AS' ? 'selected' : '' }}>American Samoa</option>
                                            <option value="AD" {{ ( $obj->pays ?? '' ) == 'AD' ? 'selected' : '' }} >Andorra</option>
                                            <option value="AO" {{ ( $obj->pays ?? '' ) == 'AO' ? 'selected' : '' }}>Angola</option>
                                            <option value="AI" {{ ( $obj->pays ?? '' ) == 'AI' ? 'selected' : '' }}>Anguilla</option>
                                            <option value="AQ" {{ ( $obj->pays ?? '' ) == 'AQ' ? 'selected' : '' }}>Antarctica</option>
                                            <option value="AG" {{ ( $obj->pays ?? '' ) == 'AG' ? 'selected' : '' }}>Antigua and Barbuda</option>
                                            <option value="AR" {{ ( $obj->pays ?? '' ) == 'AR' ? 'selected' : '' }}>Argentina</option>
                                            <option value="AM" {{ ( $obj->pays ?? '' ) == 'AM' ? 'selected' : '' }}>Armenia</option>
                                            <option value="AW" {{ ( $obj->pays ?? '' ) == 'AW' ? 'selected' : '' }}>Aruba</option>
                                            <option value="AU" {{ ( $obj->pays ?? '' ) == 'AU' ? 'selected' : '' }}>Australia</option>
                                            <option value="AT" {{ ( $obj->pays ?? '' ) == 'AT' ? 'selected' : '' }}>Austria</option>
                                            <option value="AZ" {{ ( $obj->pays ?? '' ) == 'AZ' ? 'selected' : '' }}>Azerbaijan</option>
                                            <option value="BS" {{ ( $obj->pays ?? '' ) == 'BS' ? 'selected' : '' }}>Bahamas</option>
                                            <option value="BH" {{ ( $obj->pays ?? '' ) == 'BH' ? 'selected' : '' }}>Bahrain</option>
                                            <option value="BD" {{ ( $obj->pays ?? '' ) == 'BD' ? 'selected' : '' }}>Bangladesh</option>
                                            <option value="BB" {{ ( $obj->pays ?? '' ) == 'BB' ? 'selected' : '' }}>Barbados</option>
                                            <option value="BY" {{ ( $obj->pays ?? '' ) == 'BY' ? 'selected' : '' }}>Belarus</option>
                                            <option value="BE" {{ ( $obj->pays ?? '' ) == 'BE' ? 'selected' : '' }}>Belgium</option>
                                            <option value="BZ" {{ ( $obj->pays ?? '' ) == 'BZ' ? 'selected' : '' }}>Belize</option>
                                            <option value="BJ" {{ ( $obj->pays ?? '' ) == 'BJ' ? 'selected' : '' }} selected>Benin</option>
                                            <option value="BM" {{ ( $obj->pays ?? '' ) == 'BM' ? 'selected' : '' }}>Bermuda</option>
                                            <option value="BT" {{ ( $obj->pays ?? '' ) == 'BT' ? 'selected' : '' }}>Bhutan</option>
                                            <option value="BO" {{ ( $obj->pays ?? '' ) == 'BO' ? 'selected' : '' }}>Bolivia, Plurinational State of</option>
                                            <option value="BQ" {{ ( $obj->pays ?? '' ) == 'BQ' ? 'selected' : '' }}>Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA" {{ ( $obj->pays ?? '' ) == 'BA' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                                            <option value="BW" {{ ( $obj->pays ?? '' ) == 'BW' ? 'selected' : '' }}>Botswana</option>
                                            <option value="BV" {{ ( $obj->pays ?? '' ) == 'BV' ? 'selected' : '' }}>Bouvet Island</option>
                                            <option value="BR" {{ ( $obj->pays ?? '' ) == 'BR' ? 'selected' : '' }}>Brazil</option>
                                            <option value="IO" {{ ( $obj->pays ?? '' ) == 'IO' ? 'selected' : '' }}>British Indian Ocean Territory</option>
                                            <option value="BN" {{ ( $obj->pays ?? '' ) == 'BN' ? 'selected' : '' }}>Brunei Darussalam</option>
                                            <option value="BG" {{ ( $obj->pays ?? '' ) == 'BG' ? 'selected' : '' }}>Bulgaria</option>
                                            <option value="BF" {{ ( $obj->pays ?? '' ) == 'BF' ? 'selected' : '' }}>Burkina Faso</option>
                                            <option value="BI" {{ ( $obj->pays ?? '' ) == 'BI' ? 'selected' : '' }}>Burundi</option>
                                            <option value="KH" {{ ( $obj->pays ?? '' ) == 'KH' ? 'selected' : '' }}>Cambodia</option>
                                            <option value="CM" {{ ( $obj->pays ?? '' ) == 'CM' ? 'selected' : '' }}>Cameroon</option>
                                            <option value="CA" {{ ( $obj->pays ?? '' ) == 'CA' ? 'selected' : '' }}>Canada</option>
                                            <option value="CV" {{ ( $obj->pays ?? '' ) == 'CV' ? 'selected' : '' }}>Cape Verde</option>
                                            <option value="KY" {{ ( $obj->pays ?? '' ) == 'KY' ? 'selected' : '' }}>Cayman Islands</option>
                                            <option value="CF" {{ ( $obj->pays ?? '' ) == 'CF' ? 'selected' : '' }}>Central African Republic</option>
                                            <option value="TD" {{ ( $obj->pays ?? '' ) == 'TD' ? 'selected' : '' }}>Chad</option>
                                            <option value="CL" {{ ( $obj->pays ?? '' ) == 'CL' ? 'selected' : '' }}>Chile</option>
                                            <option value="CN" {{ ( $obj->pays ?? '' ) == 'CN' ? 'selected' : '' }}>China</option>
                                            <option value="CX" {{ ( $obj->pays ?? '' ) == 'CX' ? 'selected' : '' }}>Christmas Island</option>
                                            <option value="CC" {{ ( $obj->pays ?? '' ) == 'CC' ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
                                            <option value="CO" {{ ( $obj->pays ?? '' ) == 'CO' ? 'selected' : '' }}>Colombia</option>
                                            <option value="KM" {{ ( $obj->pays ?? '' ) == 'KM' ? 'selected' : '' }}>Comoros</option>
                                            <option value="CG" {{ ( $obj->pays ?? '' ) == 'CG' ? 'selected' : '' }}>Congo</option>
                                            <option value="CD" {{ ( $obj->pays ?? '' ) == 'CD' ? 'selected' : '' }}>Congo, the Democratic Republic of the</option>
                                            <option value="CK" {{ ( $obj->pays ?? '' ) == 'CK' ? 'selected' : '' }}>Cook Islands</option>
                                            <option value="CR" {{ ( $obj->pays ?? '' ) == 'CR' ? 'selected' : '' }}>Costa Rica</option>
                                            <option value="CI" {{ ( $obj->pays ?? '' ) == 'CI' ? 'selected' : '' }}>Côte d'Ivoire</option>
                                            <option value="HR" {{ ( $obj->pays ?? '' ) == 'HR' ? 'selected' : '' }}>Croatia</option>
                                            <option value="CU" {{ ( $obj->pays ?? '' ) == 'CU' ? 'selected' : '' }}>Cuba</option>
                                            <option value="CW" {{ ( $obj->pays ?? '' ) == 'CW' ? 'selected' : '' }}>Curaçao</option>
                                            <option value="CY" {{ ( $obj->pays ?? '' ) == 'CY' ? 'selected' : '' }}>Cyprus</option>
                                            <option value="CZ" {{ ( $obj->pays ?? '' ) == 'CZ' ? 'selected' : '' }}>Czech Republic</option>
                                            <option value="DK" {{ ( $obj->pays ?? '' ) == 'DK' ? 'selected' : '' }}>Denmark</option>
                                            <option value="DJ" {{ ( $obj->pays ?? '' ) == 'DJ' ? 'selected' : '' }}>Djibouti</option>
                                            <option value="DM" {{ ( $obj->pays ?? '' ) == 'DM' ? 'selected' : '' }}>Dominica</option>
                                            <option value="DO" {{ ( $obj->pays ?? '' ) == 'DO' ? 'selected' : '' }}>Dominican Republic</option>
                                            <option value="EC" {{ ( $obj->pays ?? '' ) == 'EC' ? 'selected' : '' }}>Ecuador</option>
                                            <option value="EG" {{ ( $obj->pays ?? '' ) == 'EG' ? 'selected' : '' }}>Egypt</option>
                                            <option value="SV" {{ ( $obj->pays ?? '' ) == 'SV' ? 'selected' : '' }}>El Salvador</option>
                                            <option value="GQ" {{ ( $obj->pays ?? '' ) == 'GQ' ? 'selected' : '' }}>Equatorial Guinea</option>
                                            <option value="ER" {{ ( $obj->pays ?? '' ) == 'ER' ? 'selected' : '' }}>Eritrea</option>
                                            <option value="EE" {{ ( $obj->pays ?? '' ) == 'EE' ? 'selected' : '' }}>Estonia</option>
                                            <option value="ET" {{ ( $obj->pays ?? '' ) == 'ET' ? 'selected' : '' }}>Ethiopia</option>
                                            <option value="FK" {{ ( $obj->pays ?? '' ) == 'FK' ? 'selected' : '' }}>Falkland Islands (Malvinas)</option>
                                            <option value="FO" {{ ( $obj->pays ?? '' ) == 'FO' ? 'selected' : '' }}>Faroe Islands</option>
                                            <option value="FJ" {{ ( $obj->pays ?? '' ) == 'FJ' ? 'selected' : '' }}>Fiji</option>
                                            <option value="FI" {{ ( $obj->pays ?? '' ) == 'FI' ? 'selected' : '' }}>Finland</option>
                                            <option value="FR" {{ ( $obj->pays ?? '' ) == 'FR' ? 'selected' : '' }}>France</option>
                                            <option value="GF" {{ ( $obj->pays ?? '' ) == 'GF' ? 'selected' : '' }}>French Guiana</option>
                                            <option value="PF" {{ ( $obj->pays ?? '' ) == 'PF' ? 'selected' : '' }}>French Polynesia</option>
                                            <option value="TF" {{ ( $obj->pays ?? '' ) == 'TF' ? 'selected' : '' }}>French Southern Territories</option>
                                            <option value="GA" {{ ( $obj->pays ?? '' ) == 'GA' ? 'selected' : '' }}>Gabon</option>
                                            <option value="GM" {{ ( $obj->pays ?? '' ) == 'GM' ? 'selected' : '' }}>Gambia</option>
                                            <option value="GE" {{ ( $obj->pays ?? '' ) == 'GE' ? 'selected' : '' }}>Georgia</option>
                                            <option value="DE" {{ ( $obj->pays ?? '' ) == 'DE' ? 'selected' : '' }}>Germany</option>
                                            <option value="GH" {{ ( $obj->pays ?? '' ) == 'GH' ? 'selected' : '' }}>Ghana</option>
                                            <option value="GI" {{ ( $obj->pays ?? '' ) == 'GI' ? 'selected' : '' }}>Gibraltar</option>
                                            <option value="GR" {{ ( $obj->pays ?? '' ) == 'GR' ? 'selected' : '' }}>Greece</option>
                                            <option value="GL" {{ ( $obj->pays ?? '' ) == 'GL' ? 'selected' : '' }}>Greenland</option>
                                            <option value="GD" {{ ( $obj->pays ?? '' ) == 'GD' ? 'selected' : '' }}>Grenada</option>
                                            <option value="GP" {{ ( $obj->pays ?? '' ) == 'GP' ? 'selected' : '' }}>Guadeloupe</option>
                                            <option value="GU" {{ ( $obj->pays ?? '' ) == 'GU' ? 'selected' : '' }}>Guam</option>
                                            <option value="GT" {{ ( $obj->pays ?? '' ) == 'GT' ? 'selected' : '' }}>Guatemala</option>
                                            <option value="GG" {{ ( $obj->pays ?? '' ) == 'GG' ? 'selected' : '' }}>Guernsey</option>
                                            <option value="GN" {{ ( $obj->pays ?? '' ) == 'GN' ? 'selected' : '' }}>Guinea</option>
                                            <option value="GW" {{ ( $obj->pays ?? '' ) == 'GW' ? 'selected' : '' }}>Guinea-Bissau</option>
                                            <option value="GY" {{ ( $obj->pays ?? '' ) == 'GY' ? 'selected' : '' }}>Guyana</option>
                                            <option value="HT" {{ ( $obj->pays ?? '' ) == 'HT' ? 'selected' : '' }}>Haiti</option>
                                            <option value="HM" {{ ( $obj->pays ?? '' ) == 'HM' ? 'selected' : '' }}>Heard Island and McDonald Islands</option>
                                            <option value="VA" {{ ( $obj->pays ?? '' ) == 'VA' ? 'selected' : '' }}>Holy See (Vatican City State)</option>
                                            <option value="HN" {{ ( $obj->pays ?? '' ) == 'HN' ? 'selected' : '' }}>Honduras</option>
                                            <option value="HK" {{ ( $obj->pays ?? '' ) == 'HK' ? 'selected' : '' }}>Hong Kong</option>
                                            <option value="HU" {{ ( $obj->pays ?? '' ) == 'HU' ? 'selected' : '' }}>Hungary</option>
                                            <option value="IS" {{ ( $obj->pays ?? '' ) == 'IS' ? 'selected' : '' }}>Iceland</option>
                                            <option value="IN" {{ ( $obj->pays ?? '' ) == 'IN' ? 'selected' : '' }}>India</option>
                                            <option value="ID" {{ ( $obj->pays ?? '' ) == 'ID' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="IR" {{ ( $obj->pays ?? '' ) == 'IR' ? 'selected' : '' }}>Iran, Islamic Republic of</option>
                                            <option value="IQ" {{ ( $obj->pays ?? '' ) == 'IQ' ? 'selected' : '' }}>Iraq</option>
                                            <option value="IE" {{ ( $obj->pays ?? '' ) == 'IE' ? 'selected' : '' }}>Ireland</option>
                                            <option value="IM" {{ ( $obj->pays ?? '' ) == 'IM' ? 'selected' : '' }}>Isle of Man</option>
                                            <option value="IL" {{ ( $obj->pays ?? '' ) == 'IL' ? 'selected' : '' }}>Israel</option>
                                            <option value="IT" {{ ( $obj->pays ?? '' ) == 'IT' ? 'selected' : '' }}>Italy</option>
                                            <option value="JM" {{ ( $obj->pays ?? '' ) == 'JM' ? 'selected' : '' }}>Jamaica</option>
                                            <option value="JP" {{ ( $obj->pays ?? '' ) == 'JP' ? 'selected' : '' }}>Japan</option>
                                            <option value="JE" {{ ( $obj->pays ?? '' ) == 'JE' ? 'selected' : '' }}>Jersey</option>
                                            <option value="JO" {{ ( $obj->pays ?? '' ) == 'JO' ? 'selected' : '' }}>Jordan</option>
                                            <option value="KZ" {{ ( $obj->pays ?? '' ) == 'KZ' ? 'selected' : '' }}>Kazakhstan</option>
                                            <option value="KE" {{ ( $obj->pays ?? '' ) == 'KE' ? 'selected' : '' }}>Kenya</option>
                                            <option value="KI" {{ ( $obj->pays ?? '' ) == 'KI' ? 'selected' : '' }}>Kiribati</option>
                                            <option value="KP" {{ ( $obj->pays ?? '' ) == 'KP' ? 'selected' : '' }}>Korea, Democratic People's Republic of</option>
                                            <option value="KR" {{ ( $obj->pays ?? '' ) == 'KR' ? 'selected' : '' }}>Korea, Republic of</option>
                                            <option value="KW" {{ ( $obj->pays ?? '' ) == 'KW' ? 'selected' : '' }}>Kuwait</option>
                                            <option value="KG" {{ ( $obj->pays ?? '' ) == 'KG' ? 'selected' : '' }}>Kyrgyzstan</option>
                                            <option value="LA" {{ ( $obj->pays ?? '' ) == 'LA' ? 'selected' : '' }}>Lao People's Democratic Republic</option>
                                            <option value="LV" {{ ( $obj->pays ?? '' ) == 'LV' ? 'selected' : '' }}>Latvia</option>
                                            <option value="LB" {{ ( $obj->pays ?? '' ) == 'LB' ? 'selected' : '' }}>Lebanon</option>
                                            <option value="LS" {{ ( $obj->pays ?? '' ) == 'LS' ? 'selected' : '' }}>Lesotho</option>
                                            <option value="LR" {{ ( $obj->pays ?? '' ) == 'LR' ? 'selected' : '' }}>Liberia</option>
                                            <option value="LY" {{ ( $obj->pays ?? '' ) == 'LY' ? 'selected' : '' }}>Libya</option>
                                            <option value="LI" {{ ( $obj->pays ?? '' ) == 'LI' ? 'selected' : '' }}>Liechtenstein</option>
                                            <option value="LT" {{ ( $obj->pays ?? '' ) == 'LT' ? 'selected' : '' }}>Lithuania</option>
                                            <option value="LU" {{ ( $obj->pays ?? '' ) == 'LU' ? 'selected' : '' }}>Luxembourg</option>
                                            <option value="MO" {{ ( $obj->pays ?? '' ) == 'MO' ? 'selected' : '' }}>Macao</option>
                                            <option value="MK" {{ ( $obj->pays ?? '' ) == 'MK' ? 'selected' : '' }}>Macedonia, the former Yugoslav Republic of</option>
                                            <option value="MG" {{ ( $obj->pays ?? '' ) == 'MG' ? 'selected' : '' }}>Madagascar</option>
                                            <option value="MW" {{ ( $obj->pays ?? '' ) == 'MW' ? 'selected' : '' }}>Malawi</option>
                                            <option value="MY" {{ ( $obj->pays ?? '' ) == 'MY' ? 'selected' : '' }}>Malaysia</option>
                                            <option value="MV" {{ ( $obj->pays ?? '' ) == 'MV' ? 'selected' : '' }}>Maldives</option>
                                            <option value="ML" {{ ( $obj->pays ?? '' ) == 'ML' ? 'selected' : '' }}>Mali</option>
                                            <option value="MT" {{ ( $obj->pays ?? '' ) == 'MT' ? 'selected' : '' }}>Malta</option>
                                            <option value="MH" {{ ( $obj->pays ?? '' ) == 'MH' ? 'selected' : '' }}>Marshall Islands</option>
                                            <option value="MQ" {{ ( $obj->pays ?? '' ) == 'MQ' ? 'selected' : '' }}>Martinique</option>
                                            <option value="MR" {{ ( $obj->pays ?? '' ) == 'MR' ? 'selected' : '' }}>Mauritania</option>
                                            <option value="MU" {{ ( $obj->pays ?? '' ) == 'MU' ? 'selected' : '' }}>Mauritius</option>
                                            <option value="YT" {{ ( $obj->pays ?? '' ) == 'YT' ? 'selected' : '' }}>Mayotte</option>
                                            <option value="MX" {{ ( $obj->pays ?? '' ) == 'MX' ? 'selected' : '' }}>Mexico</option>
                                            <option value="FM" {{ ( $obj->pays ?? '' ) == 'FM' ? 'selected' : '' }}>Micronesia, Federated States of</option>
                                            <option value="MD" {{ ( $obj->pays ?? '' ) == 'MD' ? 'selected' : '' }}>Moldova, Republic of</option>
                                            <option value="MC" {{ ( $obj->pays ?? '' ) == 'MC' ? 'selected' : '' }}>Monaco</option>
                                            <option value="MN" {{ ( $obj->pays ?? '' ) == 'MN' ? 'selected' : '' }}>Mongolia</option>
                                            <option value="ME" {{ ( $obj->pays ?? '' ) == 'ME' ? 'selected' : '' }}>Montenegro</option>
                                            <option value="MS" {{ ( $obj->pays ?? '' ) == 'MS' ? 'selected' : '' }}>Montserrat</option>
                                            <option value="MA" {{ ( $obj->pays ?? '' ) == 'MA' ? 'selected' : '' }}>Morocco</option>
                                            <option value="MZ" {{ ( $obj->pays ?? '' ) == 'MZ' ? 'selected' : '' }}>Mozambique</option>
                                            <option value="MM" {{ ( $obj->pays ?? '' ) == 'MM' ? 'selected' : '' }}>Myanmar</option>
                                            <option value="NA" {{ ( $obj->pays ?? '' ) == 'NA' ? 'selected' : '' }}>Namibia</option>
                                            <option value="NR" {{ ( $obj->pays ?? '' ) == 'NR' ? 'selected' : '' }}>Nauru</option>
                                            <option value="NP" {{ ( $obj->pays ?? '' ) == 'NP' ? 'selected' : '' }}>Nepal</option>
                                            <option value="NL" {{ ( $obj->pays ?? '' ) == 'NL' ? 'selected' : '' }}>Netherlands</option>
                                            <option value="NC" {{ ( $obj->pays ?? '' ) == 'NC' ? 'selected' : '' }}>New Caledonia</option>
                                            <option value="NZ" {{ ( $obj->pays ?? '' ) == 'NZ' ? 'selected' : '' }}>New Zealand</option>
                                            <option value="NI" {{ ( $obj->pays ?? '' ) == 'NI' ? 'selected' : '' }}>Nicaragua</option>
                                            <option value="NE" {{ ( $obj->pays ?? '' ) == 'NE' ? 'selected' : '' }}>Niger</option>
                                            <option value="NG" {{ ( $obj->pays ?? '' ) == 'NG' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="NU" {{ ( $obj->pays ?? '' ) == 'NU' ? 'selected' : '' }}>Niue</option>
                                            <option value="NF" {{ ( $obj->pays ?? '' ) == 'NF' ? 'selected' : '' }}>Norfolk Island</option>
                                            <option value="MP" {{ ( $obj->pays ?? '' ) == 'MP' ? 'selected' : '' }}>Northern Mariana Islands</option>
                                            <option value="NO" {{ ( $obj->pays ?? '' ) == 'NO' ? 'selected' : '' }}>Norway</option>
                                            <option value="OM" {{ ( $obj->pays ?? '' ) == 'OM' ? 'selected' : '' }}>Oman</option>
                                            <option value="PK" {{ ( $obj->pays ?? '' ) == 'PK' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="PW" {{ ( $obj->pays ?? '' ) == 'PW' ? 'selected' : '' }}>Palau</option>
                                            <option value="PS" {{ ( $obj->pays ?? '' ) == 'PS' ? 'selected' : '' }}>Palestinian Territory, Occupied</option>
                                            <option value="PA" {{ ( $obj->pays ?? '' ) == 'PA' ? 'selected' : '' }}>Panama</option>
                                            <option value="PG" {{ ( $obj->pays ?? '' ) == 'PG' ? 'selected' : '' }}>Papua New Guinea</option>
                                            <option value="PY" {{ ( $obj->pays ?? '' ) == 'PY' ? 'selected' : '' }}>Paraguay</option>
                                            <option value="PE" {{ ( $obj->pays ?? '' ) == 'PE' ? 'selected' : '' }}>Peru</option>
                                            <option value="PH" {{ ( $obj->pays ?? '' ) == 'PH' ? 'selected' : '' }}>Philippines</option>
                                            <option value="PN" {{ ( $obj->pays ?? '' ) == 'PN' ? 'selected' : '' }}>Pitcairn</option>
                                            <option value="PL" {{ ( $obj->pays ?? '' ) == 'PL' ? 'selected' : '' }}>Poland</option>
                                            <option value="PT" {{ ( $obj->pays ?? '' ) == 'PT' ? 'selected' : '' }}>Portugal</option>
                                            <option value="PR" {{ ( $obj->pays ?? '' ) == 'PR' ? 'selected' : '' }}>Puerto Rico</option>
                                            <option value="QA" {{ ( $obj->pays ?? '' ) == 'QA' ? 'selected' : '' }}>Qatar</option>
                                            <option value="RE" {{ ( $obj->pays ?? '' ) == 'RE' ? 'selected' : '' }}>Réunion</option>
                                            <option value="RO" {{ ( $obj->pays ?? '' ) == 'RO' ? 'selected' : '' }}>Romania</option>
                                            <option value="RU" {{ ( $obj->pays ?? '' ) == 'RU' ? 'selected' : '' }}>Russian Federation</option>
                                            <option value="RW" {{ ( $obj->pays ?? '' ) == 'RW' ? 'selected' : '' }}>Rwanda</option>
                                            <option value="BL" {{ ( $obj->pays ?? '' ) == 'BL' ? 'selected' : '' }}>Saint Barthélemy</option>
                                            <option value="SH" {{ ( $obj->pays ?? '' ) == 'SH' ? 'selected' : '' }}>Saint Helena, Ascension and Tristan da Cunha</option>
                                            <option value="KN" {{ ( $obj->pays ?? '' ) == 'KN' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                                            <option value="LC" {{ ( $obj->pays ?? '' ) == 'LC' ? 'selected' : '' }}>Saint Lucia</option>
                                            <option value="MF" {{ ( $obj->pays ?? '' ) == 'MF' ? 'selected' : '' }}>Saint Martin (French part)</option>
                                            <option value="PM" {{ ( $obj->pays ?? '' ) == 'PM' ? 'selected' : '' }}>Saint Pierre and Miquelon</option>
                                            <option value="VC" {{ ( $obj->pays ?? '' ) == 'VC' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                                            <option value="WS" {{ ( $obj->pays ?? '' ) == 'WS' ? 'selected' : '' }}>Samoa</option>
                                            <option value="SM" {{ ( $obj->pays ?? '' ) == 'SM' ? 'selected' : '' }}>San Marino</option>
                                            <option value="ST" {{ ( $obj->pays ?? '' ) == 'ST' ? 'selected' : '' }}>Sao Tome and Principe</option>
                                            <option value="SA" {{ ( $obj->pays ?? '' ) == 'SA' ? 'selected' : '' }}>Saudi Arabia</option>
                                            <option value="SN" {{ ( $obj->pays ?? '' ) == 'SN' ? 'selected' : '' }}>Senegal</option>
                                            <option value="RS" {{ ( $obj->pays ?? '' ) == 'RS' ? 'selected' : '' }}>Serbia</option>
                                            <option value="SC" {{ ( $obj->pays ?? '' ) == 'SC' ? 'selected' : '' }}>Seychelles</option>
                                            <option value="SL" {{ ( $obj->pays ?? '' ) == 'SL' ? 'selected' : '' }}>Sierra Leone</option>
                                            <option value="SG" {{ ( $obj->pays ?? '' ) == 'SG' ? 'selected' : '' }}>Singapore</option>
                                            <option value="SX" {{ ( $obj->pays ?? '' ) == 'SX' ? 'selected' : '' }}>Sint Maarten (Dutch part)</option>
                                            <option value="SK" {{ ( $obj->pays ?? '' ) == 'SK' ? 'selected' : '' }}>Slovakia</option>
                                            <option value="SI" {{ ( $obj->pays ?? '' ) == 'SI' ? 'selected' : '' }}>Slovenia</option>
                                            <option value="SB" {{ ( $obj->pays ?? '' ) == 'SB' ? 'selected' : '' }}>Solomon Islands</option>
                                            <option value="SO" {{ ( $obj->pays ?? '' ) == 'SO' ? 'selected' : '' }}>Somalia</option>
                                            <option value="ZA" {{ ( $obj->pays ?? '' ) == 'ZA' ? 'selected' : '' }}>South Africa</option>
                                            <option value="GS" {{ ( $obj->pays ?? '' ) == 'GS' ? 'selected' : '' }}>South Georgia and the South Sandwich Islands</option>
                                            <option value="SS" {{ ( $obj->pays ?? '' ) == 'SS' ? 'selected' : '' }}>South Sudan</option>
                                            <option value="ES" {{ ( $obj->pays ?? '' ) == 'ES' ? 'selected' : '' }}>Spain</option>
                                            <option value="LK" {{ ( $obj->pays ?? '' ) == 'LK' ? 'selected' : '' }}>Sri Lanka</option>
                                            <option value="SD" {{ ( $obj->pays ?? '' ) == 'SD' ? 'selected' : '' }}>Sudan</option>
                                            <option value="SR" {{ ( $obj->pays ?? '' ) == 'SR' ? 'selected' : '' }}>Suriname</option>
                                            <option value="SJ" {{ ( $obj->pays ?? '' ) == 'SJ' ? 'selected' : '' }}>Svalbard and Jan Mayen</option>
                                            <option value="SZ" {{ ( $obj->pays ?? '' ) == 'SZ' ? 'selected' : '' }}>Swaziland</option>
                                            <option value="SE" {{ ( $obj->pays ?? '' ) == 'SE' ? 'selected' : '' }}>Sweden</option>
                                            <option value="CH" {{ ( $obj->pays ?? '' ) == 'CH' ? 'selected' : '' }}>Switzerland</option>
                                            <option value="SY" {{ ( $obj->pays ?? '' ) == 'SY' ? 'selected' : '' }}>Syrian Arab Republic</option>
                                            <option value="TW" {{ ( $obj->pays ?? '' ) == 'TW' ? 'selected' : '' }}>Taiwan, Province of China</option>
                                            <option value="TJ" {{ ( $obj->pays ?? '' ) == 'TJ' ? 'selected' : '' }}>Tajikistan</option>
                                            <option value="TZ" {{ ( $obj->pays ?? '' ) == 'TZ' ? 'selected' : '' }}>Tanzania, United Republic of</option>
                                            <option value="TH" {{ ( $obj->pays ?? '' ) == 'TH' ? 'selected' : '' }}>Thailand</option>
                                            <option value="TL" {{ ( $obj->pays ?? '' ) == 'TL' ? 'selected' : '' }}>Timor-Leste</option>
                                            <option value="TG" {{ ( $obj->pays ?? '' ) == 'TG' ? 'selected' : '' }}>Togo</option>
                                            <option value="TK" {{ ( $obj->pays ?? '' ) == 'TK' ? 'selected' : '' }}>Tokelau</option>
                                            <option value="TO" {{ ( $obj->pays ?? '' ) == 'TO' ? 'selected' : '' }}>Tonga</option>
                                            <option value="TT" {{ ( $obj->pays ?? '' ) == 'TT' ? 'selected' : '' }}>Trinidad and Tobago</option>
                                            <option value="TN" {{ ( $obj->pays ?? '' ) == 'TN' ? 'selected' : '' }}>Tunisia</option>
                                            <option value="TR" {{ ( $obj->pays ?? '' ) == 'TR' ? 'selected' : '' }}>Turkey</option>
                                            <option value="TM" {{ ( $obj->pays ?? '' ) == 'TM' ? 'selected' : '' }}>Turkmenistan</option>
                                            <option value="TC" {{ ( $obj->pays ?? '' ) == 'TC' ? 'selected' : '' }}>Turks and Caicos Islands</option>
                                            <option value="TV" {{ ( $obj->pays ?? '' ) == 'TV' ? 'selected' : '' }}>Tuvalu</option>
                                            <option value="UG" {{ ( $obj->pays ?? '' ) == 'UG' ? 'selected' : '' }}>Uganda</option>
                                            <option value="UA" {{ ( $obj->pays ?? '' ) == 'UA' ? 'selected' : '' }}>Ukraine</option>
                                            <option value="AE" {{ ( $obj->pays ?? '' ) == 'AE' ? 'selected' : '' }}>United Arab Emirates</option>
                                            <option value="GB" {{ ( $obj->pays ?? '' ) == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="US" {{ ( $obj->pays ?? '' ) == 'US' ? 'selected' : '' }}>United States</option>
                                            <option value="UM" {{ ( $obj->pays ?? '' ) == 'UM' ? 'selected' : '' }}>United States Minor Outlying Islands</option>
                                            <option value="UY" {{ ( $obj->pays ?? '' ) == 'UY' ? 'selected' : '' }}>Uruguay</option>
                                            <option value="UZ" {{ ( $obj->pays ?? '' ) == 'UZ' ? 'selected' : '' }}>Uzbekistan</option>
                                            <option value="VU" {{ ( $obj->pays ?? '' ) == 'VU' ? 'selected' : '' }}>Vanuatu</option>
                                            <option value="VE" {{ ( $obj->pays ?? '' ) == 'VE' ? 'selected' : '' }}>Venezuela, Bolivarian Republic of</option>
                                            <option value="VN" {{ ( $obj->pays ?? '' ) == 'VN' ? 'selected' : '' }}>Viet Nam</option>
                                            <option value="VG" {{ ( $obj->pays ?? '' ) == 'VG' ? 'selected' : '' }}>Virgin Islands, British</option>
                                            <option value="VI" {{ ( $obj->pays ?? '' ) == 'VI' ? 'selected' : '' }}>Virgin Islands, U.S.</option>
                                            <option value="WF" {{ ( $obj->pays ?? '' ) == 'WF' ? 'selected' : '' }}>Wallis and Futuna</option>
                                            <option value="EH" {{ ( $obj->pays ?? '' ) == 'EH' ? 'selected' : '' }}>Western Sahara</option>
                                            <option value="YE" {{ ( $obj->pays ?? '' ) == 'YE' ? 'selected' : '' }}>Yemen</option>
                                            <option value="ZM" {{ ( $obj->pays ?? '' ) == 'ZM' ? 'selected' : '' }}>Zambia</option>
                                            <option value="ZW" {{ ( $obj->pays ?? '' ) == 'ZW' ? 'selected' : '' }}>Zimbabwe</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Situation <span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <select class="custom-select my-2" name="sitMat" id="sitMat"disabled>
                                            <option value="m" {{ ($obj->sm ?? '') == 'm' ? 'selected' : '' }}>Marié(e)</option>
                                            <option value="c" {{ ($obj->sm ?? '') == 'c' ? 'selected' : '' }}>Célibataire</option>
                                            <option value="p" {{ ($obj->sm ?? '') == 'p' ? 'selected' : '' }}>Concubinage</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Enfant(s)<span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <input class="form-control my-2" name="child" id="child" type="number" min="0" max="40"  disabled value="{{ $obj->enfants }}"  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Fonction<span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <input class="form-control my-2" name="work" id="work" type="text"  disabled value="{{ $obj->fonction }}"  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="login">Lieu de travail<span class="text-danger" style="font-size:20px;">&nbsp;</span></label>
                                        <input class="form-control my-2" name="workplace" id="workplace" type="text"  disabled value="{{ $obj->lieu_travail }}"  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="email">Email<span class="text-danger" style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('email') is-invalid @enderror my-2" name="email" id="email" type="email"  disabled value="{{ $obj->email }}"  />
                                    </div>
                                    <div class="form-group row">
                                        <label class="small mb-1" for="contact">Contact<span class="text-danger" style="font-size:20px;">*</span></label>
                                        <input class="form-control @error('email') is-invalid @enderror my-2" name="contact" id="contact" type="text"  disabled value="{{ $obj->contact }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</main>
@endsection
<i class="fa fa4-click"></i>
