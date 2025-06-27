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

            $table->unsignedBigInteger('porta_id');
            $table->foreign('porta_id')->references('id')->on('portas')->onDelete('cascade');
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
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
