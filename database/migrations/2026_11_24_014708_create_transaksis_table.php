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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->unique();
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->decimal('berat', 8, 2); // dalam kg, misal 2.5 kg
            $table->integer('total_harga');
            $table->enum('status_pengerjaan', ['Proses', 'Selesai'])->default('Proses');
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas'])->default('Lunas');
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // kasir pembuat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
