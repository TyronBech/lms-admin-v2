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
      if (! Schema::hasTable('aud_book_audit')) {
        Schema::create('aud_book_audit', function (Blueprint $table): void {
          $table->id();
          $table->unsignedBigInteger('book_id');
          $table->string('field_changed', 50);
          $table->text('old_value')->nullable();
          $table->text('new_value')->nullable();
          $table->enum('change_type', ['INSERT', 'UPDATE', 'DELETE']);
          $table->string('changed_by', 50);
          $table->timestamp('changed_date')->nullable()->useCurrent();
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
      }
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      Schema::dropIfExists('aud_book_audit');
    });
  }
};
