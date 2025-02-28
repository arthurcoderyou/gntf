<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentFee extends Model
{
    protected $table = 'tournament_fees';

    protected $fillable = [
        'fee_name',
        'fee_first_event_payment',
        'fee_additional_event_payment',
        'tournament_id',
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
     * Get the tournament 
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function tournament()  # : BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id' );
    }
}
