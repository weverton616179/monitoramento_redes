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
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });

        Schema::create('user_host', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('host_porta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');

            $table->unsignedBigInteger('porta_id');
            $table->foreign('porta_id')->references('id')->on('portas')->onDelete('cascade');

            $table->integer('tempo');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('roles');
        Schema::dropIfExists('user_host');
        Schema::dropIfExists('host_porta');
    }
};
