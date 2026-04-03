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

      DB::unprepared('DROP EVENT IF EXISTS `monthly_archive_user_logs`');
      DB::unprepared("CREATE EVENT `monthly_archive_user_logs` ON SCHEDULE EVERY 1 MONTH STARTS '2025-03-19 22:05:05' ON COMPLETION NOT PRESERVE ENABLE DO CALL Archive_user_logs()");
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() === 'mysql') {
        DB::unprepared('DROP EVENT IF EXISTS `monthly_archive_user_logs`');
      }
    });
  }
};
