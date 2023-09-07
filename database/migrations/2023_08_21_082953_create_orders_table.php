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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('member');
            $table->integer('product');
            $table->string('price');
            $table->enum('cycle', ['1', '2', '3', '4'])->comment('1. Bulanan, 2. 3 Bulan, 3. 6 Bulan, 4. Tahunan');
            $table->date('due');
            $table->enum('status', ['1', '2', '3'])->comment('1. Aktif, 2. Disable, 3. Ditangguhkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
