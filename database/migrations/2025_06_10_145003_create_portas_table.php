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
        Schema::create('portas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('porta');
            $table->boolean('ativa');

            // $table->unsignedBigInteger('host_id');
            // $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portas');
    }
};
