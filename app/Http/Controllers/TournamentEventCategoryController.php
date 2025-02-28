<?php

namespace App\Http\Controllers;

use App\Models\TournamentEventCategory;
use Illuminate\Http\Request;

class TournamentEventCategoryController extends Controller
{
    // index
    public function index(){
        return view('admin.tournament_event_category.index');
    }

    // create
    public function create(){
        return view('admin.tournament_event_category.create');
    }

    // edit
    public function edit($id){

        $tournament_event_category = TournamentEventCategory::findOrFail($id);
        return view('admin.tournament_event_category.edit',compact('tournament_event_category'));
    }
}
