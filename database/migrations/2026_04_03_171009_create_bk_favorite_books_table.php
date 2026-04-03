<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
if (! Schema::hasTable('bk_favorite_books')) {
        Schema::create('bk_favorite_books', function (Blueprint $table): void {
          $table->id();
          $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
          $table->foreignId('book_id')->constrained('bk_books')->cascadeOnDelete()->cascadeOnUpdate();
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

          $table->unique(['user_id', 'book_id'], 'unique_favorite');
        });
      }
  }

  public function down(): void
    {
Schema::dropIfExists('bk_favorite_books');
  }
};
