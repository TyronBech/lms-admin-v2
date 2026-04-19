<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed roles and permissions based on the exported schema.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            $permissions = [
                'Add Books',
                'Edit Books',
                'Delete Books',
                'Create Reports',
                'View User Reports',
                'View Summary Reports',
                'View Inventory Reports',
                'View Transaction Reports',
                'View Book Circulation Reports',
                'Book Inventory',
                'Import Users',
                'Import Faculties & Staffs',
                'Import Books',
                'Add Privileges',
                'Edit Privileges',
                'Delete Privileges',
                'Add Categories',
                'Edit Categories',
                'Delete Categories',
                'Add Penalty Rule',
                'Edit Penalty Rule',
                'Delete Penalty Rule',
                'Edit Transactions',
                'View Users Maintenance',
                'View Books Maintenance',
                'View Book Categories Maintenance',
                'View Privileges Maintenance',
                'View Penalty Rules Maintenance',
                'View Transactions Maintenance',
                'View Dashboard',
                'Create Backups',
                'Reservation Approvals',
                'Modify UI Settings',
                'View Audit Reports',
            ];

            foreach ($permissions as $permission) {
                Permission::findOrCreate($permission, 'web');
            }

            $roles = [
                'Super Admin',
                'Admin',
                'Librarian',
                'Immersion',
                'Encoder',
            ];

            foreach ($roles as $role) {
                Role::findOrCreate($role, 'web');
            }

            $superAdmin = Role::where('name', 'Super Admin')
                ->where('guard_name', 'web')
                ->first();

            if ($superAdmin) {
                $superAdmin->syncPermissions(
                    Permission::where('guard_name', 'web')->pluck('name')->all(),
                );
            }

            app(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }
}
