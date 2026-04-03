<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
if (DB::getDriverName() !== 'mysql') {
                return;
            }

            $addForeignIfMissing = static function (
                string $table,
                string $column,
                string $constraintName,
                string $referencedTable,
                string $referencedColumn,
                string $onDelete,
                string $onUpdate
            ): void {
                if (! Schema::hasTable($table) || ! Schema::hasTable($referencedTable)) {
                    return;
                }

                $alreadyConstrained = DB::table('information_schema.KEY_COLUMN_USAGE')
                    ->whereRaw('TABLE_SCHEMA = DATABASE()')
                    ->where('TABLE_NAME', $table)
                    ->where('COLUMN_NAME', $column)
                    ->whereNotNull('REFERENCED_TABLE_NAME')
                    ->exists();

                if ($alreadyConstrained) {
                    return;
                }

                DB::statement(sprintf(
                    'ALTER TABLE `%s` ADD CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s` (`%s`) ON DELETE %s ON UPDATE %s',
                    $table,
                    $constraintName,
                    $column,
                    $referencedTable,
                    $referencedColumn,
                    $onDelete,
                    $onUpdate
                ));
            };

            $addForeignIfMissing('usr_users', 'privilege_id', 'users_ibfk_1', 'privileges', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('usr_student_details', 'user_id', 'usr_student_details_ibfk_1', 'usr_users', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('usr_employee_details', 'user_id', 'usr_employee_details_ibfk_1', 'usr_users', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('usr_visitor_details', 'user_id', 'usr_visitor_details_ibfk_1', 'usr_users', 'id', 'CASCADE', 'CASCADE');

            $addForeignIfMissing('bk_books', 'category_id', 'bk_books_ibfk_1', 'bk_categories', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('bk_inventories', 'book_id', 'bk_inventories_ibfk_1', 'bk_books', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('bk_favorite_books', 'book_id', 'fk_favorite_book', 'bk_books', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('bk_favorite_books', 'user_id', 'fk_favorite_user', 'usr_users', 'id', 'CASCADE', 'CASCADE');

            $addForeignIfMissing('tr_transactions', 'user_id', 'tr_transactions_ibfk_1', 'usr_users', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('tr_transactions', 'book_id', 'tr_transactions_ibfk_2', 'bk_books', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('tr_penalties', 'transaction_id', 'fk_transaction_id', 'tr_transactions', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('tr_penalties', 'penalty_rule_id', 'fk_penalty_rule_id', 'penalty_rules', 'id', 'CASCADE', 'CASCADE');

            $addForeignIfMissing('notifications', 'user_id', 'notifications_ibfk_user', 'usr_users', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('notifications', 'transaction_id', 'notifications_ibfk_transaction', 'tr_transactions', 'id', 'SET NULL', 'CASCADE');
            $addForeignIfMissing('log_user_logs', 'user_id', 'log_user_logs_ibfk_1', 'usr_users', 'id', 'CASCADE', 'CASCADE');

            $addForeignIfMissing('model_has_permissions', 'permission_id', 'model_has_permissions_permission_id_foreign', 'permissions', 'id', 'CASCADE', 'RESTRICT');
            $addForeignIfMissing('model_has_roles', 'role_id', 'model_has_roles_role_id_foreign', 'roles', 'id', 'CASCADE', 'RESTRICT');
            $addForeignIfMissing('model_has_roles', 'model_id', 'model_has_roles_mdoel_id_foreign', 'usr_users', 'id', 'CASCADE', 'CASCADE');
            $addForeignIfMissing('role_has_permissions', 'permission_id', 'role_has_permissions_permission_id_foreign', 'permissions', 'id', 'CASCADE', 'RESTRICT');
            $addForeignIfMissing('role_has_permissions', 'role_id', 'role_has_permissions_role_id_foreign', 'roles', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
if (DB::getDriverName() !== 'mysql') {
                return;
            }

            $dropIfExists = static function (string $table, string $constraintName): void {
                if (! Schema::hasTable($table)) {
                    return;
                }

                $exists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->whereRaw('TABLE_SCHEMA = DATABASE()')
                    ->where('TABLE_NAME', $table)
                    ->where('CONSTRAINT_NAME', $constraintName)
                    ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
                    ->exists();

                if ($exists) {
                    DB::statement(sprintf(
                        'ALTER TABLE `%s` DROP FOREIGN KEY `%s`',
                        $table,
                        $constraintName
                    ));
                }
            };

            $dropIfExists('role_has_permissions', 'role_has_permissions_role_id_foreign');
            $dropIfExists('role_has_permissions', 'role_has_permissions_permission_id_foreign');
            $dropIfExists('model_has_roles', 'model_has_roles_mdoel_id_foreign');
            $dropIfExists('model_has_roles', 'model_has_roles_role_id_foreign');
            $dropIfExists('model_has_permissions', 'model_has_permissions_permission_id_foreign');
            $dropIfExists('log_user_logs', 'log_user_logs_ibfk_1');
            $dropIfExists('notifications', 'notifications_ibfk_transaction');
            $dropIfExists('notifications', 'notifications_ibfk_user');
            $dropIfExists('tr_penalties', 'fk_penalty_rule_id');
            $dropIfExists('tr_penalties', 'fk_transaction_id');
            $dropIfExists('tr_transactions', 'tr_transactions_ibfk_2');
            $dropIfExists('tr_transactions', 'tr_transactions_ibfk_1');
            $dropIfExists('bk_favorite_books', 'fk_favorite_user');
            $dropIfExists('bk_favorite_books', 'fk_favorite_book');
            $dropIfExists('bk_inventories', 'bk_inventories_ibfk_1');
            $dropIfExists('bk_books', 'bk_books_ibfk_1');
            $dropIfExists('usr_visitor_details', 'usr_visitor_details_ibfk_1');
            $dropIfExists('usr_employee_details', 'usr_employee_details_ibfk_1');
            $dropIfExists('usr_student_details', 'usr_student_details_ibfk_1');
            $dropIfExists('usr_users', 'users_ibfk_1');
    }
};
