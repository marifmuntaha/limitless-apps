<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->integer('category')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->date('installation');
            $table->string('note')->nullable();
            $table->string('pppoe_user')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->enum('status', ['1', '2'])->comment('1. Aktif, 2. Non Aktif');
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
