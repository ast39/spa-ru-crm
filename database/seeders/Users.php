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


        $user = User::create([
            'name' => 'Администратор',
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'note' => 'Администратор',
        ]);

        $user->roles()->attach(RoleType::Administrator->value, [
            'percent_program' => 10,
            'percent_service' => 10,
            'percent_bar' => 10,
        ]);


        $user = User::create([

            'name' => 'Мастер',
            'login' => 'master',
            'password' => Hash::make('master'),
            'note' => 'Мастер',
        ]);

        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 25,
            'percent_service' => 25,
            'percent_bar' => 0,
        ]);


        $user = User::create([
            'name' => 'Мастер Админимтратор',
            'login' => 'master_admin',
            'password' => Hash::make('master_admin'),
            'note' => 'Мастер-администратор',
        ]);

        $user->roles()->attach(RoleType::Administrator->value, [
            'percent_program' => 10,
            'percent_service' => 10,
            'percent_bar' => 10,
        ]);
        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 30,
            'percent_service' => 30,
            'percent_bar' => 0,
        ]);
    }
}
