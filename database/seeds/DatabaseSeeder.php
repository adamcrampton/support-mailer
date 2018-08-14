<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigsTableSeeder::class);
        $this->call(IssueTypesTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(StaffMembersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
