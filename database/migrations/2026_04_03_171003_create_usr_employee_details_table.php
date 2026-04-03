<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
if (! Schema::hasTable('usr_employee_details')) {
        Schema::create('usr_employee_details', function (Blueprint $table): void {
          $table->id();
          $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
          $table->string('employee_id', 50);
          $table->string('employee_role', 45)->nullable();
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
          $table->dateTime('deleted_at')->nullable();

          $table->string('active_employee_id', 50)->storedAs('CASE WHEN deleted_at IS NULL THEN employee_id ELSE NULL END');

          $table->unique('active_employee_id', 'uniq_employee_details_employee_id');
          $table->index('user_id', 'idx_employee_details_user_id');
        });
      }
  }

  public function down(): void
    {
Schema::dropIfExists('usr_employee_details');
  }
};
