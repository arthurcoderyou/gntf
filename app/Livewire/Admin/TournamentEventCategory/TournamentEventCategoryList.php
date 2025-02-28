<?php

namespace App\Livewire\Admin\TournamentEventCategory;

use Livewire\Component;
use App\Models\Tournament;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use App\Models\TournamentEventCategory;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentEventCategoryList extends Component
{   

    use WithFileUploads;
    use WithPagination;

    public $search = '';
    public $sort_by = '';
    public $record_count = 10;

    public $selected_records = [];
    public $selectAll = false;

    public $count = 0;

    public $tournament_search;
    public $tournament_event_search;

    public $tournament_id;
    public $tournament_event_id;



    public $selected_tournament;
    public $selected_tournament_event;
    
    public $add_route_with_tournament_event_id;

    public function mount(){

        $this->tournament_id = request()->query('tournament_id', ''); // Default to empty string if not set
        if(!empty($this->tournament_id)){
            $this->selected_tournament = Tournament::findOrFail($this->tournament_id); 
        }


        $this->tournament_event_id = request()->query('tournament_event_id', ''); // Default to empty string if not set
        if(!empty($this->tournament_event_id)){
            $this->selected_tournament_event = TournamentEvent::findOrFail($this->tournament_event_id);
            $this->tournament_id = $this->selected_tournament_event->tournament_id;
            $this->selected_tournament = Tournament::findOrFail($this->selected_tournament_event->tournament_id); 


            $data = [];
            $data['tournament_id'] = $this->selected_tournament_event->tournament_id;
            $data['tournament_event_id'] = $this->selected_tournament_event->id;

            $this->add_route_with_tournament_event_id = route('tournament_event_category.create',$data);
        }



    }


    // Method to delete selected records
    public function deleteSelected()
    {
        $tournament_event_categories = TournamentEventCategory::whereIn('id', $this->selected_records)->get(); // Delete the selected records

        foreach($tournament_event_categories as $tournament_event_category){
             


            // Ensure the options relation is deleted properly
            if ($tournament_event_category->options()->exists()) {
                $tournament_event_category->options()->delete();
            }

            $tournament_event_category->delete();
        }
        


        $this->selected_records = []; // Clear selected records

        Alert::success('Success','Selected tournament event categories deleted successfully');
        return redirect()->route('tournament_event_category.index');
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
            $this->selected_records = TournamentEventCategory::pluck('id')->toArray(); // Select all records
        } else {
            $this->selected_records = []; // Deselect all
        }

        $this->count = count($this->selected_records);
    }

    public function delete($id){
        $tournament_event_category = TournamentEventCategory::find($id);


        // Ensure the options relation is deleted properly
        if ($tournament_event_category->options()->exists()) {
            $tournament_event_category->options()->delete();
        }

        
        $tournament_event_category->delete();


        Alert::success('Success','Tournament Event Category deleted successfully');
        return redirect()->route('tournament_event_category.index');

    }

    public function search_tournament($id){

        $data = [];
        $data['tournament_id'] = $id;
        $data['tournament_event_id'] = null;
        
        return redirect()->route('tournament_event_category.index',$data);
    }

    public function search_tournament_event($id){

        $tournament_event = TournamentEvent::findOrFail($id);

        $data = [];
        $data['tournament_id'] = $tournament_event->tournament_id;
        $data['tournament_event_id'] = $tournament_event->id;
        
        return redirect()->route('tournament_event_category.index',$data);
    }


    public function render()
    {


        $tournament_event_categories = TournamentEventCategory::select('tournament_event_categories.*');


        if (!empty($this->search)) {
            $search = $this->search;


            $tournament_event_categories = $tournament_event_categories->where(function($query) use ($search){
                $query =  $query->where('tournament_event_categories.name','LIKE','%'.$search.'%');
            });


        }

        if (!empty($this->tournament_id)) { 
            if (!empty($this->tournament_id)) { 
                $tournament_event_categories = $tournament_event_categories->whereHas('tournament_event', function ($query) {
                    $query->where('tournament_id', $this->tournament_id);
                });
            }
        }


        if (!empty($this->tournament_event_id)) { 
            $tournament_event_categories = $tournament_event_categories->where('tournament_event_id',$this->tournament_event_id); 
        }

        /*
            // Find the role
            $role = Role::where('name', 'DSI God Admin')->first();

            if ($role) {
                // Get user IDs only if role exists
                $dsiGodAdminUserIds = $role->tournament_event_categories()->pluck('id');
            } else {
                // Set empty array if role doesn't exist
                $dsiGodAdminUserIds = [];
            }


            // if(!Auth::user()->hasRole('DSI God Admin')){
            //     $tournament_event_categories =  $tournament_event_categories->where('tournament_event_categories.created_by','=',Auth::user()->id);
            // }

            // Adjust the query
            if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->hasRole('Admin')) {
                $tournament_event_categories = $tournament_event_categories->where('tournament_event_categories.created_by', '=', Auth::user()->id);
            }elseif(Auth::user()->hasRole('Admin')){
                $tournament_event_categories = $tournament_event_categories->whereNotIn('tournament_event_categories.created_by', $dsiGodAdminUserIds);
            } else {

            }
        */


        // dd($this->sort_by);
        if(!empty($this->sort_by) && $this->sort_by != ""){
            // dd($this->sort_by);
            switch($this->sort_by){

                case "Name A - Z":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.name','ASC');
                    break;

                case "Name Z - A":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.name','DESC');
                    break;

               

                /**
                 * "Latest" corresponds to sorting by created_at in descending (DESC) order, so the most recent records come first.
                 * "Oldest" corresponds to sorting by created_at in ascending (ASC) order, so the earliest records come first.
                 */

                case "Latest Added":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.created_at','DESC');
                    break;

                case "Oldest Added":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.created_at','ASC');
                    break;

                case "Latest Updated":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.updated_at','DESC');
                    break;

                case "Oldest Updated":
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.updated_at','ASC');
                    break;
                default:
                    $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.updated_at','DESC');
                    break;

            }


        }else{
            $tournament_event_categories =  $tournament_event_categories->orderBy('tournament_event_categories.updated_at','DESC');

        }





        $tournament_event_categories = $tournament_event_categories->paginate($this->record_count);


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

        
        return view('livewire.admin.tournament-event-category.tournament-event-category-list',[
            'tournament_event_categories' => $tournament_event_categories,
            'results' =>  $results,
            'event_results' => $event_results
        ]);
    }

    // public function render()
    // {
    //     return view('livewire.admin.tournament-event-category.tournament-event-category-list');
    // }
}
