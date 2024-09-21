<?php

namespace App\Http\Services;

use App\Http\Enums\PayType;
use App\Models\SeanceBar;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
use App\Models\Shift;
use Carbon\Carbon;

/**
 * Модель лога смены
 *
 * @total() : Выручка общая
 * @cash() : Выручка наличкой
 * @card() : Выручка безналом
 * @phone() : Выручка переводами
 * @programs() : Выручка с программ
 * @services() : Выручка с услуг
 * @bar() : Выручка с товаров
 * @adminProfit() : Зарплата администратору
 * @mastersProfit() : Зарплата мастерам
 * @ownerProfit() : Прибыль предприятия
 * @saleSum() : Скидки гостям
 * @guests() : Клиентов за смену
 */
class DailyReport {

    # Смена
    protected string $shift;

    # ID смены
    protected $shift_id;

    # Список продаж программ
    protected array  $program_list = [];

    # Список продаж сервисов
    protected array  $service_list = [];

    # Список продаж товаров
    protected array  $bar_list = [];


    public function __construct(string $date)
    {
        $this->shift = Carbon::parse($date)->format('Y-m-d');

        $this->workDataParse();
    }

    /**
     * Выручка общая
     *
     * @return int
     */
    public function total(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['total_price'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['service']['price'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['total_price'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Выручка наличкой
     *
     * @return int
     */
    public function cash(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['cash_payed'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['cash_payed'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['cash_payed'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Выручка безналом
     *
     * @return int
     */
    public function card(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['card_payed'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['card_payed'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['card_payed'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Выручка переводами
     *
     * @return int
     */
    public function phone(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['phone_payed'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['phone_payed'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['phone_payed'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Оплачено сертификатом
     *
     * @return int
     */
    public function byCertificates(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['cert_payed'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['cert_payed'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['cert_payed'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Выручка с программ
     *
     * @return int
     */
    public function programs(): int
    {
        return array_sum(
            array_map(function($seance) {
                return $seance['seance_price_with_sale'];
            },  array_filter($this->program_list, function($e) {
                    return $e['status'] == 1;
                })
            )
        );
    }

    /**
     * Выручка с услуг
     *
     * @return int
     */
    public function services(): int
    {
        return array_sum(
            array_map(function($service) {
                return $service['service_price_with_sale'];
            },  array_filter($this->service_list, function($e) {
                    return $e['status'] == 1;
                })
            )
        );
    }

    /**
     * Выручка с товаров
     *
     * @return int
     */
    public function bar(): int
    {
        return array_sum(
            array_map(function($item) {
                return $item['bar_price_with_sale'];
            }, $this->bar_list)
        );
    }

    /**
     * Зарплата администратору
     *
     * @return int
     */
    public function adminProfit(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['admin_profit'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['admin_profit'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['admin_profit'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Зарплата мастерам
     *
     * @return int
     */
    public function mastersProfit(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['master_profit'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['master_profit'];
            }, $this->service_list)
        );

        return $programs + $services;
    }

    /**
     * Прибыль предприятия
     *
     * @return int
     */
    public function ownerProfit(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['owner_profit'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['owner_profit'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['owner_profit'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Скидки гостям
     *
     * @return int
     */
    public function saleSum(): int
    {
        $programs = array_sum(
            array_map(function($seance) {
                return $seance['sale_payed'];
            }, $this->program_list)
        );

        $services = array_sum(
            array_map(function($service) {
                return $service['sale_payed'];
            }, $this->service_list)
        );

        $bar = array_sum(
            array_map(function($item) {
                return $item['sale_payed'];
            }, $this->bar_list)
        );

        return $programs + $services + $bar;
    }

    /**
     * Клиентов за смену
     *
     * @return int
     */
    public function guests(): int
    {
        return count($this->program_list);
    }

    /**
     * Детализация смены
     *
     * @return void
     */
    private function workDataParse(): void
    {
        $shift_id = Shift::where('title', Carbon::parse($this->shift)->format('Y-m-d'))->first();
        $this->shift_id = $shift_id->shift_id;

        $this->program_list = SeanceProgram::query()
            ->where('shift_id', $this->shift_id)
            ->get()
            ->toArray();

        $this->service_list = SeanceService::query()
            ->where('shift_id', $this->shift_id)
            ->get()
            ->toArray();

        $this->bar_list = SeanceBar::query()
            ->where('shift_id', $this->shift_id)
            ->get()
            ->toArray();
    }

    /**
     * Начало смены
     *
     * @return string
     */
    private function shiftStart(): string
    {
        return Carbon::parse($this->shift)->startOfDay()->addHours(ShiftHelper::SHIFT_CHANGE_HOUR);
    }

    /**
     * Окончание смены
     *
     * @return string
     */
    private function shiftEnd(): string
    {
        return Carbon::parse($this->shiftStart())->addDay();
    }
}
