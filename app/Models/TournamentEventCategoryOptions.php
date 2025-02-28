<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentEventCategoryOptions extends Model
{
    /**
     * Schema::create('tournament_event_category_options', function (Blueprint $table) {
     *       $table->id();
     *       $table->longText('name');
     *       $table->enum('status',['active','inactive'])->default('inactive');  
     *       $table->integer('tournament_event_category_id');
     *       $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
     *       $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
     *       $table->timestamps();
     *   });
     *  */


     protected $table = "tournament_event_category_options";
     protected $fillable = [
         'name',
         'status', 
         'tournament_event_category_id', 
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
      * Get the tournament event category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function tournament_event_category()  # : BelongsTo
     {
         return $this->belongsTo(TournamentEventCategory::class, 'tournament_event_category_id' );
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
