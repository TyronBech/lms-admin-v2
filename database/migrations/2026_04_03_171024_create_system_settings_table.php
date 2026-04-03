<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    DB::transaction(function (): void {
      if (! Schema::hasTable('system_settings')) {
        Schema::create('system_settings', function (Blueprint $table): void {
          $table->id();
          $table->string('key');
          $table->text('value')->nullable();
          $table->string('description')->nullable();
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();

          $table->unique('key', 'system_settings_key_unique');
        });
      }
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      Schema::dropIfExists('system_settings');
    });
  }
};
