<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredOptions extends Model
{
    //
     // Schema::create('registered_options', function (Blueprint $table) {
        //     $table->id();
 
        //     $table->foreignId('player_registration_id')->constrained('player_registrations')->onUpdate('cascade')->onDelete('cascade');
            
        //     $table->foreignId('tournament_id')->constrained('tournaments')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignId('tournament_event_id')->constrained('tournament_events')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignId('tournament_event_category_id')->constrained('tournament_event_categories')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignId('tournament_event_category_option_id')->constrained('tournament_event_category_options')->onUpdate('cascade')->onDelete('cascade');
            
            
        //     $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');


        //     $table->timestamps();
        // });
    //  * 
    //  */


     protected $table = "registered_options";
     protected $fillable = [
         'player_registration_id',
         'tournament_id',
         'tournament_event_id',
         'tournament_event_category_id',
         'tournament_event_category_option_id', 
         'doubles_partner_user_id',
         'created_by',
         'updated_by',
     ];
 

     /**
      * Get the player registration
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
      public function player_registration()  # : BelongsTo
      {
          return $this->belongsTo(PlayerRegistration::class, 'player_registration_id' );
      }


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
      * Get the partner
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
      public function partner()  # : BelongsTo
      {
          return $this->belongsTo(User::class, 'doubles_partner_user_id' );
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

     /**
      * Get the tournament event
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
      public function tournament_event()  # : BelongsTo
      {
          return $this->belongsTo(TournamentEvent::class, 'tournament_event_id' );
      }

     /**
      * Get the tournament event category
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
      public function tournament_event_category()  # : BelongsTo
      {
          return $this->belongsTo(TournamentEventCategory::class, 'tournament_event_category_id' );
      }


      /**
      * Get the tournament event category
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
      public function tournament_event_category_option()  # : BelongsTo
      {
          return $this->belongsTo(TournamentEventCategoryOptions::class, 'tournament_event_category_option_id' );
      }


    static public function check_double_partner_request($user_id, $option_id)
    {
        return RegisteredOptions::select('registered_options.*') 
            ->where('doubles_partner_user_id', $user_id)
            ->where('tournament_event_category_option_id', $option_id)
            ->get();
    }


    public static function validateDoublesPartner($option_id, $partner_id)
    {
          // Get the selected option
          $option = TournamentEventCategoryOptions::find($option_id);
  
          if (!$option  ) {
            // dd($option );
              return "<span class='text-red-500'>Not a division</span>"; // Not a doubles event, no validation needed
 

          }
  

          // Ensure the option exists and belongs to a doubles category
          if (!$option || $option->tournament_event_category->type !== 'doubles') {
            // dd($option_id );
            return "<span class='text-red-500'>Not a doubles event</span>"; // Not a doubles event, no validation needed
 
          }
  
          // Ensure the partner_id is provided
          if (!$partner_id) {
              // $this->addError('selectedPartners.' . $option_id, 'You must select a partner for this doubles event.');
              // return false;
  
              return "<span class='text-red-500'>You must select a partner for this doubles event.</span>";
          }
  
          // Get current user registration for this option
          $userRegistration = PlayerRegistration::where('user_id', auth()->id())
              ->whereHas('registered_options', function ($query) use ($option_id) {
                  $query->where('tournament_event_category_option_id', $option_id);
              })
              ->first();
  
          // Get partner's registration for this option
          $partnerRegistration = PlayerRegistration::where('user_id', $partner_id)
              ->whereHas('registered_options', function ($query) use ($option_id) {
                  $query->where('tournament_event_category_option_id', $option_id);
              })
              ->first();
  
          // Check if both players are registered for the same event
          if (!$userRegistration || !$partnerRegistration) {
              // $this->addError('selectedPartners.' . $option_id, 'Both players must be registered for the same doubles event.');
              // return false;
  
              return "<span class='text-red-500'>Both players must be registered for the same doubles event.</span>";
  
          }

          // ✅ Check if the selected partner has already chosen another partner
        $existingPartnerPair = RegisteredOptions::where('player_registration_id', $partnerRegistration->id)
            ->where('tournament_event_category_option_id', $option_id)
            ->whereNot('doubles_partner_user_id', auth()->id()) // Not the current user
            ->first();

        if ($existingPartnerPair) {
            $existingPartnerId = $existingPartnerPair->doubles_partner_user_id;

            $reciprocalPair = RegisteredOptions::whereHas('player_registration', function ($query) use ($existingPartnerId) {
                    $query->where('user_id', $existingPartnerId);
                })
                ->where('tournament_event_category_option_id', $option_id)
                ->where('doubles_partner_user_id', $partner_id)
                ->exists();

            if ($reciprocalPair) {
                return "<span class='text-red-500'>This partner is already paired with another player who has also selected them.</span>";
            }
        }


  
          // Ensure both users have selected each other as partners
          $userSelectedPartner = RegisteredOptions::where('player_registration_id', $userRegistration->id)
              ->where('tournament_event_category_option_id', $option_id)
              ->where('doubles_partner_user_id', $partner_id)
              ->exists();
  
          $partnerSelectedUser = RegisteredOptions::where('player_registration_id', $partnerRegistration->id)
              ->where('tournament_event_category_option_id', $option_id)
              ->where('doubles_partner_user_id', auth()->id())
              ->exists();
  
          if (!$userSelectedPartner || !$partnerSelectedUser) {
              // $this->addError('selectedPartners.' . $option_id, 'Both players must select each other as partners.');
              // return false;
  
              return "<span class='text-red-500'>Both players must select each other as partners.</span>";
          }



            // // ✅ Check if the selected partner has already chosen another partner who also chose them
            // $partnerExistingPair = RegisteredOptions::where('player_registration_id', $partnerRegistration->id)
            //     ->where('tournament_event_category_option_id', $option_id)
            //     ->whereNot('doubles_partner_user_id', auth()->id()) // Different partner
            //     ->first();

            // if ($partnerExistingPair) {
            //     $existingPartnerId = $partnerExistingPair->doubles_partner_user_id;

            //     $reciprocalPair = RegisteredOptions::where('player_registration_id', function ($query) use ($existingPartnerId) {
            //         $query->select('id')->from('player_registrations')->where('user_id', $existingPartnerId);
            //     })
            //     ->where('tournament_event_category_option_id', $option_id)
            //     ->where('doubles_partner_user_id', $partner_id)
            //     ->exists();

            //     if ($reciprocalPair) {
            //         return "<span class='text-red-500'>This partner is already paired with another player who has also selected them.</span>";
            //     }
            // }


  
          return "<span class='text-lime-500'>Confirmed</span>";
    }
  


    





}
