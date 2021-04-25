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
        $this->call(EventSeeder::class);
        $this->call(CircleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(EntrySeeder::class);
    }
}
