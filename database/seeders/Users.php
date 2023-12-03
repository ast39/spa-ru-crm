<?php

namespace Database\Seeders;

use App\Http\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Руководитель',
            'login' => 'root',
            'password' => Hash::make('root'),
            'note' => 'Владелец',
        ]);
        $user->roles()->attach([
            RoleType::Owner->value
        ]);
    }
}
