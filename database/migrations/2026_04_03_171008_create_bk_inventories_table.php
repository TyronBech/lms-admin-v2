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
      if (! Schema::hasTable('bk_inventories')) {
        Schema::create('bk_inventories', function (Blueprint $table): void {
          $table->id();
          $table->foreignId('book_id')->nullable()->constrained('bk_books')->cascadeOnDelete()->cascadeOnUpdate();
          $table->boolean('is_scanned')->default(false);
          $table->timestamp('checked_at')->nullable();
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
          $table->timestamp('deleted_at')->nullable();

          $table->index('book_id', 'idx_inventories_book_id');
        });
      }
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      Schema::dropIfExists('bk_inventories');
    });
  }
};
