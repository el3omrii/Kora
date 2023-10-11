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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('source_link')->nullable();
            $table->string('excerpt');
            $table->text('content');
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->string("status")->default("published");
            $table->unsignedInteger("views")->default(0);
            $table->foreignId('source_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('sources');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
