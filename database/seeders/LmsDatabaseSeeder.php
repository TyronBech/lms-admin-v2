<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LmsDatabaseSeeder extends Seeder
{
  /**
   * Seed LMS domain tables through focused per-table seeders.
   */
  public function run(): void
  {
    $this->call([
      PrivilegesTableSeeder::class,
      PenaltyRulesTableSeeder::class,
      UiSettingsTableSeeder::class,
      SystemSettingsTableSeeder::class,
      SuperAdminTableSeeder::class,
      LibraryUsersTableSeeder::class,
      CategoriesTableSeeder::class,
      BooksTableSeeder::class,
      InventoriesTableSeeder::class,
      TransactionsTableSeeder::class,
      NotificationsTableSeeder::class,
      PenaltiesTableSeeder::class,
      UserLogsTableSeeder::class,
      FavoriteBooksTableSeeder::class,
      StagingUsersTableSeeder::class,
      LogErrorsTableSeeder::class,
    ]);
  }
}
