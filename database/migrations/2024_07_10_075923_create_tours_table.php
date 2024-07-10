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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 150);
            $table->text('overview')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->unsignedInteger('duration')->default(0);
            $table->string('start_point', 100)->nullable();
            $table->string('end_point', 100)->nullable();
            $table->unsignedInteger('max_packs')->default(0);
            $table->text('inclusions')->nullable();
            $table->text('exclusions')->nullable();
            $table->text('conditions')->nullable();
            $table->boolean('is_private')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('guide_id')->nullable();
            $table->foreign('guide_id')->references('id')->on('guides');
            $table->unsignedBigInteger('tour_category_id')->nullable();
            $table->foreign('tour_category_id')->references('id')->on('tour_categories');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
