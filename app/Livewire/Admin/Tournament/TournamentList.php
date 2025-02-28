<?php

namespace App\Livewire\Admin\Tournament;

use Livewire\Component;
use App\Models\Tournament;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class TournamentList extends Component
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

    // Method to delete selected records
    public function deleteSelected()
    {
        $tournaments = Tournament::whereIn('id', $this->selected_records)->get(); // Delete the selected records

        foreach($tournaments as $tournament){
            // Construct the full file path
            $filePath = "public/uploads/tournament/{$tournament->logo}";

            // Check if the file exists in storage and delete it
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Ensure the tournament fees relation is deleted properly
            if ($tournament->tournament_fees()->exists()) {
                $tournament->tournament_fees()->delete();
            }

            // delete descriptions 
            if ($tournament->fee_descriptions()->exists()) {
                $tournament->fee_descriptions()->delete();
            }

            //delete fee_notes 
            if ($tournament->fee_notes()->exists()) {
                $tournament->fee_notes()->delete();
            }

            //delete fee_notes 
            if ($tournament->fee_sub_notes()->exists()) {
                $tournament->fee_sub_notes()->delete();
            } 
            // format_descriptions rule_descriptions waiver_descriptions

            //delete format_descriptions 
            if ($tournament->format_descriptions()->exists()) {
                $tournament->format_descriptions()->delete();
            } 

            //delete rule_descriptions 
            if ($tournament->rule_descriptions()->exists()) {
                $tournament->rule_descriptions()->delete();
            } 

            //delete waiver_descriptions 
            if ($tournament->waiver_descriptions()->exists()) {
                $tournament->waiver_descriptions()->delete();
            } 


            $tournament->delete();
        }
        


        $this->selected_records = []; // Clear selected records

        Alert::success('Success','Selected tournaments deleted successfully');
        return redirect()->route('tournament.index');
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
            $this->selected_records = Tournament::pluck('id')->toArray(); // Select all records
        } else {
            $this->selected_records = []; // Deselect all
        }

        $this->count = count($this->selected_records);
    }

    public function delete($id){
        $tournament = Tournament::find($id);

        // Construct the full file path
        $filePath = "public/uploads/tournament/{$tournament->logo}";

        // Check if the file exists in storage and delete it
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Ensure the tournament fees relation is deleted properly
        if ($tournament->tournament_fees()->exists()) {
            $tournament->tournament_fees()->delete();
        }

        // delete descriptions 
        if ($tournament->fee_descriptions()->exists()) {
            $tournament->fee_descriptions()->delete();
        }

        //delete fee_notes 
        if ($tournament->fee_notes()->exists()) {
            $tournament->fee_notes()->delete();
        }

        //delete fee_notes 
        if ($tournament->fee_sub_notes()->exists()) {
            $tournament->fee_sub_notes()->delete();
        }

        //delete format_descriptions 
        if ($tournament->format_descriptions()->exists()) {
            $tournament->format_descriptions()->delete();
        } 

        //delete rule_descriptions 
        if ($tournament->rule_descriptions()->exists()) {
            $tournament->rule_descriptions()->delete();
        } 

        //delete waiver_descriptions 
        if ($tournament->waiver_descriptions()->exists()) {
            $tournament->waiver_descriptions()->delete();
        } 


        $tournament->delete();


        Alert::success('Success','Tournament deleted successfully');
        return redirect()->route('tournament.index');

    }




    public function render()
    {


        $tournaments = Tournament::select('tournaments.*');


        if (!empty($this->search)) {
            $search = $this->search;


            $tournaments = $tournaments->where(function($query) use ($search){
                $query =  $query->where('tournaments.name','LIKE','%'.$search.'%');
            });


        }

        /*
            // Find the role
            $role = Role::where('name', 'DSI God Admin')->first();

            if ($role) {
                // Get user IDs only if role exists
                $dsiGodAdminUserIds = $role->tournaments()->pluck('id');
            } else {
                // Set empty array if role doesn't exist
                $dsiGodAdminUserIds = [];
            }


            // if(!Auth::user()->hasRole('DSI God Admin')){
            //     $tournaments =  $tournaments->where('tournaments.created_by','=',Auth::user()->id);
            // }

            // Adjust the query
            if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->hasRole('Admin')) {
                $tournaments = $tournaments->where('tournaments.created_by', '=', Auth::user()->id);
            }elseif(Auth::user()->hasRole('Admin')){
                $tournaments = $tournaments->whereNotIn('tournaments.created_by', $dsiGodAdminUserIds);
            } else {

            }
        */


        // dd($this->sort_by);
        if(!empty($this->sort_by) && $this->sort_by != ""){
            // dd($this->sort_by);
            switch($this->sort_by){

                case "Name A - Z":
                    $tournaments =  $tournaments->orderBy('tournaments.name','ASC');
                    break;

                case "Name Z - A":
                    $tournaments =  $tournaments->orderBy('tournaments.name','DESC');
                    break;
 

                /**
                 * "Latest" corresponds to sorting by created_at in descending (DESC) order, so the most recent records come first.
                 * "Oldest" corresponds to sorting by created_at in ascending (ASC) order, so the earliest records come first.
                 */

                case "Latest Added":
                    $tournaments =  $tournaments->orderBy('tournaments.created_at','DESC');
                    break;

                case "Oldest Added":
                    $tournaments =  $tournaments->orderBy('tournaments.created_at','ASC');
                    break;

                case "Latest Updated":
                    $tournaments =  $tournaments->orderBy('tournaments.updated_at','DESC');
                    break;

                case "Oldest Updated":
                    $tournaments =  $tournaments->orderBy('tournaments.updated_at','ASC');
                    break;
                default:
                    $tournaments =  $tournaments->orderBy('tournaments.updated_at','DESC');
                    break;

            }


        }else{
            $tournaments =  $tournaments->orderBy('tournaments.updated_at','DESC');

        }





        $tournaments = $tournaments->paginate($this->record_count);

        
        return view('livewire.admin.tournament.tournament-list',[
            'tournaments' => $tournaments
        ]);
    }


    // public function render()
    // {
    //     return view('livewire.admin.tournament.tournament-list');
    // }
}
