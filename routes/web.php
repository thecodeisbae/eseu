<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('chart', 'chart');
Route::get('detailsChart','CandidatControlleur@chart');

/*Debut des routes pour le login*/
Route::get('/login', 'LoginControlleur@index');
Route::post('/login', 'LoginControlleur@control');
Route::view('/password','password');
/*Fin des routes pour le login*/

/* Debut des routes du module candidats */
Route::get('oral','CandidatControlleur@oralIndex')->middleware('acces');
Route::post('oralExport','CandidatControlleur@oralExport')->middleware('acces');
Route::post('oralImport','CandidatControlleur@oralImport')->middleware('acces');
Route::get('uploadCandidats','CandidatControlleur@candidatUpload');
Route::get('add_candidat', 'CandidatControlleur@adding')->middleware('acces');
Route::post('add_candidat', 'CandidatControlleur@store')->middleware('acces');
Route::get('manage', 'CandidatControlleur@index')->middleware('acces');
Route::get('extract', 'CandidatControlleur@extraction')->middleware('acces');
Route::post('extract', 'CandidatControlleur@startExtraction')->middleware('acces');
Route::post('/getMatiere', 'CandidatControlleur@getMatieres')->middleware('acces');
Route::get('/focus_candidat/{id}', 'CandidatControlleur@show')->middleware('acces');
Route::get('/edit_candidat/{id}/edit', 'CandidatControlleur@edit')->middleware('acces');
Route::post('/edit_candidat/{obj}', 'CandidatControlleur@update')->middleware('acces');
Route::get('/delete_candidat/{obj}', 'CandidatControlleur@destroy')->middleware('acces');
/* Fin des routes du module candidats */

/* Debut des routes du module utilisateurs */
Route::get('add_user', 'UtilisateurControlleur@adding')->middleware('acces');
Route::post('add_user', 'UtilisateurControlleur@store')->middleware('acces');
Route::get('focus_user/{id}', 'UtilisateurControlleur@show')->middleware('acces');
Route::get('manage_user', 'UtilisateurControlleur@index')->middleware('acces');
Route::get('edit_user/{id}/edit', 'UtilisateurControlleur@edit')->middleware('acces');
Route::patch('edit_user/{user}', 'UtilisateurControlleur@update')->middleware('acces');
Route::get('delete/{user}', 'UtilisateurControlleur@destroy')->middleware('acces');
Route::get('/disconnect','UtilisateurControlleur@disconnect');
/* Fin des routes du module utilisateurs */

/* Debut des routes du module sessions */
Route::get('add_session', 'SessionControlleur@adding')->middleware('acces');
Route::post('add_session', 'SessionControlleur@store')->middleware('acces');
Route::get('manage_session', 'SessionControlleur@index')->middleware('acces');
Route::get('focus_session/{id}', 'SessionControlleur@show')->middleware('acces');
Route::get('edit_session/{id}/edit', 'SessionControlleur@edit')->middleware('acces');
Route::patch('edit_session/{session}', 'SessionControlleur@update')->middleware('acces');
Route::get('delete_session/{session}', 'SessionControlleur@destroy')->middleware('acces');
/* Fin des routes du module sessions */

/* Debut des routes du sous-module matieres */
Route::get('add_matiere', 'MatiereControlleur@adding')->middleware('acces');
Route::post('add_matiere', 'MatiereControlleur@store')->middleware('acces');
Route::get('manage_matiere', 'MatiereControlleur@index')->middleware('acces');
Route::get('edit_matiere/{id}/edit', 'MatiereControlleur@edit')->middleware('acces');
Route::patch('edit_matiere/{matiere}', 'MatiereControlleur@update')->middleware('acces');
Route::get('delete_matiere/{matiere}', 'MatiereControlleur@destroy')->middleware('acces');
/* Fin des routes du sous-module matieres */

/* Debut des routes du module acces */
Route::get('/add_profil', 'AccesControlleur@adding')->middleware('acces');
Route::post('/add_profil', 'AccesControlleur@store')->middleware('acces');
Route::get('/manage_profil', 'AccesControlleur@index')->middleware('acces');
Route::get('/edit_acces/{id}/edit', 'AccesControlleur@edit')->middleware('acces');
Route::patch('/edit_acces/{acces}', 'AccesControlleur@update')->middleware('acces');
Route::get('/delete_acces/{acces}', 'AccesControlleur@destroy')->middleware('acces');
/* Fin des routes du module acces */

/* Debut des routes du module convocations */
Route::get('/edit_data', 'ConvocationControlleur@edit')->middleware('acces');
Route::patch('/edit_data/{id}', 'ConvocationControlleur@update')->middleware('acces');
Route::get('/print_convocation', 'ConvocationControlleur@index')->middleware('acces');
Route::post('/convocation','ConvocationControlleur@getPDF')->middleware('acces');
Route::post('/verify', 'ConvocationControlleur@verifyId')->middleware('acces');
Route::post('/singleConvocation', 'ConvocationControlleur@getHisPDF')->middleware('acces');
/* Fin des routes du module convocations */

/* Debut des routes du module numeros */
Route::get('generate', 'NumeroControlleur@index')->middleware('acces');
Route::post('show', 'NumeroControlleur@show')->middleware('acces');
Route::post('generation', 'NumeroControlleur@generate')->middleware('acces');
Route::get('/extract_code', 'NumeroControlleur@extract')->middleware('acces');
Route::post('/extract_code', 'NumeroControlleur@startExtract')->middleware('acces');
/* Fin des routes du module numeros */

/* Debut des routes du module notes */
Route::get('/note', 'NoteControlleur@index')->middleware('acces');
Route::get('/editNote', 'NoteControlleur@editIndex')->middleware('acces');
Route::post('/getMatiereCode', 'NoteControlleur@getMatieres')->middleware('acces');
Route::post('/getMatiereCodeEdit', 'NoteControlleur@getMatieresEdit');
Route::post('/saveNote', 'NoteControlleur@store')->middleware('acces');
Route::post('/saving', 'NoteControlleur@saving')->middleware('acces');
Route::post('/getNoteResult','NoteControlleur@view')->middleware('acces');
Route::post('/verifyCode', 'NoteControlleur@verifyCode')->middleware('acces');
/* Fin des routes du modle notes */

/* Debut des routes du module resultat */
Route::get('/resultat','ResultatControlleur@index')->middleware('acces');
Route::get('/exportResult','ResultatControlleur@extract');
Route::post('/exportResult','ResultatControlleur@getPDF');
Route::post('/getAll','ResultatControlleur@getAll')->middleware('acces');
Route::post('/getByCriteres','ResultatControlleur@getByCriteres')->middleware('acces');
Route::get('/focus_result/{id}','ResultatControlleur@show')->middleware('acces');
/* Fin des routes pour le module resultat */

/* Debut des routes du module reinscription */
Route::get('/reinscription','ReinscriptionControlleur@create')->middleware('acces');
Route::post('/getCandidatInfo','ReinscriptionControlleur@getCandidats')->middleware('acces');
Route::post('/reinscription','ReinscriptionControlleur@store')->middleware('acces');
Route::post('/verifyIdtf','ReinscriptionControlleur@verify')->middleware('acces');
Route::post('/doublon', 'ReinscriptionControlleur@doublon')->middleware('acces');
/* Fin des routes du module reinscription */

/* Debut des routes de traitement des erreurs */
Route::view('/oklm','test')->middleware('acces');
Route::view('/error_403','error.forbidden');
Route::view('/error_401','error.unauthentified');
Route::view('/error_404','error.notfound');
Route::view('/disabled', 'error.disabled');
/* Fin des routes de traitement des erreurs */

/* Debut des routes pour le module mail */
//Route::get('/send_mail','MailController@index');
Route::get('/send-mail','MailController@index' );
/* Fin des routes du module mail */

/* Accueil */
Route::get('/index','AccueilControlleur@index')->middleware('acces');
Route::get('/', 'AccueilControlleur@index')->middleware('acces');
/* Fin accueil */

/* Debut des routes du module supplement */
Route::get('/releves','SupplementControlleur@indexReleves')->middleware('acces');
Route::get('/attestations','SupplementControlleur@indexAttestations')->middleware('acces');
Route::post('/releves','SupplementControlleur@getReleves')->middleware('acces');
Route::post('/singleReleve', 'SupplementControlleur@singleReleve')->middleware('acces');
Route::post('/singleAttestation', 'SupplementControlleur@singleAttestation')->middleware('acces');
Route::post('/verifyReleve', 'SupplementControlleur@verifyReleve')->middleware('acces');
Route::post('/verifyAttestation', 'SupplementControlleur@verifyAttestation')->middleware('acces');
Route::post('/attestations','SupplementControlleur@getAttestations')->middleware('acces');
/* Fin des routes du module supplement */

/* Debut des routes du module recherche */
Route::post('/search','RechercheControlleur@searchResult');
Route::view('/empty','empty');
Route::post('/focus','RechercheControlleur@focus');
/* Fin des routes du module redcherche*/

Route::get('/firstLaunch','LaunchControlleur@index');

Route::get('/import','ImportFileControlleur@index');
Route::post('/import','ImportFileControlleur@export');

Route::get('test', function () {
    return view('test');
});

Route::get('/set','TestControlleur@set');
Route::get('/addRecords/{id}','TestControlleur@addRecords');

Route::get('light', function () {
    return view('light');
});
Route::get('static', function () {
    return view('static');
});
Route::get('pic', function () {
    return view('candidat/pic');
});
Route::get('slider', function () {
    return view('slider');
});
Route::get('/createWord', 'WorldTestController@createWordDocx');

Route::get('focus_session', function () {
    return view('session/focus_session');
});

Route::get('preview', 'TestControlleur@test');
