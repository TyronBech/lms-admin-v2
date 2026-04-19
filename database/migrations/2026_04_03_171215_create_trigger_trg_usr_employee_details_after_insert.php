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

        MigrationSqlFile::runSection('triggers/usr_employee_details_triggers.sql', 'trg_usr_employee_details_after_insert:up');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('triggers/usr_employee_details_triggers.sql', 'trg_usr_employee_details_after_insert:down');
    }
};
