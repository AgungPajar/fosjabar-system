<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to alter the column to nullable (MySQL)
        DB::statement("ALTER TABLE `news` MODIFY `photo` varchar(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `news` MODIFY `photo` varchar(255) NOT NULL");
    }
};
