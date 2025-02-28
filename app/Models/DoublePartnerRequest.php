<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoublePartnerRequest extends Model
{
    //public function up(): void
    // {
    //     Schema::create('double_partner_requests', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('requester_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->after('user_id');
    //         $table->foreignId('requested_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->after('user_id');
    //         $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
    //         $table->foreignId('option_id')->constrained('tournament_event_category_options')->onUpdate('cascade')->onDelete('cascade')->after('user_id'); 
    //         $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
    //         $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    // }


    protected $table = "double_partner_requests";
    protected $fillable = [
        'requester_user_id',
        'requested_user_id',
        'status',
        'option_id', 
        'created_at',
        'updated_at', 
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
    public function option()  # : BelongsTo
    {
        return $this->belongsTo(TournamentEventCategoryOptions::class, 'option_id' );
    }


    /**
     * Get the user that requester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()  # : BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_user_id' );
    }


    /**
     * Get the user that is being requested 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requested()  # : BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_user_id' );
    }


}
