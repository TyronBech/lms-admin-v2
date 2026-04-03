<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
if (DB::getDriverName() !== 'mysql') {
        return;
      }

      if (! Schema::hasTable('model_has_roles') || ! Schema::hasTable('usr_users')) {
        return;
      }

      $constraintExists = DB::table('information_schema.KEY_COLUMN_USAGE')
        ->whereRaw('TABLE_SCHEMA = DATABASE()')
        ->where('TABLE_NAME', 'model_has_roles')
        ->where('CONSTRAINT_NAME', 'model_has_roles_mdoel_id_foreign')
        ->exists();

      if (! $constraintExists) {
        DB::statement('ALTER TABLE model_has_roles ADD CONSTRAINT model_has_roles_mdoel_id_foreign FOREIGN KEY (model_id) REFERENCES usr_users(id) ON DELETE CASCADE ON UPDATE CASCADE');
      }
  }

  public function down(): void
    {
if (DB::getDriverName() !== 'mysql' || ! Schema::hasTable('model_has_roles')) {
        return;
      }

      $constraintExists = DB::table('information_schema.KEY_COLUMN_USAGE')
        ->whereRaw('TABLE_SCHEMA = DATABASE()')
        ->where('TABLE_NAME', 'model_has_roles')
        ->where('CONSTRAINT_NAME', 'model_has_roles_mdoel_id_foreign')
        ->exists();

      if ($constraintExists) {
        DB::statement('ALTER TABLE model_has_roles DROP FOREIGN KEY model_has_roles_mdoel_id_foreign');
      }
  }
};
