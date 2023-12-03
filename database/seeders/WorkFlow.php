<?php

namespace Database\Seeders;

use App\Http\Enums\PayType;
use App\Http\Enums\RoleType;
use App\Http\Enums\SoftStatus;
use App\Http\Services\DailyReport;
use App\Http\Services\ShiftHelper;
use App\Models\Report;
use App\Models\SeanceBar;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class WorkFlow extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_1 = User::create([
            'name' => 'Луиза',
            'login' => 'admin1',
            'password' => Hash::make('admin1'),
            'note' => 'Старший администратор',
        ]);
        $admin_1->roles()->attach(RoleType::Administrator->value, [
            'percent_program' => 10,
            'percent_service' => 10,
            'percent_bar' => 10,
        ]);
        $admin_1->roles()->attach(RoleType::Master->value, [
            'percent_program' => 50,
            'percent_service' => 50,
            'percent_bar' => 0,
        ]);


        $admin_2 = User::create([
            'name' => 'Снежана',
            'login' => 'admin2',
            'password' => Hash::make('admin2'),
            'note' => 'Администратор 2',
        ]);
        $admin_2->roles()->attach(RoleType::Administrator->value, [
            'percent_program' => 10,
            'percent_service' => 10,
            'percent_bar' => 10,
        ]);
        $admin_2->roles()->attach(RoleType::Master->value, [
            'percent_program' => 50,
            'percent_service' => 50,
            'percent_bar' => 0,
        ]);


        $master_1 = User::create([
            'name' => 'Юля',
            'login' => 'master1',
            'password' => Hash::make('master1'),
            'note' => 'Старший мастер',
        ]);
        $master_1->roles()->attach(RoleType::Master->value, [
            'percent_program' => 30,
            'percent_service' => 30,
            'percent_bar' => 0,
        ]);


        $master_2 = User::create([
            'name' => 'Мария',
            'login' => 'master2',
            'password' => Hash::make('master2'),
            'note' => 'Мастер 2',
        ]);
        $master_2->roles()->attach(RoleType::Master->value, [
            'percent_program' => 30,
            'percent_service' => 30,
            'percent_bar' => 0,
        ]);


        $master_3 = User::create([
            'name' => 'Анна',
            'login' => 'master3',
            'password' => Hash::make('master3'),
            'note' => 'Мастер 3',
        ]);
        $master_3->roles()->attach(RoleType::Master->value, [
            'percent_program' => 30,
            'percent_service' => 30,
            'percent_bar' => 0,
        ]);

        $shift_1 = Shift::query()->create([
            'title' => Carbon::now()->startOfDay()->subWeek()->format('Y-m-d'),
            'opened_admin_id' => $admin_1->id,
            'closed_admin_id' => $admin_1->id,
            'opened_time' => Carbon::now()->startOfDay()->subWeek(),
            'closed_time' => Carbon::now()->startOfDay()->subWeek()->addDay(),
            'note' => 'Тестовая смена 1',
            'status' => SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(11),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(11),
        ]);

        $program_1 = SeanceProgram::query()->create([
            'shift_id' => $shift_1->shift_id,
            'admin_id' => $admin_1->id,
            'master_id' => $master_1->id,
            'program_id' => rand(1, 20),
            'guest' => 'Просто гость',
            'from' => 'Реклама',
            'open_time' => Carbon::now()->startOfDay()->subWeek()->addHours(12),
            'close_time' => Carbon::now()->startOfDay()->subWeek()->addHours(13),
            'sale' => 5,
            'pay_type' => PayType::Card->value,
            'note' => 'Тестовая программа 1',
            'status' => SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(12),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(12),
        ]);

        SeanceService::query()->create([
            'shift_id' => $shift_1->shift_id,
            'seance_id' => $program_1->seance_id,
            'admin_id' => $admin_1->id,
            'master_id' => $master_1->id,
            'service_id' => rand(1,6),
            'guest' => 'Просто гость',
            'amount' => 1,
            'sale' => 5,
            'pay_type' => PayType::Card->value,
            'note' => 'Тестовая услуга 1',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(12),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(12),
        ]);

        $program_2 = SeanceProgram::query()->create([
            'shift_id' => $shift_1->shift_id,
            'admin_id' => $admin_1->id,
            'master_id' => $master_2->id,
            'program_id' => rand(1, 20),
            'guest' => 'Просто гость',
            'from' => 'Реклама',
            'open_time' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
            'close_time' => Carbon::now()->startOfDay()->subWeek()->addHours(15),
            'pay_type' => PayType::Cash->value,
            'note' => 'Тестовая программа 2',
            'status' =>SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
        ]);

        SeanceService::query()->create([
            'shift_id' => $shift_1->shift_id,
            'admin_id' => $admin_1->id,
            'master_id' => $master_2->id,
            'service_id' => rand(1,6),
            'guest' => 'Просто гость',
            'amount' => 1,
            'pay_type' => PayType::Cash->value,
            'note' => 'Тестовая услуга 2',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
        ]);

        SeanceBar::query()->create([
            'shift_id' => $shift_1->shift_id,
            'seance_id' => $program_2->seance_id,
            'item_id' => rand(1, 6),
            'admin_id' => $admin_1->id,
            'guest' => 'Просто гость',
            'amount' => rand(1,4),
            'pay_type' => PayType::Cash->value,
            'note' => 'Тестовый напиток 1',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addHours(14),
        ]);

        $dl = new DailyReport(ShiftHelper::lastShift());
        $shift_id = ShiftHelper::currentShiftId();

        $data['shift_id'] = $shift_id;
        $data['clients'] = $dl->guests();
        $data['cash_profit'] = $dl->cash();
        $data['card_profit'] = $dl->card();
        $data['phone_profit'] = $dl->phone();
        $data['programs_profit'] = $dl->programs();
        $data['services_profit'] = $dl->services();
        $data['bar_profit'] = $dl->bar();
        $data['admin_profit'] = $dl->adminProfit();
        $data['masters_profit'] = $dl->mastersProfit();
        $data['sale_sum'] = $dl->saleSum();
        $data['owner_profit'] = $dl->ownerProfit();
        $data['expenses'] = rand(500, 1500);
        $data['stock'] = rand(500, 1500);
        $data['additional'] = 'Итоги первой тестовой смены';

        Report::query()->create($data);



        $shift_2 = Shift::query()->create([
            'title' => Carbon::now()->startOfDay()->subWeek()->addDay()->format('Y-m-d'),
            'opened_admin_id' => $admin_2->id,
            'closed_admin_id' => $admin_2->id,
            'opened_time' => Carbon::now()->startOfDay()->subWeek()->addDay(),
            'closed_time' => Carbon::now()->startOfDay()->subWeek()->addDays(2),
            'note' => 'Тестовая смена 2',
            'status' => SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(11),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(11),
        ]);

        $program_3 = SeanceProgram::query()->create([
            'shift_id' => $shift_2->shift_id,
            'admin_id' => $admin_2->id,
            'master_id' => $master_2->id,
            'program_id' => rand(1, 20),
            'guest' => 'Просто гость',
            'from' => 'Реклама',
            'open_time' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(15),
            'close_time' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(16),
            'sale' => 5,
            'pay_type' => PayType::Cash->value,
            'note' => 'Тестовая программа 3',
            'status' => SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(15),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(15),
        ]);

        SeanceService::query()->create([
            'shift_id' => $shift_2->shift_id,
            'seance_id' => $program_3->seance_id,
            'admin_id' => $admin_2->id,
            'master_id' => $master_2->id,
            'service_id' => rand(1,6),
            'guest' => 'Просто гость',
            'amount' => 1,
            'pay_type' => PayType::Cash->value,
            'note' => 'Тестовая услуга 3',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(15),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(15),
        ]);

        $program_4 = SeanceProgram::query()->create([
            'shift_id' => $shift_2->shift_id,
            'admin_id' => $admin_2->id,
            'master_id' => $master_3->id,
            'program_id' => rand(1, 20),
            'guest' => 'Просто гость',
            'from' => 'Реклама',
            'open_time' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
            'close_time' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(18),
            'pay_type' => PayType::Phone->value,
            'note' => 'Тестовая программа 4',
            'status' => SoftStatus::On->value,
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
        ]);

        SeanceService::query()->create([
            'shift_id' => $shift_2->shift_id,
            'admin_id' => $admin_2->id,
            'master_id' => $master_3->id,
            'service_id' => rand(1,6),
            'guest' => 'Просто гость',
            'amount' => 1,
            'gift' => 1,
            'pay_type' => PayType::Phone->value,
            'note' => 'Тестовая услуга 4',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
        ]);

        SeanceBar::query()->create([
            'shift_id' => $shift_2->shift_id,
            'seance_id' => $program_4->seance_id,
            'item_id' => rand(1, 6),
            'admin_id' => $admin_2->id,
            'guest' => 'Просто гость',
            'amount' => rand(1,4),
            'gift' => 1,
            'pay_type' => PayType::Phone->value,
            'note' => 'Тестовый напиток 2',
            'created_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
            'updated_at' => Carbon::now()->startOfDay()->subWeek()->addDay()->addHours(17),
        ]);

        $dl = new DailyReport(ShiftHelper::lastShift());
        $shift_id = ShiftHelper::currentShiftId();

        $data['shift_id'] = $shift_id;
        $data['clients'] = $dl->guests();
        $data['cash_profit'] = $dl->cash();
        $data['card_profit'] = $dl->card();
        $data['phone_profit'] = $dl->phone();
        $data['programs_profit'] = $dl->programs();
        $data['services_profit'] = $dl->services();
        $data['bar_profit'] = $dl->bar();
        $data['admin_profit'] = $dl->adminProfit();
        $data['masters_profit'] = $dl->mastersProfit();
        $data['sale_sum'] = $dl->saleSum();
        $data['owner_profit'] = $dl->ownerProfit();
        $data['expenses'] = rand(500, 1500);
        $data['stock'] = rand(500, 1500);
        $data['additional'] = 'Итоги второй тестовой смены';

        Report::query()->create($data);
    }
}
