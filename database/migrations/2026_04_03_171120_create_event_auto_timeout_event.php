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

      DB::unprepared('DROP EVENT IF EXISTS `AutoTimeoutEvent`');
      DB::unprepared("CREATE EVENT `AutoTimeoutEvent` ON SCHEDULE EVERY 1 DAY STARTS '2025-06-09 17:52:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL AutoTimeoutUsers()");
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() === 'mysql') {
        DB::unprepared('DROP EVENT IF EXISTS `AutoTimeoutEvent`');
      }
    });
  }
};
