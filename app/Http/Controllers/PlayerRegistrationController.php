<?php

namespace App\Http\Controllers;

use App\Models\PlayerRegistration;
use Illuminate\Http\Request;

class PlayerRegistrationController extends Controller
{
    // index
    public function index(){
        return view('admin.registration.index');
    }

    // create
    public function create(){
        return view('admin.registration.create');
    }

    // edit
    public function edit($id){

        $player_registration = PlayerRegistration::findOrFail($id);
        return view('admin.registration.edit',compact('player_registration'));
    }

    // show
    public function show($id){
        $player_registration = PlayerRegistration::findOrFail($id);
        return view('admin.registration.show',compact('player_registration'));

    }
}
