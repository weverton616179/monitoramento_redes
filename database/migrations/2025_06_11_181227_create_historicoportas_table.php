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
        Schema::create('historicoportas', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');

            $table->unsignedBigInteger('historico_id');
            $table->foreign('historico_id')->references('id')->on('historicos')->onDelete('cascade');

            $table->unsignedBigInteger('porta_id');
            $table->foreign('porta_id')->references('id')->on('portas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicoportas');
    }
};
