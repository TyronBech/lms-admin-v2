<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Super Admin Seeder Credentials
    |--------------------------------------------------------------------------
    |
    | These values are used by SuperAdminTableSeeder to seed a default super
    | admin account in local/development/staging environments only.
    |
    | Set SEEDER_SUPER_ADMIN_EMAIL and SEEDER_SUPER_ADMIN_PASSWORD in your
    | .env file to override the defaults. The seeder will print the email to
    | the console so you always know which credentials were used.
    |
    */

    'super_admin_email' => env('SEEDER_SUPER_ADMIN_EMAIL', 'superadmin@local.test'),

    'super_admin_password' => env('SEEDER_SUPER_ADMIN_PASSWORD'),

    // When SEEDER_SUPER_ADMIN_PASSWORD is null (not set), SuperAdminTableSeeder
    // generates a cryptographically random 24-character password and prints it
    // to the console so it is never silently empty.

];
