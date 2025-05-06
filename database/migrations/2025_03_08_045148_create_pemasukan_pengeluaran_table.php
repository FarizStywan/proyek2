<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pemasukan_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']);
            $table->text('deskripsi');
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemasukan_pengeluaran');
    }
};
