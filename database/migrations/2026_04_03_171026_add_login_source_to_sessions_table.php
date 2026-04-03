<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
if (Schema::hasTable('sessions') && ! Schema::hasColumn('sessions', 'login_source')) {
                Schema::table('sessions', function (Blueprint $table): void {
                    $table->enum('login_source', ['E-Lib', 'Admin', 'Circulation'])->nullable()->after('user_id');
                });
            }
    }

    public function down(): void
    {
if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'login_source')) {
                Schema::table('sessions', function (Blueprint $table): void {
                    $table->dropColumn('login_source');
                });
            }
    }
};
