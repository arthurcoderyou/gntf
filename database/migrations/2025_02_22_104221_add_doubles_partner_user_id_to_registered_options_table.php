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
        Schema::table('registered_options', function (Blueprint $table) {
            $table->integer('doubles_partner_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registered_options', function (Blueprint $table) {
            $table->dropColumn('doubles_partner_user_id');
        });
    }
};
