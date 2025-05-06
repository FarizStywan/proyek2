<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penghasilan_bulanan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 10); // Format: "Januari", "Februari", dst.
            $table->integer('tahun');
            $table->decimal('total_pemasukan', 10, 2)->default(0);
            $table->decimal('total_pengeluaran', 10, 2)->default(0);
            $table->decimal('keuntungan_bersih', 10, 2)->storedAs('total_pemasukan - total_pengeluaran');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penghasilan_bulanan');
    }
};

