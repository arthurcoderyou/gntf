<?php

namespace App\Livewire\Admin\Tournament;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\FeeNotes;
use App\Models\Tournament;
use App\Models\ActivityLog;
use App\Models\FeeSubNotes;
use App\Models\TournamentFee;
use Livewire\WithFileUploads;
use App\Models\FeeDescription;
use App\Models\RuleDescription;
use Illuminate\Validation\Rule;
use App\Models\FormatDescription;
use App\Models\WaiverDescription;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentCreate extends Component
{
    use WithFileUploads;
    public $name;
    public $status;
    public $start_date;
    public $end_date;
    public $director;
    public $finance;
    public $logo;

    public $daterange;
    
    // list of fee descriptions
    public $fee_descriptions = [''];

    public $fee_notes = [''];

    public $fee_sub_notes = [''];

    public $format_descriptions = [''];

    public $rule_descriptions = [''];

    public $waiver_descriptions = [''];
 
    public $fees = [['fee_name' => '', 'fee_first_event_payment' => '', 'fee_additional_event_payment' => '']];

    
    

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string', 
                Rule::unique('tournaments', 'name'), // Ensure name is unique
            ],
            
            'start_date' => [
                'required',
                'date',
                // function ($attribute, $value, $fail) {
                //     $conflictingTournaments = Tournament::where(function ($query) use ($value) {
                //         $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                //               ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                //               ->orWhere(function ($query) {
                //                   $query->where('start_date', '<=', $this->start_date)
                //                         ->where('end_date', '>=', $this->end_date);
                //               });
                //     })->exists();

                //     if ($conflictingTournaments) {
                //         $fail('The selected dates conflict with another tournament.');
                //     }
                // },
            ],
            'end_date' => 'required|date|after_or_equal:start_date',

            // 'director' => [
            //     'required',
            //     'string',  
            // ],

            // 'finance' => [
            //     'required',
            //     'string',  
            // ],

              

        ] );
 

 
    }

    // Method to add a new fee description option input
    public function addFee()
    {
        $this->fees[] = [['fee_name' => '', 'fee_first_event_payment' => '', 'fee_additional_event_payment' => '']];
    }

    // Method to add a new fee description option input
    public function addFeeDescription()
    {
        $this->fee_descriptions[] = ''; // Add a new empty phone input
    }

    // Method to add a new fee note option input
    public function addFeeNote()
    {
        $this->fee_notes[] = ''; // Add a new empty  input
    }

    // Method to add a new fee note option input
    public function addFeeSubNote()
    {
        $this->fee_sub_notes[] = ''; // Add a new empty  input
    }


    
    // Method to add a new fee note option input
    public function addFormat()
    {
        $this->format_descriptions[] = ''; // Add a new empty  input
    }


    // Method to add a new fee note option input
    public function addRule()
    {
        $this->rule_descriptions[] = ''; // Add a new empty  input
    }


    // Method to add a new fee note option input
    public function addWaiver()
    {
        $this->waiver_descriptions[] = ''; // Add a new empty  input
    }


    public function save(){

        // dd($this->all());
        $this->validate([
            'name' => [
                'required',
                'string', 
                Rule::unique('tournaments', 'name'), // Ensure name is unique
            ],
            
            'start_date' => [
                'required',
                'date',
                // function ($attribute, $value, $fail) {
                //     $conflictingTournaments = Tournament::where(function ($query) use ($value) {
                //         $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                //               ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                //               ->orWhere(function ($query) {
                //                   $query->where('start_date', '<=', $this->start_date)
                //                         ->where('end_date', '>=', $this->end_date);
                //               });
                //     })->exists();

                //     if ($conflictingTournaments) {
                //         $fail('The selected dates conflict with another tournament.');
                //     }
                // },
            ],
            'end_date' => 'required|date|after_or_equal:start_date',

            // 'director' => [
            //     'required',
            //     'string',  
            // ],

            // 'finance' => [
            //     'required',
            //     'string',  
            // ],
 
        ] );


        if ($this->status == "active") {
            // Temporarily disable timestamps and update all tournaments to inactive
            Tournament::withoutTimestamps(function () {
                Tournament::query()->update(['status' => 'inactive']);
            });
        }


        //save
        $tournament = Tournament::create([
            'name' => $this->name,
            'status' => $this->status,
            'start_date' =>  $this->start_date,
            'end_date' =>  $this->end_date,
            'director' =>  $this->director,
            'finance' => $this->finance,  
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        // Save the tournament fees
        if (!empty($this->fees)) {
            // Save Tournament Fees
            foreach ($this->fees as $feeData) {
                if(!empty($feeData['fee_name']) || !empty($feeData['fee_first_event_payment']) || !empty($feeData['fee_additional_event_payment'])){
                    TournamentFee::create([
                        'tournament_id' => $tournament->id,
                        'fee_name' => $feeData['fee_name'],
                        'fee_first_event_payment' => $feeData['fee_first_event_payment'],
                        'fee_additional_event_payment' => $feeData['fee_additional_event_payment'],
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                } 
            }
        }



        //save the fee_descriptions
        if(!empty($this->fee_descriptions)){
            foreach($this->fee_descriptions as $fee_description_key => $fee_description_value){
                if($fee_description_value){
                    $fee_description = new FeeDescription();
                    $fee_description->fee_description = $fee_description_value; 
                    $fee_description->tournament_id = $tournament->id;
                    $fee_description->created_by = Auth::user()->id;
                    $fee_description->updated_by = Auth::user()->id;

                    $fee_description->save();
                }


            }
        }

        //save the fee_notes
        if(!empty($this->fee_notes)){
            foreach($this->fee_notes as $fee_note_key => $fee_note_value){
                if($fee_note_value){
                    $fee_notes = new FeeNotes();
                    $fee_notes->notes = $fee_note_value; 
                    $fee_notes->tournament_id = $tournament->id;
                    $fee_notes->created_by = Auth::user()->id;
                    $fee_notes->updated_by = Auth::user()->id;

                    $fee_notes->save();
                }


            }
        }

        //save the fee_sub_notes
        if(!empty($this->fee_sub_notes)){
            foreach($this->fee_sub_notes as $fee_sub_note_key => $fee_sub_note_value){
                if($fee_sub_note_value){
                    $fee_sub_notes = new FeeSubNotes();
                    $fee_sub_notes->sub_notes = $fee_sub_note_value; 
                    $fee_sub_notes->tournament_id = $tournament->id;
                    $fee_sub_notes->created_by = Auth::user()->id;
                    $fee_sub_notes->updated_by = Auth::user()->id;

                    $fee_sub_notes->save();
                }


            }
        }

        // public $format_descriptions = [''];

        // public $rule_descriptions = [''];

        // public $waiver_descriptions = [''];

        //save the format_descriptions
        if(!empty($this->format_descriptions)){
            foreach($this->format_descriptions as $format_description_key => $format_description_value){
                if($format_description_value){
                    $format_description = new FormatDescription();
                    $format_description->description = $format_description_value; 
                    $format_description->tournament_id = $tournament->id;
                    $format_description->created_by = Auth::user()->id;
                    $format_description->updated_by = Auth::user()->id;

                    $format_description->save();
                } 
            }
        }

        //save the rule_descriptions
        if(!empty($this->rule_descriptions)){
            foreach($this->rule_descriptions as $rule_description_key => $rule_description_value){
                if($rule_description_value){
                    $rule_description = new RuleDescription();
                    $rule_description->description = $rule_description_value; 
                    $rule_description->tournament_id = $tournament->id;
                    $rule_description->created_by = Auth::user()->id;
                    $rule_description->updated_by = Auth::user()->id;

                    $rule_description->save();
                } 
            }
        }

        //save the waiver_descriptions
        if(!empty($this->waiver_descriptions)){
            foreach($this->waiver_descriptions as $waiver_description_key => $waiver_description_value){
                if($waiver_description_value){
                    $waiver_description = new WaiverDescription();
                    $waiver_description->description = $waiver_description_value; 
                    $waiver_description->tournament_id = $tournament->id;
                    $waiver_description->created_by = Auth::user()->id;
                    $waiver_description->updated_by = Auth::user()->id;

                    $waiver_description->save();
                } 
            }
        }


         



        if (!empty($this->logo) && isset($this->logo[0])) {
            $file = $this->logo[0]; // Access the first file in the array
        
            // Generate a unique file name
            $fileName = Carbon::now()->timestamp . '-' . $tournament->id . '-' . uniqid() . '.' . $file['extension'];
        
            // Move the file manually from temporary storage
            $sourcePath = $file['path'];
            $destinationPath = storage_path("app/public/uploads/tournament/{$fileName}");
        
            // Ensure the directory exists
            if (!file_exists(dirname($destinationPath))) {
                mkdir(dirname($destinationPath), 0777, true);
            }
        
            // Move the file to the destination
            if (file_exists($sourcePath)) {
                rename($sourcePath, $destinationPath);
            }
        
            // Save the file name to the database
            $tournament->logo = $fileName;
            $tournament->save();
        }
        

        // if (!empty($this->logo)) {

        //     $file = $this->logo;
        
        //     // Generate a unique file name
        //     $fileName = Carbon::now()->timestamp . '-' . $tournament->id . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        //     // Move the file manually from temporary storage
        //     $sourcePath = $file->getRealPath();
        //     $destinationPath = storage_path("app/public/uploads/tournament/{$fileName}");
        
        //     // Ensure the directory exists
        //     if (!file_exists(dirname($destinationPath))) {
        //         mkdir(dirname($destinationPath), 0777, true);
        //     }
        
        //     // Move the file to the destination
        //     if (file_exists($sourcePath)) {
        //         rename($sourcePath, $destinationPath);
        //     }
        
        //     // Save the file name in the tournament's logo field
        //     $tournament->logo = $fileName;
        //     $tournament->save();
        // }


         
        

 


        ActivityLog::create([
            'log_action' => "Tournament \"".$this->name."\" created ",
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success','Tournament created successfully');
        return redirect()->route('tournament.index');
    }


    public function render()
    {
        return view('livewire.admin.tournament.tournament-create');
    }
}
