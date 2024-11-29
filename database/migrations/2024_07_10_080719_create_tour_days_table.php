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
        Schema::create('tour_days', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('itinerary')->nullable();
            $table->text('accommodation')->nullable();
            $table->json('location')->nullable();
            $table->string('meal_plan', 150)->nullable();
            $table->unsignedBigInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->unsignedInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_days');
    }
};
