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
        DB::statement('ALTER TABLE `stories` MODIFY `description` TEXT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('UPDATE `stories` SET `description` = "" WHERE `description` IS NULL');
        DB::statement('ALTER TABLE `stories` MODIFY `description` TEXT NOT NULL');
    }
};
