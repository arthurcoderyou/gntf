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
        Schema::create('tournament_event_categories', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->enum('status',['active','inactive'])->default('inactive'); 
            $table->enum('type',['singles','doubles','mixed'])->default('singles'); 
            $table->enum('allowed_gender',['male','female','both'])->default('both'); 
            $table->foreignId('tournament_event_id')->constrained('tournament_events')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tournament_event_categories');
    }
};
