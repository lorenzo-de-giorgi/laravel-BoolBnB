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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->string('title', 255);
            $table->unsignedSmallInteger('beds_num');
            $table->unsignedSmallInteger('rooms_num');
            $table->unsignedSmallInteger('bathrooms_num');
            $table->unsignedSmallInteger('square_meters');
            $table->string('address', 255);
            $table->decimal('latitude', 12,10);
            $table->decimal('longitude', 12,10);
            $table->string('image', 255);
            $table->boolean('visibility')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
