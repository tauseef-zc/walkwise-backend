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
        Schema::create('tour_day_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_day_id');
            $table->foreign('tour_day_id')->references('id')->on('tour_days')->onDelete('cascade');
            $table->text('location')->nullable();
            $table->json('lat_long')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_day_locations');
    }
};