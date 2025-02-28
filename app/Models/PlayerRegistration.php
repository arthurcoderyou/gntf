<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerRegistration extends Model
{


    /**
     * 
     * Schema::create('player_registrations', function (Blueprint $table) {
     *       $table->id();

      *      $table->longText('user_id');
       *     $table->enum('payment_status',['paid','not_paid'])->default('not_paid');
        *    $table->unsignedBigInteger('total_payment')->default(0);
         *   $table->date('player_signed_at')->nullable();
          *  $table->date('player_guardian_signed_at')->nullable();
           * $table->enum('registration_status', ['pending', 'otp_sent', 'signed', 'guardian_otp_sent', 'guardian_signed','complete'])->default('pending');
            *
           * $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            *$table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
           * $table->timestamps();
       * });
     * 
     * @var string
     */
    protected $table = "player_registrations";
    protected $fillable = [
        'user_id',
        'tournament_id',
        'payment_status',
        'registration_status',
        'total_payment',
        'player_signed_at',
        'player_guardian_signed_at', 
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user that created 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()  # : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by' );
    }

    /**
     * Get the user that updated 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updator()  # : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by' );
    }


    /**
     * Get the user that updated 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()  # : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id' );
    }

    /**
     * Get the tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()  # : BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id' );
    }
     

    public function registered_options() # : HasMany
    {
        return $this->hasMany(RegisteredOptions::class, 'player_registration_id');
    }

    public function getRegisteredTournaments() #: Collection
    {
        return $this->registered_options()
            ->with('tournament') // Ensure we load tournament details
            ->get()
            ->groupBy(fn ($option) => $option->tournament->id);
    }

    public function registered_doubles_options()
    {
        return $this->registered_options()
            ->whereHas('tournament_event_category', function ($query) {
                $query->where('type', 'doubles'); // Filter for doubles only
            });
    }


    static public function check_double_partner_request($requested_id, $option_id,$requester_id)
    {
        return PlayerRegistration::select('player_registrations.*') 
            ->whereHas('registered_options', function ($query) use ($requested_id, $option_id) {
                $query->where('doubles_partner_user_id', $requested_id)
                    ->where('tournament_event_category_option_id', $option_id);
 
            })
            ->where('user_id', $requester_id) // the player who is requesting
            ->exists();

        // return RegisteredOptions::select('registered_options.*') 
        //     ->where('doubles_partner_user_id', $user_id)
        //     ->where('tournament_event_category_option_id', $option_id)
        //     ->exists();
    }



    /**
     * Get the user-friendly status badge
     *
     * @return string
     */
    public function getPaymentStatus(): string
    {
        return match ($this->payment_status) {
            'paid' =>  'PAID',
            'not_paid' => 'NOT PAID',
            default => 'NONE',
        };
    }


    /**
     * Get the user-friendly status badge
     *
     * @return string
     */
    public function getRegistrationStatus(): string
    {
        return match ($this->registration_status) {
            'pending'  =>  'PENDING', 
            'otp_sent'  =>  'OTP SENT', 
            'signed'  =>  'SIGNED',
            'guardian_otp_sent'  =>  'GUARDIAN OTP SENT', 
            'guardian_signed'  =>  'GUARDIAN SIGNED',
            'complete'  =>  'COMPLETE',
            
            default =>  'PENDING',
        };
    }


    /**
     * Check if the registration requires a guardian based on junior event participation.
     *
     * @return bool
     */
    public function getGuardianRequirementStatus(): bool
    {
        return $this->registered_options()
            ->whereHas('tournament_event', function ($query) {
                $query->where('junior_event', 'yes');
            })
            ->exists();
    }



    /**
     * Check if the registration requires anything more
     *
     * @return bool
     */
    public function getFinalRequirementStatus(): bool
    {

        // check if there are junior events, because if there are junior events, 
        // player_guardian_signed_at is required
        // if not, player_signed_at is enough


        // check if the doubles partner had already made registration and if there registration 


        $junior_events_exists = $this->registered_options()
            ->whereHas('tournament_event', function ($query) {
                $query->where('junior_event', 'yes');
            })
            ->exists();








        return false;


    }
      


    public static function hasConfirmedPartner($option_id)
    {
        $user_id = auth()->id();

        // Get the user's player registration for the given option
        $userRegistration = PlayerRegistration::where('user_id', $user_id)
            ->whereHas('registered_options', function ($query) use ($option_id) {
                $query->where('tournament_event_category_option_id', $option_id);
            })
            ->first();

        if (!$userRegistration) {
            return false; // User is not registered in this option
        }

        // Get the partner that the user has selected
        $partnerRecord = RegisteredOptions::where('player_registration_id', $userRegistration->id)
            ->where('tournament_event_category_option_id', $option_id)
            ->whereNotNull('doubles_partner_user_id')
            ->first();

        if (!$partnerRecord) {
            return false; // No partner assigned
        }

        $partner_id = $partnerRecord->doubles_partner_user_id;

        // Check if the partner has also selected the user
        $partnerConfirmed = RegisteredOptions::whereHas('player_registration', function ($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })
            ->where('tournament_event_category_option_id', $option_id)
            ->where('doubles_partner_user_id', $user_id)
            ->exists();

        return $partnerConfirmed ? $partner_id : false; // Returns partner ID if confirmed, otherwise false
    }



    public static function userHasConfirmedPartner($user_id,$option_id)
    {
        $user = User::findOrFail($user_id);

        $user_id = $user->id;
        // Get the user's player registration for the given option
        $userRegistration = PlayerRegistration::where('user_id', $user_id)
            ->whereHas('registered_options', function ($query) use ($option_id) {
                $query->where('tournament_event_category_option_id', $option_id);
            })
            ->first();

        if (!$userRegistration) {
            return false; // User is not registered in this option
        }

        // Get the partner that the user has selected
        $partnerRecord = RegisteredOptions::where('player_registration_id', $userRegistration->id)
            ->where('tournament_event_category_option_id', $option_id)
            ->whereNotNull('doubles_partner_user_id')
            ->first();

        if (!$partnerRecord) {
            return false; // No partner assigned
        }

        $partner_id = $partnerRecord->doubles_partner_user_id;

        // Check if the partner has also selected the user
        $partnerConfirmed = RegisteredOptions::whereHas('player_registration', function ($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })
            ->where('tournament_event_category_option_id', $option_id)
            ->where('doubles_partner_user_id', $user_id)
            ->exists();

        return $partnerConfirmed ? $partner_id : false; // Returns partner ID if confirmed, otherwise false
    }



    public static function isConfirmedPartner($option_id, $partner_user_id)
    {
        $user_id = auth()->id();

        // Get the user's player registration for the given option
        $userRegistration = PlayerRegistration::where('user_id', $user_id)
            ->whereHas('registered_options', function ($query) use ($option_id) {
                $query->where('tournament_event_category_option_id', $option_id);
            })
            ->first();

        if (!$userRegistration) {
            return false; // User is not registered in this option
        }

        // Check if the user has selected the given partner
        $userSelectedPartner = RegisteredOptions::where('player_registration_id', $userRegistration->id)
            ->where('tournament_event_category_option_id', $option_id)
            ->where('doubles_partner_user_id', $partner_user_id)
            ->exists();

        // Check if the given partner has also selected the user
        $partnerSelectedUser = RegisteredOptions::whereHas('player_registration', function ($query) use ($partner_user_id) {
                $query->where('user_id', $partner_user_id);
            })
            ->where('tournament_event_category_option_id', $option_id)
            ->where('doubles_partner_user_id', $user_id)
            ->exists();

        return $userSelectedPartner && $partnerSelectedUser; // Returns true if both selected each other
    }





}
