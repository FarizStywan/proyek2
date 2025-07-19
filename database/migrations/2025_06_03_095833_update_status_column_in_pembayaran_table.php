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
         DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status ENUM('pending', 'dibayar', 'capture', 'settlement', 'deny', 'cancel', 'expire') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status ENUM('pending', 'dibayar') DEFAULT 'pending'");
    }
};
