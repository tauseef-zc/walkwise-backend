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
        Schema::create('traveler_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('traveler_id');
            $table->foreign('traveler_id')->references('id')->on('travelers')->onDelete('cascade');
            $table->unsignedBigInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->text('customization')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_requests');
    }
};
