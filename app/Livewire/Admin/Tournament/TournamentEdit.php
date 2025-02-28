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
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentEdit extends Component
{

    use WithFileUploads;
    public $name;
    public $status;
    public $start_date;
    public $end_date;
    public $director;
    public $finance;
    public $logo;
    public $tournament_logo;
    
    public $daterange;

    public $tournament_id;

    // list of fee descriptions
    public $fee_descriptions = [];
    public $fee_notes = [];

    public $fee_sub_notes = [];
    public $format_descriptions = [];

    public $rule_descriptions = [];

    public $waiver_descriptions = [];

    public $fees = [];

    
    

    public function mount($id){
        $tournament = Tournament::findOrFail($id);
        $this->tournament_id = $tournament->id;

        $this->name = $tournament->name;
        $this->status = $tournament->status;
        $this->start_date = $tournament->start_date;
        $this->end_date = $tournament->end_date;
        $this->director = $tournament->director;
        $this->finance = $tournament->finance;
        $this->tournament_logo = $tournament->logo; 

        // Set default value for tournament_fees
        if (!empty($tournament->tournament_fees) && count($tournament->tournament_fees) > 0) {
            foreach ($tournament->tournament_fees as $fee) {
                $this->fees[] = [
                    'fee_name' => $fee->fee_name,
                    'fee_first_event_payment' => $fee->fee_first_event_payment,
                    'fee_additional_event_payment' => $fee->fee_additional_event_payment,
                ];
            }
        }

        // Add an empty value at the bottom
        $this->fees[] = [
            'fee_name' => '',
            'fee_first_event_payment' => '',
            'fee_additional_event_payment' => '',
        ];

        

        // set the default value for fee_descriptions
        if(!empty($tournament->fee_descriptions) && count($tournament->fee_descriptions) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->fee_descriptions as $fee_description){
                $this->fee_descriptions[] = $fee_description->fee_description;
            }

            
        }

        // add an empty value at the bottom 
        $this->fee_descriptions[] = '';


        // set the default value for fee_notes
        if(!empty($tournament->fee_notes) && count($tournament->fee_notes) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->fee_notes as $fee_note){
                $this->fee_notes[] = $fee_note->notes;
            }

            
        }

        // add an empty value at the bottom 
        $this->fee_notes[] = '';


        // set the default value for fee_sub_notes
        if(!empty($tournament->fee_sub_notes) && count($tournament->fee_sub_notes) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->fee_sub_notes as $fee_sub_note){
                $this->fee_sub_notes[] = $fee_sub_note->sub_notes;
            }

            
        }

        // add an empty value at the bottom 
        $this->fee_sub_notes[] = '';


         

        // set the default value for format_descriptions
        if(!empty($tournament->format_descriptions) && count($tournament->format_descriptions) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->format_descriptions as $format_description){
                $this->format_descriptions[] = $format_description->description;
            }

            
        }

        // add an empty value at the bottom 
        $this->format_descriptions[] = '';
 

        // set the default value for rule_descriptions
        if(!empty($tournament->rule_descriptions) && count($tournament->rule_descriptions) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->rule_descriptions as $rule_description){
                $this->rule_descriptions[] = $rule_description->description;
            }

            
        }

        // add an empty value at the bottom 
        $this->rule_descriptions[] = '';


        // set the default value for waiver_descriptions
        if(!empty($tournament->waiver_descriptions) && count($tournament->waiver_descriptions) > 0){
            // dd($this->reservation->additional_name);
            foreach($tournament->waiver_descriptions as $waiver_description){
                $this->waiver_descriptions[] = $waiver_description->description;
            }

            
        }

        // add an empty value at the bottom 
        $this->waiver_descriptions[] = '';

        
         

        // Check if both dates are available
        if (!empty($tournament->start_date) && !empty($tournament->end_date)) {
            $startDate = Carbon::parse($tournament->start_date)->format("'M d, Y");
            $endDate = Carbon::parse($tournament->end_date)->format("'M d, Y");
            $this->daterange = $startDate . ' to ' . $endDate;
        } elseif (!empty($tournament->start_date)) {
            // If only the start date is available
            $this->daterange = Carbon::parse($tournament->start_date)->format("'M d, Y");
        } 


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


    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string', 
                Rule::unique('tournaments', 'name')
                ->ignore($this->tournament_id)
                , // Ensure name is unique
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
                //     })->where('id', '!=',$this->tournament_id)
                //     ->exists();

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



    public function save(){

        // dd($this->all());
        $this->validate([
            'name' => [
                'required',
                'string', 
                Rule::unique('tournaments', 'name')
                ->ignore($this->tournament_id)
                , // Ensure name is unique
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
                //     })->where('id', '!=',$this->tournament_id)
                //     ->exists();

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
        $tournament = Tournament::findOrFail($this->tournament_id);
         
        $tournament->name = $this->name;
        $tournament->status = $this->status;
        $tournament->start_date =  $this->start_date;
        $tournament->end_date =  $this->end_date;
        $tournament->director =  $this->director;
        $tournament->finance = $this->finance;   
        $tournament->updated_by = Auth::user()->id;
        $tournament->updated_at = now();
        $tournament->save();


        // Ensure the tournament fees relation is deleted properly
        if ($tournament->tournament_fees()->exists()) {
            $tournament->tournament_fees()->delete();
        }

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



        // Ensure the fee_descriptions relation is deleted properly
        if ($tournament->fee_descriptions()->exists()) {
            $tournament->fee_descriptions()->delete();
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


        //delete fee_notes 
        if ($tournament->fee_notes()->exists()) {
            $tournament->fee_notes()->delete();
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

         //delete fee_notes 
         if ($tournament->fee_sub_notes()->exists()) {
            $tournament->fee_sub_notes()->delete();
        }
        

        //save the fee_sub_notes
        if(!empty($this->fee_sub_notes)){
            foreach($this->fee_sub_notes as $fee_note_key => $fee_sub_note_value){
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


        //delete format_descriptions 
        if ($tournament->format_descriptions()->exists()) {
            $tournament->format_descriptions()->delete();
        }
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

        //delete rule_descriptions 
        if ($tournament->rule_descriptions()->exists()) {
            $tournament->rule_descriptions()->delete();
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

        //delete waiver_descriptions 
        if ($tournament->waiver_descriptions()->exists()) {
            $tournament->waiver_descriptions()->delete();
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

            // Construct the full file path
            $filePath = "public/uploads/tournament/{$this->tournament_logo}";

            // Check if the file exists in storage and delete it
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }


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
        
 


        ActivityLog::create([
            'log_action' => "Tournament \"".$this->name."\" updated ",
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success','Tournament updated successfully');
        return redirect()->route('tournament.index');
    }


    public function render()
    {
        return view('livewire.admin.tournament.tournament-edit');
    }
}
