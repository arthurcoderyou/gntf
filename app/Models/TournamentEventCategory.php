<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentEventCategory extends Model
{
    //
    /**
     * $table->longText('name');
      *        $table->enum('status',['active','inactive'])->default('inactive'); 
      *        $table->enum('type',['singles','doubles','mixed'])->default('singles'); 
      *        $table->enum('allowed_gender',['male','female','both','mixed'])->default('both'); 
      *        $table->foreignId('tournament_event_id')->constrained('tournament_events')->onUpdate('cascade')->onDelete('cascade');
       *  *       $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
       *       $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
     * 
     */

     protected $table = "tournament_event_categories";
     protected $fillable = [
         'name',
         'status', 
         'type',
         'allowed_gender',
         'tournament_event_id', 
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
     public function tournament_event()  # : BelongsTo
     {
         return $this->belongsTo(TournamentEvent::class, 'tournament_event_id' );
     }

     /**
     * Get the options associated with the tournament event category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(TournamentEventCategoryOptions::class, 'tournament_event_category_id');
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



}
