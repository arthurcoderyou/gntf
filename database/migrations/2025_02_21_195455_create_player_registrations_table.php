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
        Schema::create('player_registrations', function (Blueprint $table) {
            $table->id();

            $table->longText('user_id');
            $table->enum('payment_status',['paid','not_paid'])->default('not_paid');
            $table->unsignedBigInteger('total_payment')->default(0);
            $table->date('player_signed_at')->nullable();
            $table->date('player_guardian_signed_at')->nullable();
            
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
        Schema::dropIfExists('player_registrations');
    }
};
