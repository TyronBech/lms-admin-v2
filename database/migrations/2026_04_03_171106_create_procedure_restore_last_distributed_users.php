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

        MigrationSqlFile::runSection('procedures/RestoreLastDistributedUsers.sql', 'RestoreLastDistributedUsers:up');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        MigrationSqlFile::runSection('procedures/RestoreLastDistributedUsers.sql', 'RestoreLastDistributedUsers:down');
    }
};