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

        MigrationSqlFile::runSection('triggers/usr_visitor_details_triggers.sql', 'trg_after_visitor_insert:up');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('triggers/usr_visitor_details_triggers.sql', 'trg_after_visitor_insert:down');
    }
};