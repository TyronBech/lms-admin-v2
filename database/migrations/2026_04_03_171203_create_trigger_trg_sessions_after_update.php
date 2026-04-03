<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  public function up(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() !== 'mysql') {
        return;
      }

      DB::unprepared('DROP TRIGGER IF EXISTS `trg_sessions_after_update`');
      DB::unprepared(<<<'SQL'
CREATE TRIGGER `trg_sessions_after_update`
AFTER UPDATE ON `sessions`
FOR EACH ROW
BEGIN
    IF OLD.user_id IS NULL AND NEW.user_id IS NOT NULL THEN
        INSERT INTO audit_trail (
            record_id, source_table, field_changed, old_value, new_value, action_type, changed_by
        )
        VALUES (
            NEW.user_id,
            'sessions',
            'login_source',
            NULL,
            NEW.login_source,
            'LOGIN',
            NEW.user_id
        );
    END IF;

    IF OLD.user_id IS NOT NULL AND NEW.user_id IS NULL THEN
        INSERT INTO audit_trail (
            record_id, source_table, field_changed, old_value, new_value, action_type, changed_by
        )
        VALUES (
            OLD.user_id,
            'sessions',
            'login_source',
            OLD.login_source,
            NULL,
            'LOGOUT',
            OLD.user_id
        );
    END IF;
END
SQL);
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() === 'mysql') {
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_sessions_after_update`');
      }
    });
  }
};
