<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class TournamentController extends Controller
{
    // index
    public function index(){
        return view('admin.tournament.index');
    }

    // create
    public function create(){
        return view('admin.tournament.create');
    }

    // edit
    public function edit($id){

        $tournament = Tournament::findOrFail($id);
        return view('admin.tournament.edit',compact('tournament'));
    }
}
