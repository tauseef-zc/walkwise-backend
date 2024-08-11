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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->json('expertise')->nullable();
            $table->unsignedInteger('experience')->nullable();
            $table->string('avatar', 50)->nullable();
            $table->string('document', 50)->nullable();
            $table->text('languages')->nullable();
            $table->boolean('has_vehicle')->default(false);
            $table->float('rating')->default(0);
            $table->dateTime('verified_at')->nullable();
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
        Schema::dropIfExists('guides');
    }
};
