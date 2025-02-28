<?php

namespace App\Http\Controllers;

use App\Models\TournamentEvent;
use Illuminate\Http\Request;

class TournamentEventController extends Controller
{
    // index
    public function index(){
        return view('admin.tournament_event.index');
    }

    // create
    public function create(){
        return view('admin.tournament_event.create');
    }

    // edit
    public function edit($id){

        $tournament_event = TournamentEvent::findOrFail($id);
        return view('admin.tournament_event.edit',compact('tournament_event'));
    }

}
