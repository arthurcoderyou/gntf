<?php

namespace App\Livewire\Admin\Registration;

use App\Models\User;
use Livewire\Component; 
use App\Models\Tournament;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use App\Models\PlayerRegistration;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\TournamentEventCategory;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TournamentEventCategoryOptions;

class RegistrationIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $search = '';
    public $sort_by = '';
    public $sort_by_gender = '';

    public $sort_by_payment_status = '';
    public $sort_by_registration_status = '';
    public $record_count = 10;

    public $selected_records = [];
    public $selectAll = false;

    public $count = 0;

    public $tournament_search;
    public $tournament_event_search;
    public $tournament_event_category_search;
    public $tournament_event_category_option_search;
    public $user_search;


    public $tournament_id;
    public $tournament_event_id;

    public $tournament_event_category_id;
    public $tournament_event_category_option_id;
    public $user_id;



    public $selected_tournament;
    public $selected_tournament_event;

    public $selected_tournament_event_category;
    public $selected_tournament_event_category_option;
    public $selected_user;
    
    public $add_route_with_tournament_event_id;

    public function mount(){

        $this->selected_tournament = Tournament::getActiveTournament();

        $this->tournament_id = $this->selected_tournament->id;

        // $this->tournament_id = request()->query('tournament_id', ''); // Default to empty string if not set
        // if(!empty($this->tournament_id)){
        //     $this->selected_tournament = Tournament::findOrFail($this->tournament_id); 
        // }


        // $this->tournament_event_id = request()->query('tournament_event_id', ''); // Default to empty string if not set
        // if(!empty($this->tournament_event_id)){
        //     $this->selected_tournament_event = TournamentEvent::findOrFail($this->tournament_event_id);
        //     $this->tournament_id = $this->selected_tournament_event->tournament_id;
        //     $this->selected_tournament = Tournament::findOrFail($this->selected_tournament_event->tournament_id); 


        //     $data = [];
        //     $data['tournament_id'] = $this->selected_tournament_event->tournament_id;
        //     $data['tournament_event_id'] = $this->selected_tournament_event->id;

        //     $this->add_route_with_tournament_event_id = route('tournament_event_category.create',$data);
        // }



    }


    // Method to delete selected records
    public function deleteSelected()
    {
        $player_registrations = PlayerRegistration::whereIn('id', $this->selected_records)->get(); // Delete the selected records

        foreach($player_registrations as $player_registration){
             


            // Ensure the options relation is deleted properly
            if ($player_registration->registered_options()->exists()) {
                $player_registration->registered_options()->delete();
            }

            $player_registration->delete();
        }
        


        $this->selected_records = []; // Clear selected records

        Alert::success('Success','Selected player registrations deleted successfully');
        return redirect()->route('player_registration.index');
    }

    // This method is called automatically when selected_records is updated
    public function updateSelectedCount()
    {
        // Update the count when checkboxes are checked or unchecked
        $this->count = count($this->selected_records);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selected_records = PlayerRegistration::pluck('id')->toArray(); // Select all records
        } else {
            $this->selected_records = []; // Deselect all
        }

        $this->count = count($this->selected_records);
    }

    public function delete($id){
        $player_registration = PlayerRegistration::find($id);


        // Ensure the options relation is deleted properly
        if ($player_registration->registered_options()->exists()) {
            $player_registration->registered_options()->delete();
        }

        
        $player_registration->delete();


        Alert::success('Success','Player Registration deleted successfully');
        return redirect()->route('player_registration.index');

    }

    public function search_tournament($id){

        
        $this->tournament_id = $id; // Default to empty string if not set
        if(!empty($this->tournament_id)){
            $this->selected_tournament = Tournament::findOrFail($this->tournament_id); 
        }


        // dd($this->selected_tournament);

        // $data = [];
        // $data['tournament_id'] = $id;
        // $data['tournament_event_id'] = null;
        
        // return redirect()->route('player_registration.index',$data);
    }

    public function search_tournament_event($id){

        $this->tournament_event_id = $id; // Default to empty string if not set
        if(!empty($this->tournament_event_id)){
            $this->selected_tournament_event = TournamentEvent::findOrFail($this->tournament_event_id); 
        }
 
        
        $this->selected_tournament = $this->selected_tournament_event->tournament; 
        $this->tournament_id = $this->selected_tournament_event->tournament->id;

        // $data = [];
        // $data['tournament_id'] = $tournament_event->tournament_id;
        // $data['tournament_event_id'] = $tournament_event->id;
        
        // return redirect()->route('player_registration.index',$data);
    }

    public function search_tournament_event_category($id){

        $this->tournament_event_category_id = $id; // Default to empty string if not set
        if(!empty($this->tournament_event_category_id)){
            $this->selected_tournament_event_category = TournamentEventCategory::findOrFail($this->tournament_event_category_id); 
        }

        $this->selected_tournament_event = $this->selected_tournament_event_category->tournament_event; 
        $this->tournament_event_id = $this->selected_tournament_event_category->tournament_event->id;

        $this->selected_tournament = $this->selected_tournament_event_category->tournament_event->tournament;
        $this->tournament_id = $this->selected_tournament_event_category->tournament_event->tournament->id;
 

    }

    public function search_tournament_event_category_option($id){
        $this->tournament_event_category_option_id = $id; // Default to empty string if not set
        if(!empty($this->tournament_event_category_option_id)){
            $this->selected_tournament_event_category_option = TournamentEventCategoryOptions::findOrFail($this->tournament_event_category_option_id); 
        }

        $this->selected_tournament_event_category = $this->selected_tournament_event_category_option->tournament_event_category; 
        $this->tournament_event_category_id = $this->selected_tournament_event_category_option->tournament_event_category->id; 


        $this->selected_tournament_event =  $this->selected_tournament_event_category->tournament_event; 
        $this->tournament_event_id =  $this->selected_tournament_event_category->tournament_event->id; 

        $this->selected_tournament =  $this->selected_tournament_event->tournament;
        $this->tournament_id =  $this->selected_tournament_event->tournament->id;
 

    }


    //search and filter user
    public function search_user($id){
        $this->user_id = $id; // Default to empty string if not set
        if(!empty($this->user_id)){ 
            $this->selected_user = User::findOrFail($this->user_id); 
        }
    }


     



    public function render()
    {


        $player_registrations = PlayerRegistration::select('player_registrations.*');


        if (!empty($this->search)) {
            $search = $this->search;
            // dd($this->search);
        
            $player_registrations = $player_registrations->where(function ($query) use ($search) {
        
                // // Search by creator
                // $query->orWhereHas('creator', function ($q) use ($search) {
                //     $q->where('users.name', 'LIKE', '%' . $search . '%')
                //       ->orWhere('users.email', 'LIKE', '%' . $search . '%');
                // });
        
                // Search by Tournament user
                $query->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%')
                      ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                      ->orWhere('home', 'LIKE', '%' . $search . '%');
                });
        
                // Search by Tournament name
                $query->orWhereHas('tournament', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
        

                // Check if tournament_event relation works
                $query = $query->orWhereHas('registered_options.tournament_event', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%'); // Replace with an existing value
                });

                // Check if tournament_event_category relation works
                $query = $query->orWhereHas('registered_options.tournament_event_category', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%'); // Replace with an existing value
                });

                // Check if tournament_event_category_option relation works
                $query = $query->orWhereHas('registered_options.tournament_event_category_option', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%'); // Replace with an existing value
                });



            });
        }
        

 
        if (!empty($this->sort_by_gender)) { 
            $player_registrations = $player_registrations->whereHas('user', function ($query) {
                $query->where('gender', $this->sort_by_gender);
            });
        } 

        if(!empty($this->sort_by_payment_status)){
            $player_registrations = $player_registrations->where('payment_status',$this->sort_by_payment_status);
        }

        if(!empty($this->sort_by_registration_status)){
            $player_registrations = $player_registrations->where('registration_status',$this->sort_by_registration_status);
        }

        if(!empty($this->sort_by_registration_status)){
            $player_registrations = $player_registrations->where('registration_status',$this->sort_by_registration_status);
        }



 
        if (!empty($this->tournament_id)) { 
            // $player_registrations = $player_registrations->whereHas('tournament_event', function ($query) {
            //     $query->where('tournament_id', $this->tournament_id);
            // });

            $player_registrations = $player_registrations->where('tournament_id',$this->tournament_id);
        } 


        if (!empty($this->tournament_event_id)) {
            $tournament_event_id = $this->tournament_event_id;
            // dd($this->search);
        
            $player_registrations = $player_registrations->where(function ($query) use ($tournament_event_id) {
                
                // Check if tournament_event relation works
                $query = $query->orWhereHas('registered_options.tournament_event', function ($query) use ($tournament_event_id) {
                    $query->where('id', $tournament_event_id); // Replace with an existing value
                });
  

            });
        }

        if (!empty($this->user_id)) {
            $user_id = $this->user_id;
            // dd($this->search);
        
            $player_registrations = $player_registrations->where( 'user_id',$user_id);
   
        }


        


        if (!empty($this->tournament_event_category_id)) {
            $tournament_event_category_id = $this->tournament_event_category_id;
            // dd($this->search);
        
            $player_registrations = $player_registrations->where(function ($query) use ($tournament_event_category_id) {
                
                // Check if tournament_event relation works
                $query = $query->orWhereHas('registered_options.tournament_event_category', function ($query) use ($tournament_event_category_id) {
                    $query->where('id', $tournament_event_category_id); // Replace with an existing value
                });
  

            });
        }




        // if (!empty($this->tournament_event_id)) { 
        //     $player_registrations = $player_registrations->where('tournament_event_id',$this->tournament_event_id); 
        // }

        /*
            // Find the role
            $role = Role::where('name', 'DSI God Admin')->first();

            if ($role) {
                // Get user IDs only if role exists
                $dsiGodAdminUserIds = $role->player_registrations()->pluck('id');
            } else {
                // Set empty array if role doesn't exist
                $dsiGodAdminUserIds = [];
            }


            // if(!Auth::user()->hasRole('DSI God Admin')){
            //     $player_registrations =  $player_registrations->where('player_registrations.created_by','=',Auth::user()->id);
            // }

            // Adjust the query
            if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->hasRole('Admin')) {
                $player_registrations = $player_registrations->where('player_registrations.created_by', '=', Auth::user()->id);
            }elseif(Auth::user()->hasRole('Admin')){
                $player_registrations = $player_registrations->whereNotIn('player_registrations.created_by', $dsiGodAdminUserIds);
            } else {

            }
        */

        // Find the role
        $role = Role::where('name', 'DSI God Admin')->first();

        if ($role) {
            // Get user IDs only if role exists
            $dsiGodAdminUserIds = $role->get()->pluck('id');
        } else {
            // Set empty array if role doesn't exist
            $dsiGodAdminUserIds = [];
        }

        
        // Adjust the query
        if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->hasRole('Admin')) {
            $player_registrations = $player_registrations->where('player_registrations.created_by', '=', Auth::user()->id);
        }elseif(Auth::user()->hasRole('Admin')){
            $player_registrations = $player_registrations->whereNotIn('player_registrations.created_by', $dsiGodAdminUserIds);
        } else {

        }

        // dd($this->sort_by);
        if(!empty($this->sort_by) && $this->sort_by != ""){
            // dd($this->sort_by);
            switch($this->sort_by){

                case "Name A - Z":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.name','ASC');
                    break;

                case "Name Z - A":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.name','DESC');
                    break;

               

                /**
                 * "Latest" corresponds to sorting by created_at in descending (DESC) order, so the most recent records come first.
                 * "Oldest" corresponds to sorting by created_at in ascending (ASC) order, so the earliest records come first.
                 */

                case "Latest Added":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.created_at','DESC');
                    break;

                case "Oldest Added":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.created_at','ASC');
                    break;

                case "Latest Updated":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.updated_at','DESC');
                    break;

                case "Oldest Updated":
                    $player_registrations =  $player_registrations->orderBy('player_registrations.updated_at','ASC');
                    break;
                default:
                    $player_registrations =  $player_registrations->orderBy('player_registrations.updated_at','DESC');
                    break;

            }


        }else{
            $player_registrations =  $player_registrations->orderBy('player_registrations.updated_at','DESC');

        }





        $player_registrations = $player_registrations->paginate($this->record_count);

        // Tournaments
            /**
             * @var tournament records
             */
            $results = Tournament::select('tournaments.*');
            if (!empty($this->tournament_search) && strlen($this->tournament_search) > 0) {
                $search = $this->tournament_search;
    

                $results = $results->where(function($query) use ($search) {
                    $query->where('tournaments.name', 'LIKE', '%' . $search . '%');
                        
                });
    
            }

            if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin')){
                // do nothing
            }else{
                $results = $results->where('tournaments.status', 'active');
                // dd("true");
            }


            $results =  $results->limit(10)->get();
        // ./ Tournaments


        // Tournament Events
            /**
             * @var TournamentEvent  records
             */
            $event_results = TournamentEvent::select('tournament_events.*');
            if (!empty($this->tournament_event_search) && strlen($this->tournament_event_search) > 0) {
                $search = $this->tournament_event_search;
    
                $event_results = $event_results->where(function($query) use ($search) {
                    $query->where('tournament_events.name', 'LIKE', '%' . $search . '%');
                        
                });
    
            }

            if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin')){
                // do nothing
            }else{
                $event_results = $event_results->whereHas('tournament', function ($query) {
                    $query->where('tournaments.status', 'active');
                });
            }


            if (!empty($this->tournament_id) ) {
                $event_results = $event_results->where('tournament_events.tournament_id',$this->tournament_id);
            }
            $event_results =  $event_results->limit(10)->get();
        // ./ Tournament Events


        // Tournament Event Categories
            /**
             * @var TournamentEventCategory  records
             */
            $event_category_results = TournamentEventCategory::select('tournament_event_categories.*');
            if (!empty($this->tournament_event_category_search) && strlen($this->tournament_event_category_search) > 0) {
                $search = $this->tournament_event_category_search;
    
                $event_category_results = $event_category_results->where(function($query) use ($search) {
                    $query->where('tournament_event_categories.name', 'LIKE', '%' . $search . '%');
                        
                });
    
            }

            if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin')) {
                // do nothing
            } else {
                $event_category_results = $event_category_results->whereHas('tournament_event.tournament', function ($query) {
                    $query->where('status', 'active'); // Assuming 'tournaments' is the table name, but the relationship handles that
                });
            }
            

            if (!empty($this->tournament_id) ) {
                $event_category_results = $event_category_results->whereHas('tournament_event.tournament', function ($query) {
                    $query->where('tournament_id', $this->tournament_id); // Assuming 'tournaments' is the table name, but the relationship handles that
                }); 
            }

            if (!empty($this->tournament_event_id) ) {
                $event_category_results = $event_category_results->where('tournament_event_id',$this->tournament_event_id);
            }

             
            $event_category_results =  $event_category_results->limit(10)->get();
        // ./ Tournament Event Categories

        // Tournament Event Category Options
            /**
             * @var TournamentEventCategoryOptions  records
             */
            $event_category_option_results = TournamentEventCategoryOptions::select('tournament_event_category_options.*');
            if (!empty($this->tournament_event_category_option_search) && strlen($this->tournament_event_category_option_search) > 0) {
                $search = $this->tournament_event_category_option_search;
    
                $event_category_option_results = $event_category_option_results->where(function($query) use ($search) {
                    $query->where('tournament_event_category_options.name', 'LIKE', '%' . $search . '%');
                        
                });
    
            }

            if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin')) {
                // do nothing
            } else {
                 

                $event_category_option_results = $event_category_option_results->with([
                    'tournament_event_category.tournament_event.tournament' => function ($query) {
                        $query->where('status', 'active');
                    }
                ]);

            }
            
            if (!empty($this->tournament_event_category_id) ) {
                $tournament_event_category_id = $this->tournament_event_category_id;
                $event_category_option_results = $event_category_option_results->where('tournament_event_category_id'   , $tournament_event_category_id);
                 
            }


            // if (!empty($this->tournament_event_category_id) ) {
            //     $tournament_event_category_id = $this->tournament_event_category_id;
 
            //     $event_category_results = $event_category_results->whereHas('tournament_event_category', function ($query) use ($tournament_event_category_id){
            //         $query->where('id', $tournament_event_category_id); // Assuming 'tournaments' is the table name, but the relationship handles that
            //     });  
            // }

            // if (!empty($this->tournament_event_id) ) {
            //     $tournament_event_id = $this->tournament_event_id;

            //     $event_category_option_results = $event_category_option_results->with([
            //         'tournament_event_category.tournament_event' => function ($query) use ($tournament_event_id ) {
            //             $query->where('id', $tournament_event_id );
            //         }
            //     ]);
            // }

            $event_category_option_results =  $event_category_option_results->limit(10)->get();
        // ./ Tournament Event Category Options


        // Player Users

            $players_users = User::whereHas('roles', function ($query) {
                $query->where('name', 'User');
            });

            if(!empty($this->user_search)){
                $search = $this->user_search;
                $players_users = $players_users->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%')
                      ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                      ->orWhere('home', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($this->sort_by_gender)) { 
                $players_users =  $players_users->where('gender', $this->sort_by_gender); 
            } 

            $players_users =  $players_users->limit(10)->get();

        // ./ Player Users


            

        
        return view('livewire.admin.registration.registration-index',[
            'player_registrations' => $player_registrations,
            'results' =>  $results,
            'event_results' => $event_results,
            'event_category_results' => $event_category_results,
            'event_category_option_results' => $event_category_option_results,
            'players_users' => $players_users
        ]);
    }


    // public function render()
    // {
    //     return view('livewire.admin.registration.registration-index');
    // }
}
