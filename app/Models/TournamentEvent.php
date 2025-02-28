<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TournamentEvent extends Model
{
     
    /**
     * 
     * $table->longText('name');
        $table->enum('status',['active','inactive'])->default('inactive');
        $table->date('start_date');
        $table->date('end_date');
        $table->date('registration_deadline'); 
        $table->foreignId('tournament_id')->constrained('tournaments')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
        $table->enum('junior_event',['yes','no'])->default('no');
     */


    protected $table = "tournament_events";
    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
        'registration_deadline',
        'tournament_id', 
        'created_by',
        'updated_by',
        'junior_event',
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
     * Get the tournament 
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function tournament()  # : BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id' );
    }


     /**
     * Get the categories associated with the tournament event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(TournamentEventCategory::class, 'tournament_event_id');
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



    public function getFormattedDateRange()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($start->format('F') === $end->format('F')) {
            // Same month: "March 25-26"
            return $start->format('F j') . '-' . $end->format('j');
        } else {
            // Different months: "March 25 - April 2"
            return $start->format('F j') . ' - ' . $end->format('F j');
        }
    }


    public function getDeadline(){
        $registration_deadline = Carbon::parse($this->registration_deadline);

        return $registration_deadline->format('F j');

    }

}
