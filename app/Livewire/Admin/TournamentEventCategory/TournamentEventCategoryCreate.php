<?php

namespace App\Livewire\Admin\TournamentEventCategory;

use Livewire\Component;
use App\Models\Tournament;
use App\Models\ActivityLog;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\TournamentEventCategory;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TournamentEventCategoryOptions;

class TournamentEventCategoryCreate extends Component
{

    use WithFileUploads;
    public $name;
    public $status;
    public $type;
    public $allowed_gender; 

    public $category_options = ['']; // Initialize with one phone field

     
    public $tournament_search;
    public $tournament_event_search;

    public $tournament_id; 
    public $tournament_event_id; 

    public $tournament;

    public $selected_tournament;
    public $selected_tournament_event;

    public $cancel_route;


    public function mount(){
         
        $this->tournament_id = request()->query('tournament_id', ''); // Default to empty string if not set
        if(!empty($this->tournament_id)){
            $this->selected_tournament = Tournament::findOrFail($this->tournament_id); 
        }


        $this->tournament_event_id = request()->query('tournament_event_id', ''); // Default to empty string if not set
        if(!empty($this->tournament_event_id)){
            $this->selected_tournament_event = TournamentEvent::findOrFail($this->tournament_event_id);
            $this->selected_tournament = Tournament::findOrFail($this->selected_tournament_event->tournament_id); 
            $data = [];
            $data['tournament_id'] = $this->selected_tournament_event->tournament_id;
            $data['tournament_event_id'] = $this->selected_tournament_event->id;


            $this->cancel_route = route('tournament_event_category.index',$data);
        }


        $this->status = "active";

            
    }


    public function search_tournament($id){

        $data = [];
        $data['tournament_id'] = $id;
        $data['tournament_event_id'] = null;
        
        return redirect()->route('tournament_event_category.create',$data);
    }

    public function search_tournament_event($id){

        $tournament_event = TournamentEvent::findOrFail($id);

        $data = [];
        $data['tournament_id'] = $tournament_event->tournament_id;
        $data['tournament_event_id'] = $tournament_event->id;
        
        return redirect()->route('tournament_event_category.create',$data);
    }


    // Method to add a new category option input
    public function addCategoryOption()
    {
        $this->category_options[] = ''; // Add a new empty phone input
    }



    // public function search_tournament($id){
    //     return redirect()->route('tournament_event.create',['tournament_id' => $id]);
    // }

    public function updated($fields){
        $this->validateOnly($fields, [
            'tournament_event_id' => [
                'required',
                'exists:tournament_events,id', // Ensure the tournament exists in the database
            ],
        
            'name' => [
                'required',
                'string',
                Rule::unique('tournament_event_categories', 'name') // Ensure event name is unique within events
                    ->where('tournament_event_id', $this->tournament_event_id), // Validate uniqueness per tournament
            ],

            'type' => [
                'required', 
            ],
            'allowed_gender' => [
                'required', 
            ],
         
         
            'category_options.*' => 'nullable|string', // Validate category_options



         
        ]);
        
 

 
    }




    

    public function save(){

        // dd($this->all());
        $this->validate([
            'tournament_event_id' => [
                'required',
                'exists:tournament_events,id', // Ensure the tournament exists in the database
            ],
        
            'name' => [
                'required',
                'string',
                Rule::unique('tournament_event_categories', 'name') // Ensure event name is unique within events
                    ->where('tournament_event_id', $this->tournament_event_id), // Validate uniqueness per tournament
            ],

            'type' => [
                'required', 
            ],
            'allowed_gender' => [
                'required', 
            ],
         
         
            'category_options.*' => 'nullable|string', // Validate category_options


 
        ] );

 
        //save
        $tournament_event_category = TournamentEventCategory::create([
            'name' => $this->name,
            'status' => $this->status,
            'type' =>  $this->type,
            'allowed_gender' =>  $this->allowed_gender,
            'tournament_event_id' =>  $this->tournament_event_id, 
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);




        //save the category_options
            if(!empty($this->category_options)){
                foreach($this->category_options as $category_option_key => $category_option_value){
                    if($category_option_value){
                        $tournament_category_option = new TournamentEventCategoryOptions();
                        $tournament_category_option->name = $category_option_value;
                        $tournament_category_option->status =  $this->status;
                        $tournament_category_option->tournament_event_category_id = $tournament_event_category->id;
                        $tournament_category_option->created_by = Auth::user()->id;
                        $tournament_category_option->updated_by = Auth::user()->id;

                        $tournament_category_option->save();
                    }


                }
            }
         


        ActivityLog::create([
            'log_action' => "Tournament Event \"".$this->name."\" created ",
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success','Tournament Event Category created successfully');

        $data = [];
        $data['tournament_id'] = $this->selected_tournament_event->tournament_id;
        $data['tournament_event_id'] = $this->selected_tournament_event->id;

        return redirect()->route('tournament_event_category.index', $data );
    }



    public function render()
    {


        /**
         * @var tournament records
         */
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


        /**
         * @var TournamentEvent  records
         */
        $event_results = TournamentEvent::select('tournament_events.*');
        if (!empty($this->tournament_event_search) && strlen($this->tournament_event_search) > 0) {
            $search = $this->tournament_event_search;

            // $event_results = $event_results->where(function ($query) use ($search) {
            //     $query->where('projects.name', 'LIKE', '%' . $search . '%')
            //     ->where('projects.name', 'LIKE', '%' . $search . '%')
            //         ;
            // });


            $event_results = $event_results->where(function($query) use ($search) {
                $query->where('tournament_events.name', 'LIKE', '%' . $search . '%');
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

        if (!empty($this->tournament_id) ) {
            $event_results = $event_results->where('tournament_events.tournament_id',$this->tournament_id);
        }
        $event_results =  $event_results->limit(10)->get();




        return view('livewire.admin.tournament-event-category.tournament-event-category-create',[
            'results' =>  $results,
            'event_results' => $event_results
        ]);
    }


    // public function render()
    // {
    //     return view('livewire.admin.tournament-event-category.tournament-event-category-create');
    // }
}
