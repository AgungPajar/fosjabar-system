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
        Schema::create('news_tags_pivots', function (Blueprint $table) {
            $table->uuid('news_id');
            $table->foreign('news_id')->references('id')->on('news')->cascadeOnDelete();

            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

            $table->primary(['news_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tags_pivots');
    }
};
