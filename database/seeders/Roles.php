<?php

namespace Database\Seeders;

use App\Models\Role;;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'title' => 'owner',
            'note'  => 'Владелец бизнеса',
        ]);

        Role::create([
            'title' => 'administrator',
            'note'  => 'Администратор смены',
        ]);

        Role::create([
            'title' => 'master',
            'note'  => 'Мастер, проводящий программы',
        ]);
    }
}
