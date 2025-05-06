<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar', 10)->unique();
            $table->enum('fasilitas', ['AC', 'Non-AC'])->default('Non-AC'); // Hanya 2 pilihan
            $table->decimal('harga', 10, 2); // Harga berdasarkan fasilitas
            $table->enum('status', ['Kosong', 'Terisi'])->default('Kosong');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
};
