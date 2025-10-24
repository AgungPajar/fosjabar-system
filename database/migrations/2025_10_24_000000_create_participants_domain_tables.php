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
        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('generations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('participants_id')->nullable();
            $table->string('name');
            $table->string('singkatan');
            $table->date('started_at');
            $table->date('ended_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('generations_id')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->date('birthday')->nullable();
            $table->string('from_school')->nullable();
            $table->string('photo')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('datetime');
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('meeting_id');
            $table->uuid('participant_id');
            $table->string('status');
            $table->text('explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('participant_position', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('participant_id');
            $table->uuid('position_id');
            $table->timestamps();
        });

        Schema::create('participants_position_request', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('participants_id');
            $table->uuid('position_id');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::table('generations', function (Blueprint $table) {
            $table->foreign('participants_id')
                ->references('id')
                ->on('participants')
                ->nullOnDelete();
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->foreign('generations_id')
                ->references('id')
                ->on('generations')
                ->nullOnDelete();
        });

        Schema::table('participant_position', function (Blueprint $table) {
            $table->foreign('participant_id')
                ->references('id')
                ->on('participants')
                ->cascadeOnDelete();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->cascadeOnDelete();
            $table->unique(['participant_id', 'position_id']);
        });

        Schema::table('participants_position_request', function (Blueprint $table) {
            $table->foreign('participants_id')
                ->references('id')
                ->on('participants')
                ->cascadeOnDelete();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->cascadeOnDelete();
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('meeting_id')
                ->references('id')
                ->on('activities')
                ->cascadeOnDelete();
            $table->foreign('participant_id')
                ->references('id')
                ->on('participants')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['meeting_id']);
            $table->dropForeign(['participant_id']);
        });

        Schema::table('participants_position_request', function (Blueprint $table) {
            $table->dropForeign(['participants_id']);
            $table->dropForeign(['position_id']);
        });

        Schema::table('participant_position', function (Blueprint $table) {
            $table->dropForeign(['participant_id']);
            $table->dropForeign(['position_id']);
            $table->dropUnique(['participant_id', 'position_id']);
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['generations_id']);
        });

        Schema::table('generations', function (Blueprint $table) {
            $table->dropForeign(['participants_id']);
        });

        Schema::dropIfExists('participants_position_request');
        Schema::dropIfExists('participant_position');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('generations');
        Schema::dropIfExists('positions');
    }
};
