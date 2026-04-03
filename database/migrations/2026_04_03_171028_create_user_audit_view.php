<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  public function up(): void
    {
if (DB::getDriverName() === 'mysql') {
        DB::statement('DROP VIEW IF EXISTS user_audit_view');
        DB::statement('CREATE VIEW user_audit_view AS SELECT id, user_id, source_table, field_changed, old_value, new_value, change_type, changed_by, changed_date, created_at, updated_at FROM aud_user_audit');
      }
  }

  public function down(): void
    {
if (DB::getDriverName() === 'mysql') {
        DB::statement('DROP VIEW IF EXISTS user_audit_view');
      }
  }
};
