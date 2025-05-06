<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('verifikasi_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_id'); // Pastikan tipe sama dengan id di tagihan
            $table->unsignedBigInteger('admin_id'); // Pastikan tipe sama dengan id di admin
            $table->enum('status', ['Terverifikasi', 'Ditolak', 'Menunggu Verifikasi'])->default('Menunggu Verifikasi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        
            // Foreign Keys
            $table->foreign('tagihan_id')->references('id')->on('tagihan')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi_pembayaran');
    }
};

