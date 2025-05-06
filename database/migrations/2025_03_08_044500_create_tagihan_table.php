<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id(); // ID harus menggunakan id() agar sesuai dengan foreign key
            $table->unsignedBigInteger('penyewa_id');
            $table->decimal('jumlah', 10, 2);
            $table->decimal('sisa_tagihan', 10, 2)->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Lunas', 'Belum Lunas'])->default('Belum Lunas');
            $table->string('metode_pembayaran')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->date('jatuh_tempo');
            $table->timestamps();
        
            $table->foreign('penyewa_id')->references('id')->on('penyewa')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};
