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
        Schema::create('apartment_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            
            $table->unsignedBigInteger('sponsorship_id')->nullable();
            $table->foreign('sponsorship_id')->references('id')->on('sponsorships')->onDelete('cascade');
            
            $table->string('name', 255);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_sponsorships');
    }
};
