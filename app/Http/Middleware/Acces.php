<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use App\Utilisateur;

class Acces
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $session;
    protected $timeout = 120;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function getTimeOut()
    {
        return $this->timeout;
    }

    public function handle($request, Closure $next)
    {

        /*
        if(!$this->session->has('lastActivityTime'))
            $this->session->put('lastActivityTime',time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->getTimeOut())
        {
            $this->session->forget('lastActivityTime');
            return redirect('/disconnect')->with('error','You had not activity in 1 minute');
        }*/
        $user = null;
        if(session()->has('user_id'))
        $user = \DB::table('utilisateurs')
                    ->where('utilisateurs.id',session()->get('user_id'))
                    ->select('utilisateurs.*')
                    ->first();

        if( $user != null )
        {
            //Verifier s'il s'agit d'une route du module resultat
            if( $request->route()->uri == 'resultat' || $request->route()->uri == 'getAll' || $request->route()->uri =='getByCriteres' || $request->route()->uri == 'focus_result/{id}' )
            {
                if( $user->resultat )
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module candidat
            if($request->route()->uri == 'add_candidat' || $request->route()->uri == 'manage' || $request->route()->uri == 'extract' || $request->route()->uri == 'getMatiere'
                || $request->route()->uri == 'focus_candidat/{id}' || $request->route()->uri == 'edit_candidat/{id}/edit' || $request->route()->uri == 'edit_candidat/{obj}'
                || $request->route()->uri == 'delete_candidat/{obj}' || $request->route()->uri == 'oral'
                || $request->route()->uri == 'oralExport' ||  $request->route()->uri == 'oralImport' )
            {
                if ($user->candidat)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module utilisateurs
            if ($request->route()->uri == 'add_user' || $request->route()->uri == 'focus_user/{id}' || $request->route()->uri == 'manage_user' || $request->route()->uri == 'edit_user/{id}/edit'
                || $request->route()->uri == 'edit_user/{user}' || $request->route()->uri == 'delete/{user}' )
            {
                if ($user->utilisateur)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module session
            if ($request->route()->uri == 'add_session' || $request->route()->uri == 'manage_session' || $request->route()->uri == 'focus_session/{id}' || $request->route()->uri == 'edit_session/{id}/edit'
                || $request->route()->uri == 'edit_session/{session}' || $request->route()->uri == 'delete_session/{session}' )
            {
                if ($user->session)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du sous module matiere
            if($request->route()->uri == 'add_matiere' || $request->route()->uri == 'manage_matiere' || $request->route()->uri == 'edit_matiere/{id}/edit' || $request->route()->uri == 'edit_matiere/{matiere}'
                || $request->route()->uri == 'delete_matiere/{matiere}'
            ) {
                if ($user->session)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module convocation
            if($request->route()->uri == 'edit_data' || $request->route()->uri == 'edit_data/{id}' || $request->route()->uri == 'print_convocation' || $request->route()->uri == 'convocation' || $request->route()->uri == 'singleConvocation'
                || $request->route()->uri == 'verify' )
            {
                if ($user->convocation)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module note
            if($request->route()->uri == 'note' || $request->route()->uri == 'verifyCode' || $request->route()->uri == 'saveNote' || $request->route()->uri == 'getNoteResult'
                || $request->route()->uri == 'getMatiereCode'  || $request->route()->uri == 'saving' )
            {
                if ($user->note)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route d'edition de note
            if ($request->route()->uri == 'editNote' || $request->route()->uri == 'getMatiereCodeEdit'
            ) {
                if ($user->note_edit)
                return $next($request);
            }

            //Verifier s'il s'agit d'une route du module numero
            if($request->route()->uri == 'generate' || $request->route()->uri == 'show' || $request->route()->uri == 'generation' || $request->route()->uri == 'extract_code')
            {
                if ($user->numero)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module reinscription
            if($request->route()->uri == 'reinscription' || $request->route()->uri == 'getCandidatInfo'|| $request->route()->uri == 'verifyIdtf'
                || $request->route()->uri == 'doublon')
            {
                if ($user->reinscription)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module releve
            if ($request->route()->uri == 'releves' || $request->route()->uri == 'verifyReleve'  || $request->route()->uri == 'singleReleve'  )
            {
                if ($user->releve)
                    return $next($request);
            }

            //Verifier s'il s'agit d'une route du module attestation
            if ( $request->route()->uri =='attestations' || $request->route()->uri =='verifyAttestation' || $request->route()->uri == 'singleAttestation')
            {
                if ($user->attestation)
                    return $next($request);
            }

            if( $request->route()->uri() == 'index' || $request->route()->uri() == '/' )
            {
                return $next($request);
            }

            return redirect('error_403');
        }
        else
        {
            return redirect('error_401');
        }

        //if($request->route()->uri == 'oklm')
          //  return redirect('home');
        //return $next($request);*/
    }
}
