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

      DB::unprepared('DROP TRIGGER IF EXISTS `trg_books_after_delete`');
      DB::unprepared(<<<'SQL'
CREATE TRIGGER `trg_books_after_delete`
AFTER UPDATE ON `bk_books`
FOR EACH ROW
BEGIN
    IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
        UPDATE bk_categories
        SET discarded = discarded + 1,
            present_inventory = present_inventory - 1
        WHERE id = NEW.category_id;
    ELSEIF OLD.deleted_at IS NOT NULL AND NEW.deleted_at IS NULL THEN
        UPDATE bk_categories
        SET discarded = discarded - 1,
            present_inventory = present_inventory + 1
        WHERE id = NEW.category_id;
    END IF;
END
SQL);
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      if (DB::getDriverName() === 'mysql') {
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_books_after_delete`');
      }
    });
  }
};
