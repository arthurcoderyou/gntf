<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    //

    // $table->longText('name');
    //         $table->enum('status',['active','inactive'])->default('inactive');
    //         $table->date('start_date');
    //         $table->date('end_date');
    //         $table->longText('director');
    //         $table->longText('finance');
    //         $table->longText('logo');

    protected $table = "tournaments";
    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
        'director',
        'finance',
        'logo',
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
     * Get the events associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(TournamentEvent::class, 'tournament_id');
    }

    /**
     * Get the fee descriptions associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fee_descriptions()
    {
        return $this->hasMany(FeeDescription::class, 'tournament_id');
    }

    /**
     * Get the fee notes associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fee_notes()
    {
        return $this->hasMany(FeeNotes::class, 'tournament_id');
    }

    /**
     * Get the fee sub notes associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fee_sub_notes()
    {
        return $this->hasMany(FeeSubNotes::class, 'tournament_id');
    }

     /**
     * Get the format_descriptions associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function format_descriptions()
    {
        return $this->hasMany(FormatDescription::class, 'tournament_id');
    }

     /**
     * Get the rule_descriptions associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rule_descriptions()
    {
        return $this->hasMany(RuleDescription::class, 'tournament_id');
    }

     /**
     * Get the waiver_descriptions associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function waiver_descriptions()
    {
        return $this->hasMany(WaiverDescription::class, 'tournament_id');
    }

     /**
     * Get the tournament_fees associated with the tournament.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tournament_fees()
    {
        return $this->hasMany(TournamentFee::class, 'tournament_id');
    }


    

    /**
     * Get the user-friendly status badge
     *
     * @return string
     */
    public function getStatus(): string
    {
        return match ($this->status) {
            'active' => '<span class="inline-block text-sm text-white uppercase rounded-lg px-2 py-1 bg-gntf_green-500 dark:text-neutral-500">'
                        . $this->status . '</span>',
            'inactive' => '<span class="inline-block text-sm text-white uppercase rounded-lg px-2 py-1 bg-red-500 dark:text-neutral-500">'
                        . $this->status . '</span>',
            default => '<span class="inline-block text-sm text-white uppercase rounded-lg px-2 py-1 bg-gray-500 dark:text-neutral-500">'
                    . 'unknown' . '</span>',
        };
    }



    static public function getActiveTournament(){

        return Tournament::where('status','active')->first();
    }



     

    

    
}
