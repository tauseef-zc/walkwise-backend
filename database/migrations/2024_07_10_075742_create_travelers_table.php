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
        Schema::create('travelers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('avatar', 50)->nullable();
            $table->json('emergency_contact')->nullable();
            $table->json('accessibility')->nullable();
            $table->text('dietary_restrictions')->nullable();
            $table->json('interests')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('passport_image', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelers');
    }
};
