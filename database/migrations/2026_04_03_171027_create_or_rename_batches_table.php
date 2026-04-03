<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // job_batches is already created by the default Laravel jobs migration.
        // Laravel's queue batching config (config/queue.php) uses 'job_batches'.
        // No renaming needed.
    }

    public function down(): void
    {
        // Nothing to reverse.
    }
};
