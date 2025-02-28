<?php

namespace App\Livewire\Admin\Registration;

use App\Models\RegisteredOptions;
use App\Models\User;
use App\Models\OtpCode;
use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\WithFileUploads;
use App\Models\PlayerRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Notification;
use App\Models\TournamentEventCategoryOptions;
use App\Mail\OTPForGuardianPlayerSignNotification;
use App\Notifications\OTPForPlayerSignNotification;


class RegistrationShow extends Component
{

    use WithFileUploads;

    public $tournament; // active tournament

    public $category_options = [];
 
    public $user_search; 

    public $selected_option_id;
    public $selected_allowed_gender;



     
    public $tournamentId;
    public $user;


    public $player_registration;
    public $player_registration_id;

    public $player_sign_otp_code; // enter player signing otp code

    public $player_guardian_sign_otp_code; // enter player guardian signing otp code


    public $existing_player_sign_otp; // existing player sign otp code

    public $existing_guardian_player_sign_otp; // existing player sign otp code for guardian


    public $guardian_required;

    public $payment_status;
    public $registration_status;
 
    public $tournamentFees = [];
    public $total_payment = 0;
    
    public $gntf_member = "no";

    public function mount($id){
        
        $player_registration = PlayerRegistration::findOrFail($id);
        $this->player_registration = $player_registration;
        $this->player_registration_id =  $player_registration->id;
        $this->guardian_required = $player_registration->getGuardianRequirementStatus();

        $this->tournament = $player_registration->tournament;

        $this->tournamentId = $this->tournament->id;
        $this->user = $player_registration->user;


        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->home = $this->user->home;


        $this->payment_status = $player_registration->payment_status;
        $this->registration_status = $player_registration->registration_status;
        $this->total_payment = $player_registration->total_payment;

        // // Initialize fees from tournament options
        // foreach ($player_registration->registered_options as $option) {
        //     $this->tournamentFees[$option->id] = 0; // Default to 0 or fetch existing value
        // }


        // Fetch all necessary fees from TournamentFee model
        $fees = $player_registration->tournament->tournament_fees
            ->whereIn('fee_name', ['GNTF Members', 'Non-GNTF Members', 'Junior Events'])
            ->keyBy('fee_name');

        // Initialize fees from tournament options
        foreach ($player_registration->registered_options as $index => $option) {
            $isJuniorEvent = $option->tournament_event->junior_event == 'yes';
            $isFirstEvent = $index === 0;

            // Determine fee type
            if ($isJuniorEvent) {
                $feeType = 'Junior Events';
            } else {
                $feeType = $this->gntf_member == 'yes' ? 'GNTF Members' : 'Non-GNTF Members';
            }

            // Assign the correct fee
            $fee = $fees[$feeType] ?? null;
            $this->tournamentFees[$option->id] = $fee
                ? ($isFirstEvent ? $fee->fee_first_event_payment : $fee->fee_additional_event_payment)
                : 0;
        }


        // Calculate total payment
        $this->total_payment = array_sum($this->tournamentFees);




        // get exisitng player_sign_otp
        // Check if there's an existing valid OTP for the same user and registration
        $this->existing_player_sign_otp = OtpCode::where('user_id', $this->user->id)
            ->where('player_registration_id', $player_registration->id)
            ->where('expires_at', '>', now()) // Ensure OTP is not expired
            ->where('used', false) // Ensure OTP is not used
            ->first();
     
        if(!empty($this->user->guardian_email)){
            $this->existing_guardian_player_sign_otp = OtpCode::where('user_id', $this->user->id)
                ->where('player_registration_id', $player_registration->id)
                ->where('expires_at', '>', now()) // Ensure OTP is not expired
                ->where('guardian_email', $this->user->guardian_email)
                ->where('used', false) // Ensure OTP is not used
                ->first();
        }
        
        




    
    }


    public function updated(){
        // Fetch all necessary fees from TournamentFee model
        $fees = $this->player_registration->tournament->tournament_fees
            ->whereIn('fee_name', ['GNTF Members', 'Non-GNTF Members', 'Junior Events'])
            ->keyBy('fee_name');

        // Initialize fees from tournament options
        foreach ($this->player_registration->registered_options as $index => $option) {
            $isJuniorEvent = $option->tournament_event->junior_event == 'yes';
            $isFirstEvent = $index === 0;

            // Determine fee type
            if ($isJuniorEvent) {
                $feeType = 'Junior Events';
            } else {
                $feeType = $this->gntf_member == 'yes' ? 'GNTF Members' : 'Non-GNTF Members';
            }

            // Assign the correct fee
            $fee = $fees[$feeType] ?? null;
            $this->tournamentFees[$option->id] = $fee
                ? ($isFirstEvent ? $fee->fee_first_event_payment : $fee->fee_additional_event_payment)
                : 0;
        }
    }
   

    public function updatedTournamentFees()
    {
        // Sum up the values
        $this->total_payment = array_sum($this->tournamentFees);
    }



    public function sendOTPCode(){
        $user = User::where('id',$this->user->id)->first();
        $player_registration = PlayerRegistration::where('id',$this->player_registration_id)->first();


        
        $otp_code = OtpCode::generateOtp($player_registration);

        Notification::send($user, new OTPForPlayerSignNotification($player_registration, $otp_code));

         


        ActivityLog::create([
            'log_action' => "OTP Code sent! for \"".$user->name." on ".$this->player_registration->tournament->name,
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success("OTP Code sent! for \"".$user->name." on ".$this->player_registration->tournament->name);
 

        return redirect()->route('player_registration.show',['player_registration' => $this->player_registration->id] );
        
    }



    public function sendOTPCodeForGuardian(){
        $user = User::where('id',$this->user->id)->first();
        $player_registration = PlayerRegistration::where('id',$this->player_registration_id)->first();

        $otp_code = OtpCode::generateOtp($player_registration, $user->guardian_email);

        // Notification::send($user, new OTPForPlayerSignNotification($player_registration, $otp_code));

         // Send OTP email to Guardian
        Mail::to($user->guardian_email)->send(new OTPForGuardianPlayerSignNotification($player_registration, $otp_code));


        ActivityLog::create([
            'log_action' => "Guardian OTP Code sent! for \"".$user->name." on ".$this->player_registration->tournament->name,
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success("Guardian OTP Code sent! for \"".$user->name." on ".$this->player_registration->tournament->name);
 

        return redirect()->route('player_registration.show',['player_registration' => $this->player_registration->id] );
        
    }

    // confirming user player sign
    public function confirm_player_sign(){

        $existing_player_sign_otp = OtpCode::where('user_id', $this->user->id)
            ->where('player_registration_id', $this->player_registration->id)
            ->where('expires_at', '>', now()) // Ensure OTP is not expired
            ->where('used', false) // Ensure OTP is not used
            ->first();


            // dd($this->existing_player_sign_otp ."  -- ". $existing_player_sign_otp);
     
        if(empty($existing_player_sign_otp)){

            $this->addError('player_sign_otp_code','Sorry, otp code expired. Please request a new one');
            return;
        }

        // if it does not match
        if($existing_player_sign_otp->otp_code !== $this->player_sign_otp_code){
            $this->addError('player_sign_otp_code','Sorry, wrong otp code. Please try again');
            return;

        }


        $player_registration = PlayerRegistration::findOrFail($this->player_registration->id);
        $player_registration->player_signed_at = now();
        $player_registration->registration_status = "signed";
        
        $player_registration->updated_at = now();
        $player_registration->save();


        ActivityLog::create([
            'log_action' => "Player signature confirmed! for \"".$this->user->name." on ".$this->player_registration->tournament->name,
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success( "Player signature confirmed! for \"".$this->user->name." on ".$this->player_registration->tournament->name,);
 

        return redirect()->route('player_registration.show',['player_registration' => $this->player_registration->id] );

    }


    // confirming player guardian sign
    public function confirm_player_guardian_sign(){

        $existing_player_sign_otp = OtpCode::where('user_id', $this->user->id)
            ->where('player_registration_id', $this->player_registration->id)
            ->where('expires_at', '>', now()) // Ensure OTP is not expired
            ->where('used', false) // Ensure OTP is not used
            ->where('guardian_email', $this->player_registration->user->guardian_email)
            ->first();


            // dd($this->existing_player_sign_otp ."  -- ". $existing_player_sign_otp);
     
        if(empty($existing_player_sign_otp)){

            $this->addError('player_guardian_sign_otp_code','Sorry, guardian otp code expired. Please request a new one');
            return;
        }

        // if it does not match
        if($existing_player_sign_otp->otp_code !== $this->player_guardian_sign_otp_code){
            $this->addError('player_guardian_sign_otp_code','Sorry, wrong guardian otp code. Please try again');
            return;

        }


        $player_registration = PlayerRegistration::findOrFail($this->player_registration->id);
        $player_registration->player_guardian_signed_at = now();
        $player_registration->registration_status = "guardian_signed";
        
        $player_registration->updated_at = now();
        $player_registration->save();


        ActivityLog::create([
            'log_action' => "Player guardian signature confirmed! for \"".$this->user->name." on ".$this->player_registration->tournament->name,
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success( "Player guardian signature confirmed! for \"".$this->user->name." on ".$this->player_registration->tournament->name,);
 

        return redirect()->route('player_registration.show',['player_registration' => $this->player_registration->id] );

    }


    public function save(){


        // Check if the user has the "DSI God Admin" role or "role update permission"
        if (!Auth::user()->hasRole('DSI God Admin') && !Auth::user()->can('registration status edit')) {
            Alert::error('Unauthorized', 'You do not have permission to update role permissions.');
            return redirect()->route('role.add_permissions',['role' => $this->role_id]);
        }


        // Check if the user has permission to edit registration
        if (!Auth::user()->hasRole(['Admin', 'DSI God Admin']) && !Auth::user()->can('registration edit')) {
            Alert::error('Error', 'You do not have permission to edit this registration.');
            return;
        }

       // dd($this->all());
       $this->validate([
         
            
            'payment_status' => [
                'required', 
                
            ],

            'registration_status' => [
                'required', 
                
            ],
            
            'total_payment' => [
                'required', 
                
            ],

        ] );


        // dd('save');

        $player_registration = PlayerRegistration::findOrFail( $this->player_registration_id);
        $player_registration->payment_status = $this->payment_status;
        $player_registration->registration_status = $this->registration_status;     
        $player_registration->total_payment = $this->total_payment;
        $player_registration->updated_at = now();
        $player_registration->save();

        ActivityLog::create([
            'log_action' => "Player registration of  \"".Auth::user()->name."\" updated ",
            'log_username' => Auth::user()->name,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success',"Player registration of  \"".Auth::user()->name."\" updated ");
        return redirect()->route('player_registration.index');


    }


    public function render()
    {
        return view('livewire.admin.registration.registration-show');
    }
}
