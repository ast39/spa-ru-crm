<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(Users::class);
        $this->call(Roles::class);
        $this->call(Programs::class);
        $this->call(Services::class);
        $this->call(BarItems::class);
        $this->call(WorkFlow::class);
    }
}
