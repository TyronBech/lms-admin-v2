<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Uses a raw ALTER TABLE statement to avoid requiring doctrine/dbal.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE bk_books MODIFY COLUMN remarks ENUM('On Shelf','Unreturned','Missing','Lost','Discarded','Lost And Paid For','Lost And Replaced') NOT NULL DEFAULT 'On Shelf'");
    }

    /**
     * Reverse the migrations.
     *
     * Remaps values introduced by up() to the closest legacy equivalent before
     * narrowing the enum, so rows that were set to the new values don't cause
     * a data-truncation error on rollback.
     */
    public function down(): void
    {
        // Remap values not present in the original enum back to a valid legacy value.
        DB::statement("UPDATE bk_books SET remarks = 'Lost And Paid For' WHERE remarks = 'Lost And Replaced'");
        DB::statement("UPDATE bk_books SET remarks = 'Missing' WHERE remarks = 'Unreturned'");

        DB::statement("ALTER TABLE bk_books MODIFY COLUMN remarks ENUM('On Shelf','Missing','Lost','Discarded','Lost And Paid For') NOT NULL DEFAULT 'On Shelf'");
    }
};
