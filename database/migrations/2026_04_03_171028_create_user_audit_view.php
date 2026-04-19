<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('DROP VIEW IF EXISTS user_audit_view');
            DB::statement('CREATE VIEW user_audit_view AS SELECT id, record_id AS user_id, source_table, field_changed, old_value, new_value, action_type AS change_type, changed_by, created_at, updated_at FROM audit_trail');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('DROP VIEW IF EXISTS user_audit_view');
        }
    }
};
