<?php

use App\Support\MigrationSqlFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('triggers/bk_books_triggers.sql', 'trg_books_after_insert:up');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('triggers/bk_books_triggers.sql', 'trg_books_after_insert:down');
    }
};