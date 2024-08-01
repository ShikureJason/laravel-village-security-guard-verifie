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
        Schema::create('verfie_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_log_id');
            $table->foreign('vehicle_log_id')->references('id')->on('vehicle_logs');
            $table->unsignedBigInteger('user_id')->nullable($value = true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('token');
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verfie_tokens');
    }
};