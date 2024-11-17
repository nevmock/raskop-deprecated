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
        Schema::table('reservasi', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->after('jam_selesai');
            $table->boolean('rejected')->default(false);
            $table->boolean('pending')->default(false);
            $table->boolean('success')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
           
            $table->dropColumn(['status', 'rejected', 'pending', 'success']);
           
        });
    }
};
