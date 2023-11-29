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
            'name' => 'Луиза',
            'login' => 'admin1',
            'password' => Hash::make('admin1'),
            'note' => 'Старший администратор',
        ]);
        $user->roles()->attach(RoleType::Administrator->value, [
            'percent_program' => 15,
            'percent_service' => 15,
            'percent_bar' => 15,
        ]);
        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 40,
            'percent_service' => 40,
            'percent_bar' => 0,
        ]);


        $user = User::create([
            'name' => 'Снежана',
            'login' => 'admin2',
            'password' => Hash::make('admin2'),
            'note' => 'Администратор 2',
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


        $user = User::create([
            'name' => 'Юля',
            'login' => 'master1',
            'password' => Hash::make('master1'),
            'note' => 'Старший мастер',
        ]);
        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 40,
            'percent_service' => 40,
            'percent_bar' => 0,
        ]);


        $user = User::create([
            'name' => 'Мария',
            'login' => 'master2',
            'password' => Hash::make('master2'),
            'note' => 'Мастер 2',
        ]);
        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 30,
            'percent_service' => 30,
            'percent_bar' => 0,
        ]);


        $user = User::create([
            'name' => 'Анна',
            'login' => 'master3',
            'password' => Hash::make('master3'),
            'note' => 'Мастер 3',
        ]);
        $user->roles()->attach(RoleType::Master->value, [
            'percent_program' => 25,
            'percent_service' => 25,
            'percent_bar' => 0,
        ]);
    }
}
