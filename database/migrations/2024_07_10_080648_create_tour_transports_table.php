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
        Schema::create('tour_transports', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle', 100)->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->unsignedBigInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_transports');
    }
};
