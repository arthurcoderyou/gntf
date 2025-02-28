<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registered_options', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('player_registration_id')->constrained('player_registrations')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreignId('tournament_id')->constrained('tournaments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tournament_event_id')->constrained('tournament_events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tournament_event_category_id')->constrained('tournament_event_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tournament_event_category_option_id')->constrained('tournament_event_category_options')->onUpdate('cascade')->onDelete('cascade');
            
            
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registered_options');
    }
};
