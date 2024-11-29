<?php

use App\Enums\TourStatusEnum;
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
            $table->json('location')->nullable();
            $table->text('overview')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->unsignedInteger('duration')->default(0);
            $table->json('start_point')->nullable();
            $table->json('end_point')->nullable();
            $table->unsignedInteger('max_packs')->default(0);
            $table->text('inclusions')->nullable();
            $table->text('exclusions')->nullable();
            $table->text('conditions')->nullable();
            $table->boolean('is_private')->default(false);
            $table->decimal('rating')->default(0);
            $table->enum('status', TourStatusEnum::values())->default(TourStatusEnum::PENDING->value);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('tour_category_id')->nullable();
            $table->foreign('tour_category_id')->references('id')->on('tour_categories');
            $table->boolean('featured')->default(false);
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
