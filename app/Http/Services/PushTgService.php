<?php

namespace App\Http\Services;

use App\Models\Report;
use App\Models\SeanceBar;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
use App\Models\Shift;
use Illuminate\Support\Carbon;

class PushTgService {

    public static function test()
    {
        dump(ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), 'Test message'));
    }

    public static function openShift(Shift $shift)
    {
        $message = "Открыта смена " . $shift->title;
        $message .= "\r\n";
        $message .= "Администратор: " . $shift->openedAdmin->name;
        $message .= "\r\n";
        $message .= "Время открытия: " . Carbon::now(+2)->format('H:i:s');

        ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }

    public static function program(SeanceProgram $seance)
    {
        $message = "Проведена программа: " . $seance->program->title;
        $message .= "\r\n";
        $message .= "Администратор: " . $seance->admin->name;
        $message .= "\r\n";
        $message .= "Мастер 1: " . $seance->master->name;
        $message .= "\r\n";
        if (!is_null($seance->cover_master)) {
            $message .= "Мастер 2: " . $seance->cover_master->name;
            $message .= "\r\n";
        }
        if ($seance->sale_payed == 0) {
            $message .= "Без скидки";
            $message .= "\r\n";
        }
        $message .= "\r\n";
        $message .= "Доход: " . $seance->seance_price . 'р.';
        $message .= "\r\n";
        $message .= "Зарплаты: " . $seance->seance_price - $seance->owner_profit . 'р.';
        $message .= "\r\n";
        $message .= "Баланс: " . $seance->owner_profit . 'р. ';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Время начала: " . Carbon::parse($seance->open_time)->format('H:i:s');
        $message .= "\r\n";
        $message .= "Время окончания: " . Carbon::parse($seance->close_time)->format('H:i:s');

        ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }

    public static function service(SeanceService $seance)
    {
        $message = "Оказана услуга: " . $seance->service->title . ' x ' . $seance->amount;
        $message .= "\r\n";
        $message .= "Администратор: " . $seance->admin->name;
        $message .= "\r\n";
        $message .= "Мастер 1: " . $seance->master->name;
        $message .= "\r\n";
        if (!is_null($seance->cover_master)) {
            $message .= "Мастер 2: " . $seance->cover_master->name;
            $message .= "\r\n";
            }
        if ($seance->sale_payed == 0) {
            $message .= "Без скидки";
            $message .= "\r\n";
        }
        $message .= "\r\n";
        $message .= "Доход: " . $seance->service_price . 'р.';
        $message .= "\r\n";
        $message .= "Зарплаты: " . $seance->service_price - $seance->owner_profit . 'р.';
        $message .= "\r\n";
        $message .= "Баланс: " . $seance->owner_profit . 'р. ';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Время: " . Carbon::parse($seance->created_at)->format('H:i:s');

        ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }

    public static function bar(SeanceBar $seance)
    {
        $message = "Продан напиток: " . $seance->bar->title . ' x ' . $seance->amount;
        $message .= "\r\n";
        $message .= "Администратор: " . $seance->admin->name;
        $message .= "\r\n";
        if ($seance->sale_payed == 0) {
            $message .= "Без скидки";
            $message .= "\r\n";
        }
        $message .= "\r\n";
        $message .= "Доход: " . $seance->bar_price . 'р.';
        $message .= "\r\n";
        $message .= "Зарплаты: " . $seance->bar_price - $seance->owner_profit . 'р.';
        $message .= "\r\n";
        $message .= "Баланс: " . $seance->owner_profit . 'р. ';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Время: " . Carbon::parse($seance->created_at)->format('H:i:s');

        ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }

    public static function closeShift(Report $report)
    {
        $message = "Закрыта смена " . $report->shift->title;
        $message .= "\r\n";
        $message .= "Администратор: " . $report->shift->closedAdmin->name;
        $message .= "\r\n";
        $message .= "Кол-во гостей: " . $report->clients;
        $message .= "\r\n";
        $message .= "Выручка смены: " . $report->cash_profit + $report->card_profit + $report->phone_profit . 'р.';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Выручка наличкой " . $report->cash_profit . 'р.';
        $message .= "\r\n";
        $message .= "Выручка безналом " . $report->card_profit . 'р.';
        $message .= "\r\n";
        $message .= "Выручка переводами " . $report->phone_profit . 'р.';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Зарплаты:\r\n";
        if (!is_null($report->shift->admins_profits)) {
            foreach($report->shift->admins_profits as $data) {
                $message .= $data['name'] . ": " . $data['profit'] . "р.";
                $message .= "\r\n";
            }
        }
        if (!is_null($report->shift->masters_profits)) {
            foreach ($report->shift->masters_profits as $data) {
                $message .= $data['name'] . ": " . $data['profit'] . "р.";
                $message .= "\r\n";
            }
        }
        $message .= "\r\n";
        $message .= "Издержки: " . 0 - $report->expenses - $report->admin_profit - $report->masters_profit - $report->sale_sum . 'р.';
        $message .= "\r\n";
        $message .= "Баланс: " . $report->cash_profit + $report->card_profit + $report->phone_profit
            - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum . 'р.';
        $message .= "\r\n";
        $message .= "Остаток в кассе: " . $report->stock . 'р.';
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Время закрытия: " . Carbon::now(+2)->format('H:i:s');

        ApiTg::sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }
}
