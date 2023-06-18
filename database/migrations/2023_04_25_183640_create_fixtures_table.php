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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('fixture_id')->unique();
            $table->string('home');
            $table->string('home_logo');
            $table->string('away');
            $table->string('away_logo');
            $table->string('league');
            $table->string('league_logo');
            $table->string('date');
            $table->string('venue')->nullable();
            $table->json('fixture_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
