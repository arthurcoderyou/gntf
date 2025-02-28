<?php

namespace App\Livewire\Admin\TournamentEvent;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Tournament;
use App\Models\ActivityLog;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Rules\EventDateWithinTournament;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentEventCreate extends Component
{

    use WithFileUploads;
    public $name;
    public $status;
    public $start_date;
    public $end_date; 
    public $registration_deadline; 
    public $junior_event;

    public $daterange;
    public $date;

    public $tournament_search;

    public $tournament_id;
    public $tournament;

    public $cancel_route;

    


    public function mount(){
        $this->tournament_id = request()->query('tournament_id', ''); // Default to empty string if not set

        if(!empty($this->tournament_id)){
            $this->tournament = Tournament::findOrFail($this->tournament_id);
            $this->cancel_route = route('tournament_event.index',['tournament_id' =>  $this->tournament_id]);
        }


        $this->status = "active";
        $this->junior_event = "no";

            
    }


    public function search_tournament($id){
        return redirect()->route('tournament_event.create',['tournament_id' => $id]);
    }

    public function updated($fields){
        $this->validateOnly($fields, [
            'tournament_id' => [
                'required',
                'exists:tournaments,id', // Ensure the tournament exists in the database
            ],
        
            'name' => [
                'required',
                'string',
                Rule::unique('tournament_events', 'name') // Ensure event name is unique within events
                    ->where('tournament_id', $this->tournament_id), // Validate uniqueness per tournament
            ],
        
            'start_date' => [
                'required',
                'date',
                new EventDateWithinTournament($this->tournament_id),
            ],
        
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date', // Ensure the event end_date is after or equal to start_date
                new EventDateWithinTournament($this->tournament_id),
            ],

            'registration_deadline' => [
                'required',
                'date',
                // 'after_or_equal:start_date', // Ensure the event end_date is after or equal to start_date
                // new EventDateWithinTournament($this->tournament_id),
            ],
        
            'status' => [
                'required',
                'string',
            ],

            'junior_event' => [
                'required',
                'string',
            ],

         
        ]);
        
 

 
    }




    

    public function save(){

        // dd($this->all());
        $this->validate([
            'tournament_id' => [
                'required',
                'exists:tournaments,id', // Ensure the tournament exists in the database
            ],
        
            'name' => [
                'required',
                'string',
                Rule::unique('tournament_events', 'name') // Ensure event name is unique within events
                    ->where('tournament_id', $this->tournament_id), // Validate uniqueness per tournament
            ],
        
            'start_date' => [
                'required',
                'date',
                new EventDateWithinTournament($this->tournament_id),
            ],
        
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date', // Ensure the event end_date is after or equal to start_date
                new EventDateWithinTournament($this->tournament_id),
            ],

            'registration_deadline' => [
                'required',
                'date',
                // 'after_or_equal:start_date', // Ensure the event end_date is after or equal to start_date
                // new EventDateWithinTournament($this->tournament_id),
            ],
        
            'status' => [
                'required',
                'string',
            ],

            'junior_event' => [
                'required',
                'string',
            ],
 
        ] );

 
        //save
        $tournament_event = TournamentEvent::create([
            'name' => $this->name,
            'status' => $this->status,
            'start_date' =>  $this->start_date,
            'end_date' =>  $this->end_date,
            'registration_deadline' =>  $this->registration_deadline,
            'junior_event' => $this->junior_event,    
            'tournament_id' => $this->tournament_id,  
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

 
         


        ActivityLog::create([
            'log_action' => "Tournament Event \"".$this->name."\" created ",
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success','Tournament Event created successfully');
        return redirect()->route('tournament_event.index',['tournament_id' => $this->tournament_id]);
    }



    public function render()
    {


        $results = Tournament::select('tournaments.*');
        if (!empty($this->tournament_search) && strlen($this->tournament_search) > 0) {
            $search = $this->tournament_search;

            // $results = $results->where(function ($query) use ($search) {
            //     $query->where('projects.name', 'LIKE', '%' . $search . '%')
            //     ->where('projects.name', 'LIKE', '%' . $search . '%')
            //         ;
            // });


            $results = $results->where(function($query) use ($search) {
                $query->where('tournaments.name', 'LIKE', '%' . $search . '%');
                    // ->orWhere('projects.federal_agency', 'LIKE', '%' . $search . '%')
                    // ->orWhere('projects.description', 'LIKE', '%' . $search . '%')
                    // // ->orWhereHas('creator', function ($query) use ($search) {
                    // //     $query->where('users.name', 'LIKE', '%' . $search . '%')
                    // //         ->where('users.email', 'LIKE', '%' . $search . '%');
                    // // })
                    // // ->orWhereHas('updator', function ($query) use ($search) {
                    // //     $query->where('users.name', 'LIKE', '%' . $search . '%')
                    // //         ->where('users.email', 'LIKE', '%' . $search . '%');
                    // // })
                    // ->orWhereHas('project_reviewers.user', function ($query) use ($search) {
                    //     $query->where('users.name', 'LIKE', '%' . $search . '%')
                    //     ->where('users.email', 'LIKE', '%' . $search . '%');
                    // });
            });


        }
        $results =  $results->limit(10)->get();




        return view('livewire.admin.tournament-event.tournament-event-create',[
            'results' => $results
        ]);
    }
}
