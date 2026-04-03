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

      DB::unprepared('DROP EVENT IF EXISTS `monthly_archived_transactions`');
      DB::unprepared("CREATE EVENT `monthly_archived_transactions` ON SCHEDULE EVERY 1 MONTH STARTS '2025-05-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL archive_transactions()");
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() === 'mysql') {
        DB::unprepared('DROP EVENT IF EXISTS `monthly_archived_transactions`');
      }
    });
  }
};
