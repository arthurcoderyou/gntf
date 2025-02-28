<?php

namespace App\Livewire\Admin\Registration;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\User; 
use App\Models\Tournament;
use App\Models\ActivityLog;
use Livewire\WithFileUploads;
use App\Models\TournamentEvent;
use Illuminate\Validation\Rule;
use App\Models\RegisteredOptions;
use App\Models\PlayerRegistration;
use Illuminate\Support\Facades\Auth;
use App\Models\TournamentEventCategory;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TournamentEventCategoryOptions;
use App\Notifications\PartnerRequestAccepted;
use App\Notifications\PartnerRequestRejected;
use Illuminate\Support\Facades\Notification;

class RegistrationEdit extends Component
{

    use WithFileUploads;

    public $tournament; // active tournament

    public $category_options = [];
 
    public $user_search; 

    public $selected_option_id;
    public $selected_allowed_gender;



    public $selectedOptions = [];
    public $selectedPartners = [];
    public $selectedPartnerNames = [];
    public $tournamentId;
    public $user;

    /**
     * user info
     * @var 
     */
    public $name;
    public $email;
    public $phone_number;
    public $home;

    public $player_registration_id;



    public function mount($id){
         

        

         
        // $player_registration = PlayerRegistration::findOrFail($id);
        // Fetch the player's registration
        $player_registration = PlayerRegistration::findOrFail($id);
        $this->player_registration_id =  $player_registration->id;


        $this->tournament = $player_registration->tournament;

        $this->tournamentId = $this->tournament->id;
        $this->user = $player_registration->user;


        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->home = $this->user->home;




        // Populate selectedOptions as [tournament_event_category_option_id => true]
        $this->selectedOptions = $player_registration->registered_options
            ->pluck('tournament_event_category_option_id')
            ->mapWithKeys(fn($optionId) => [$optionId => true])
            ->toArray();

        // Populate selectedPartners as [tournament_event_category_option_id => doubles_partner_user_id]
        $this->selectedPartners = $player_registration->registered_options
            ->whereNotNull('doubles_partner_user_id')
            ->pluck('doubles_partner_user_id', 'tournament_event_category_option_id')
            ->toArray();


        $this->selectedPartnerNames = $player_registration->registered_options
            ->whereNotNull('doubles_partner_user_id')
            ->load('partner') // Eager load the partner relationship
            ->mapWithKeys(function ($option) {
                return [$option->tournament_event_category_option_id => $option->partner->name ?? 'Unknown'];
            })
            ->toArray();



        // dd($this->selectedPartnerNames);
            
    }


    public function updated($property, $value)
    {

        // dd($value);
        // Check if the update is related to selectedOptions
        if (str_starts_with($property, 'selectedOptions')) {
            // Extract the option ID from the property name (e.g., selectedOptions.65)
            $optionId = explode('.', $property)[1] ?? null;

            // If unchecked (null or empty), remove it from selectedOptions
            if (!$value) {
                unset($this->selectedOptions[$optionId]);
                unset($this->selectedPartners[$optionId]);
                unset($this->selectedPartnerNames[$optionId]);
 

            }
 
        }

 
        // // Debugging: Check current state of selectedOptions
        // dd($this->selectedOptions);
    }
        

    public function validateWeeklyRegistration() {
        $alreadyRegistered = PlayerRegistration::where('user_id', auth()->id())
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Check last 7 days
            ->exists();
    
        if ($alreadyRegistered) {
            $this->addError('weekly_registration', 'You have already registered this week. You can only register once per week.');
            return false;
        }
    
        return true;
    }
    

    public function update_selected_partner($user_id){
        // unset values first
        unset($this->selectedOptions[$this->selected_option_id ]); // Remove from selected partners
        unset($this->selectedPartners[$this->selected_option_id ]); // Remove from selected partners
        unset($this->selectedPartnerNames[$this->selected_option_id ]); // Remove from names array



        $user = User::findOrFail($user_id);

        // Append to existing selected partners instead of overriding
        $this->selectedOptions += [$this->selected_option_id => true];

        // Append to existing selected partners instead of overriding
        $this->selectedPartners += [$this->selected_option_id => $user->id];

        // Append the name as well
        $this->selectedPartnerNames += [$this->selected_option_id => $user->name];

 
    }

    public function remove_selected_partner($option_id)
    {
        // Append to existing selected partners instead of overriding
        // $this->selectedOptions += [$option_id => false];
        unset($this->selectedOptions[$option_id]); // Remove from selected partners
        unset($this->selectedPartners[$option_id]); // Remove from selected partners
        unset($this->selectedPartnerNames[$option_id]); // Remove from names array
    }


    public function register()
    {
         
        // dd($this->all());


        // $this->validateWeeklyRegistration();


        $this->validate([
            'selectedOptions' => 'required|array|min:1',
            'selectedPartners' => 'array',
            'phone_number' => 'required',
            'home' => 'required'
        ],[
            'selectedOptions.required' => 'Please select a category/categories to register'

        ]);


        // double registration validation
        // $alreadyRegistered = PlayerRegistration::where('user_id', auth()->id())
        //     ->where('created_at', '>=', Carbon::now()->subDays(7)) // Check last 7 days
        //     ->exists();
    
        // if ($alreadyRegistered) {
        //     $this->addError('weekly_registration', 'You have already registered this week. You can only register once per week.');
        //     return;
        // }




        // Fetch tournament event category_options
        $category_options = TournamentEventCategoryOptions::whereIn('id', array_keys($this->selectedOptions)) 
            ->get()
            ->keyBy('id');


            // dd($this->selectedOptions);

            
        $this->resetErrorBag(); 
        
        // Validate gender and doubles partner
        foreach ($this->selectedOptions as $category_option_Id => $option_status) {

            //
            // 
            //
            //
            if($option_status == true){
              
                $category_option = $category_options[$category_option_Id] ?? null;
            
                if (!$category_option) {
                    $this->addError('selectedOptions.'.$category_option_Id, 'Invalid category option selection.');
                    // return;
                    // continue; // Skip further checks for this option
                } 
                // else{
                //     $this->resetErrorBag(); 
                // }
            
                // Gender restriction check
                if (
                    ($category_option->tournament_event_category->allowed_gender === 'male' && $this->user->gender !== 'male') ||
                    ($category_option->tournament_event_category->allowed_gender === 'female' && $this->user->gender !== 'female')
                ) {
                    $this->addError('selectedOptions.'.$category_option_Id, "You cannot register for {$category_option->name} at {$category_option->tournament_event_category->name} due to gender restrictions.");
                    // return;
                } 
                // else{
                //     $this->resetErrorBag(); 
                // }
            
                // Doubles partner check
                if ($category_option->tournament_event_category->type === 'doubles') {
                    if (empty($this->selectedPartners[$category_option_Id])) {
                        $this->addError('selectedOptions.'.$category_option_Id, "You must select a partner for {$category_option->name} at {$category_option->tournament_event_category->name}.");
                        // return;
                    }
                    // else{
                    //     $this->resetErrorBag(); 
                    // }
                    
                    // else {
                    //     $this->resetErrorBag('selectedOptions');
                            
                    // }
                }
            
                  
            }



        }
            
            // Check if errors exist and debug them
            if ($this->getErrorBag()->isNotEmpty()) {
                // dd($this->getErrorBag()->messages());
                return;
            }
            
            // Proceed with saving if no errors
            

        // dd($errors); 
        $this->resetErrorBag(); 

        // dd("All Good");

        // Create or get player registration record
        $playerRegistration = PlayerRegistration::findOrFail($this->player_registration_id);
        
         
        $playerRegistration->user_id = $this->user->id;
        $playerRegistration->payment_status = 'not_paid';
        $playerRegistration->total_payment = 0; // Set appropriately
        $playerRegistration->tournament_id = $this->tournamentId;
        $playerRegistration->updated_at = now();
        $playerRegistration->updated_by = Auth::user()->id;
        $playerRegistration->save();

        // delete the registered options first
        // Ensure the options relation is deleted properly
        if ($playerRegistration->registered_options()->exists()) {
            $playerRegistration->registered_options()->delete();
        }



        // Save selected options
        foreach ($this->selectedOptions as $category_option_Id => $option_status) {

            if($option_status == true){
                $category_option = $category_options[$category_option_Id] ?? null;

                RegisteredOptions::create([
                    'player_registration_id' => $playerRegistration->id,
                    'tournament_id' => $this->tournamentId,
                    'tournament_event_id' => $category_option->tournament_event_category->tournament_event->id,
                    'tournament_event_category_id' => $category_option->tournament_event_category->id,
                    'tournament_event_category_option_id' => $category_option->id,
                    'doubles_partner_user_id' => $this->selectedPartners[$category_option_Id] ?? null,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                // Add notifications here 
                // apply notifications here 
                // $selected_partner_id = $this->selectedPartners[$category_option_Id] ?? null;

                // if ($selected_partner_id) {
                //     // Find users who requested the current user as a partner
                //     $pendingRequests = RegisteredOptions::where('doubles_partner_user_id', Auth::user()->id)
                //         ->where('tournament_event_category_option_id', $category_option->id)
                //         ->get();

                //     foreach ($pendingRequests as $request) {
                //         $requestingUser = User::find($request->player_registration->user_id);

                //         if ($requestingUser) {
                //             if ($requestingUser->id == $selected_partner_id) {
                //                 // Send queued acceptance notification
                //                 $requestingUser->notify(new PartnerRequestAccepted(Auth::user(), $category_option, $request->player_registration));
                //             } else {
                //                 // Send queued rejection notification
                //                 $requestingUser->notify(new PartnerRequestRejected($category_option, $request->player_registration));
                //             }
                //         }
                //     }
                // }


            }
        }


        // update the user 
        $user = Auth::user();
        $user->phone_number = $this->phone_number;
        $user->home = $this->home;
        $user->save();

        // session()->flash('success', 'Registration successful!');
        // return redirect()->route('dashboard', $this->tournamentId);


        ActivityLog::create([
            'log_action' => "Registration successful! for \"".Auth::user()->name." on ".$this->tournament->name,
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success',"Registration successful! for \"".Auth::user()->name." on ".$this->tournament->name);

        

        return redirect()->route('player_registration.index' );

    }


     

    public function render()
    {

        /**
         * @var tournament records
         */
        $results = User::select('users.*');
        if (!empty($this->user_search) && strlen($this->user_search) > 0) {
            $search = $this->user_search;

           

            $results = $results->where(function($query) use ($search) {
                $query->where('users.name', 'LIKE', '%' . $search . '%')
                    ->where('users.email', 'LIKE', '%' . $search . '%')
                    ->where('users.guardian', 'LIKE', '%' . $search . '%')
                    ;
                     
            });


        }


        if(!empty($this->selected_allowed_gender) && $this->selected_allowed_gender != "both"){

            // dd($this->selected_allowed_gender);
            $results = $results->where('users.gender', $this->selected_allowed_gender);

        }
        $results =  $results->whereHas('roles', function ($query) {
                $query->where('name', 'User'); // Assuming the role name is "User"
            })
            ->whereNot('users.id', Auth::user()->id)
            ->limit(10)->get();

         


        return view('livewire.admin.registration.registration-edit',[
            'results' => $results,
             
        ]);
    }

    // public function render()
    // {
    //     return view('livewire.admin.registration.registration-edit');
    // }
}
