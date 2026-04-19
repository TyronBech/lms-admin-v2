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

        MigrationSqlFile::runSection('triggers/sessions_triggers.sql', 'trg_sessions_after_update:up');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('triggers/sessions_triggers.sql', 'trg_sessions_after_update:down');
    }
};
