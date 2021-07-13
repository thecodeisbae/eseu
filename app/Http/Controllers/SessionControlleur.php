<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\session;

class SessionControlleur extends Controller
{
    //
    public function adding()
    {
        return view('/session.add_session');
    }

    public function show($id)
    {
        $session = Session::where('id',$id)->firstOrFail();
        return view('/session.focus_session',compact('session'));
    }

    public function edit($id)
    {
        $session = Session::where('id',$id)->firstOrFail();
        $oral = $session->getDateOral($session->datetimeOral);
        $ecrit = $session->getDateEcrit($session->datetimeEcrit);
        $other = ([
            'dateOral' => $oral,
            'dateEcrit' => $ecrit
        ]);
        //dd($other['dateOral']);
        return view('/session.edit_session',compact('session','other'));
    }

    public function update(Session $session)
    {
        request()->validate([
            'nom'=>'required',
            'begin_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:begin_date',
            'status'=>'required|min:1',
            'oral'=>'required|numeric',
            'vr'=>'required|string',
            'vrt'=>'required|string',
            'numero'=>'required|string',
            'service_etude'=>'required|string',
            'date_oral'=>'required',
            'date_ecrit'=>'required',
            'passage_moyenne'=>'required|numeric'
        ]);

        if(request('status')=='e'){
            $stat = true;
        }else{
            $stat = false;
        }

        $data = ([
            'nom'=>request('nom'),
            'start'=>request('begin_date'),
            'end'=>request('end_date'),
            'current'=>$stat,
            'numero'=>request('numero'),
            'seuilOral'=>request('oral'),
            'viceRecteur'=>request('vr'),
            'viceRectorat'=>request('vrt'),
            'service'=>request('service_etude'),
            'datetimeOral'=>request('date_oral'),
            'datetimeEcrit'=>request('date_ecrit'),
            'moyenne_passage'=>request('passage_moyenne')
        ]);
        if(!$stat)
            $session->update($data);
        else
        {
            \DB::update('update sessions set current = 0');
            $session->update($data);
            $session_name = Session::select('nom')
                ->where('id', '=', $session->id)
                ->first();
            $session_id = Session::select('id')
                ->where('id', '=', $session->id)
                ->first();
            session()->put('session_name', $session_name);
            session()->put('session_id', $session_id);
        }
        return redirect('/focus_session/'.$session->id);
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return back()->with('success','Session supprimée');
    }

    public function index()
    {
        $sessions = \DB::table('sessions')
                        ->select('id','nom','start','end','current')
                        ->get();
        return view('/session/manage',compact('sessions'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'nom'=>'required',
            'begin_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:begin_date',
            'status'=>'required|min:1',
            'oral'=>'required|numeric',
            'vr'=>'required|string',
            'vrt'=>'required|string',
            'numero'=>'required|string',
            'service_etude'=>'required|string',
            'date_oral'=>'required',
            'date_ecrit'=>'required',
            'passage_moyenne'=>'required|numeric'
        ]);

        if(request('status')=='e')
        {
            $stat = true;
            \DB::update('update sessions set current = 0');
        }else{
            $stat = false;
        }


        $session = new Session();
            $session->nom = request('nom');
            $session->start = request('begin_date');
            $session->end = request('end_date');
            $session->current = $stat;
            $session->numero=request('numero');
            $session->seuilOral = request('oral');
            $session->datetimeOral = request('date_oral');
            $session->datetimeEcrit = request('date_ecrit');
            $session->viceRecteur = request('vr');
            $session->viceRectorat = request('vrt');
            $session->service = request('service_etude');
            $session->moyenne_passage = request('passage_moyenne');
            $session->position = 0;
        $session->save();

        if($stat)
        {
            $session_id = Session::select('id')
                ->where('nom', '=', request('nom'))
                ->where('start','=',request('begin_date'))
                ->first();
            $session_name = Session::select('nom')
                ->where('id', '=', $session_id->id)
                ->first();
            session()->put('session_name', $session_name);
            session()->put('session_id', $session_id);
        }

        return back()->with('success','Nouvelle session créee');
    }

}
