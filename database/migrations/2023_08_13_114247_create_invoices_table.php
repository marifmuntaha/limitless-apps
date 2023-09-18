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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->integer('member');
            $table->integer('product')->nullable();
            $table->string('desc');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('fees')->nullable();
            $table->integer('amount');
            $table->enum('status', ['1', '2', '3', '4'])->comment('1. Lunas, 2. Belum Lunas, 3. Batal, 4. Jatuh Tempo');
            $table->date('due');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
