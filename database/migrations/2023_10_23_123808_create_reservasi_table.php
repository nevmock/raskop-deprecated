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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->string('kode_reservasi')->unique();
            $table->unsignedBigInteger('id_room');
            $table->unsignedBigInteger('id_customer');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            // Menambahkan constraint foreign key ke tabel 'room'
            $table->foreign('id_room')->references('id_room')->on('room');

            // Menambahkan constraint foreign key ke tabel 'customers'
            $table->foreign('id_customer')->references('id_customer')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
