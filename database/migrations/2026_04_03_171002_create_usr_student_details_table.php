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
      if (! Schema::hasTable('usr_student_details')) {
        Schema::create('usr_student_details', function (Blueprint $table): void {
          $table->id();
          $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
          $table->string('id_number', 20);
          $table->string('level', 15);
          $table->string('section', 100);
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
          $table->dateTime('deleted_at')->nullable();

          $table->unique(['id_number', 'deleted_at'], 'uniq_student_details_id_number');
          $table->index('user_id', 'idx_student_details_user_id');
        });
      }
    });
  }

  public function down(): void
  {
    DB::transaction(function (): void {
      Schema::dropIfExists('usr_student_details');
    });
  }
};
