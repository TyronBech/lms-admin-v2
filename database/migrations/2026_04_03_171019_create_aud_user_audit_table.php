<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // aud_* tables use a legacy prefix. All audit logging is handled by
        // the audit_trail table via MySQL triggers. No new aud_* tables are created.
    }

    public function down(): void
    {
        // Nothing to reverse.
    }
};
