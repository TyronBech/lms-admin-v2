<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Narrow the gender enum to remove 'Prefer not to say'.
     *
     * Uses a raw ALTER TABLE statement to avoid requiring doctrine/dbal.
     *
     * Any existing rows with 'Prefer not to say' are remapped to 'Male' before
     * the ALTER so the column change does not fail due to invalid enum values.
     * This migration targets fresh/dev installs; if you have production data with
     * this value, run a custom data migration first to decide how to handle those
     * records before applying this migration.
     */
    public function up(): void
    {
        // Remap any existing 'Prefer not to say' rows to a valid value before narrowing.
        DB::statement("UPDATE usr_users SET gender = 'Male' WHERE gender = 'Prefer not to say'");

        DB::statement("ALTER TABLE usr_users MODIFY COLUMN gender ENUM('Male','Female') NOT NULL");
    }

    /**
     * Restore the original enum that includes 'Prefer not to say'.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE usr_users MODIFY COLUMN gender ENUM('Male','Female','Prefer not to say') NOT NULL");
    }
};
