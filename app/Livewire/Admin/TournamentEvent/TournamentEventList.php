<?php

namespace App\Livewire\Admin\TournamentEvent;

use Livewire\Component;
use App\Models\Tournament;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentEventList extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $search = '';
    public $sort_by = '';
    public $record_count = 10;

    public $selected_records = [];
    public $selectAll = false;

    public $count = 0;

    public $file;

    public $tournament_id;
    public $selected_tournament;
    
    public $add_route_with_tournament_id;

    public function mount(){

        $this->tournament_id = request()->query('tournament_id', ''); // Default to empty string if not set
        if(!empty($this->tournament_id)){
            $this->selected_tournament = Tournament::findOrFail($this->tournament_id);
            $this->add_route_with_tournament_id = route('tournament_event.create',['tournament_id' => $this->tournament_id]);
        }



    }


    // Method to delete selected records
    public function deleteSelected()
    {
        $tournament_events = TournamentEvent::whereIn('id', $this->selected_records)->get(); // Delete the selected records

        foreach($tournament_events as $tournament_event){
             

            $tournament_event->delete();
        }
        


        $this->selected_records = []; // Clear selected records

        Alert::success('Success','Selected tournament events deleted successfully');
        return redirect()->route('tournament_event.index');
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
            $this->selected_records = TournamentEvent::pluck('id')->toArray(); // Select all records
        } else {
            $this->selected_records = []; // Deselect all
        }

        $this->count = count($this->selected_records);
    }

    public function delete($id){
        $tournament_event = TournamentEvent::find($id);

        
        $tournament_event->delete();


        Alert::success('Success','Tournament Event deleted successfully');
        return redirect()->route('tournament_event.index');

    }

    public function search_tournament($id){
        return redirect()->route('tournament_event.index',['tournament_id' => $id]);
    }


    public function render()
    {


        $tournament_events = TournamentEvent::select('tournament_events.*');


        if (!empty($this->search)) {
            $search = $this->search;


            $tournament_events = $tournament_events->where(function($query) use ($search){
                $query =  $query->where('tournament_events.name','LIKE','%'.$search.'%');
            });


        }

        if (!empty($this->tournament_id)) { 
            $tournament_events = $tournament_events->where('tournament_id',$this->tournament_id); 
        }

        /*
            // Find the role
            $role = Role::where('name', 'DSI God Admin')->first();

            if ($role) {
                // Get user IDs only if role exists
                $dsiGodAdminUserIds = $role->tournament_events()->pluck('id');
            } else {
                // Set empty array if role doesn't exist
                $dsiGodAdminUserIds = [];
            }


            // if(!Auth::user()->hasRole('DSI God Admin')){
            //     $tournament_events =  $tournament_events->where('tournament_events.created_by','=',Auth::user()->id);
            // }

            // Adjust the query
            if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->hasRole('Admin')) {
                $tournament_events = $tournament_events->where('tournament_events.created_by', '=', Auth::user()->id);
            }elseif(Auth::user()->hasRole('Admin')){
                $tournament_events = $tournament_events->whereNotIn('tournament_events.created_by', $dsiGodAdminUserIds);
            } else {

            }
        */


        // dd($this->sort_by);
        if(!empty($this->sort_by) && $this->sort_by != ""){
            // dd($this->sort_by);
            switch($this->sort_by){

                case "Name A - Z":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.name','ASC');
                    break;

                case "Name Z - A":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.name','DESC');
                    break;

               

                /**
                 * "Latest" corresponds to sorting by created_at in descending (DESC) order, so the most recent records come first.
                 * "Oldest" corresponds to sorting by created_at in ascending (ASC) order, so the earliest records come first.
                 */

                case "Latest Added":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.created_at','DESC');
                    break;

                case "Oldest Added":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.created_at','ASC');
                    break;

                case "Latest Updated":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.updated_at','DESC');
                    break;

                case "Oldest Updated":
                    $tournament_events =  $tournament_events->orderBy('tournament_events.updated_at','ASC');
                    break;
                default:
                    $tournament_events =  $tournament_events->orderBy('tournament_events.updated_at','DESC');
                    break;

            }


        }else{
            $tournament_events =  $tournament_events->orderBy('tournament_events.updated_at','DESC');

        }





        $tournament_events = $tournament_events->paginate($this->record_count);



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

        
        return view('livewire.admin.tournament-event.tournament-event-list',[
            'tournament_events' => $tournament_events,
            'results' =>  $results
        ]);
    }



    // public function render()
    // {
    //     return view('livewire.admin.tournament-event.tournament-event-list');
    // }
}
