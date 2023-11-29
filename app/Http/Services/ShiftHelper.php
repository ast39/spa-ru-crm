<?php

namespace App\Http\Services;

use App\Http\Enums\SoftStatus;
use App\Models\Shift;
use Carbon\Carbon;

/**
 * Helper по сменам
 */
class ShiftHelper {

    /**
     * Час пересменки
     */
    const SHIFT_CHANGE_HOUR = 11;


    /**
     * Это первая смена в салоне?
     *
     * @return bool
     */
    public static function firstShift(): bool
    {
        return Shift::query()->count('*') == 0;
    }

    /**
     * Последняя смена не закрыта?
     *
     * @return bool
     */
    public static function notClosedLastShift(): bool
    {
        return Shift::query()->get()->last()->status == SoftStatus::Off->value;
    }

    /**
     * Какая сейчас смена (дата открытия смены)
     *
     * @return string
     */
    public static function currentShift(): string
    {
        return Carbon::now(+2)->format('H') >= self::SHIFT_CHANGE_HOUR
            ? Carbon::now(+2)->format('Y-m-d')
            : Carbon::now(+2)->subDay()->format('Y-m-d');
    }

    /**
     * ID текущей смены
     *
     * @return int|null
     */
    public static function currentShiftId():? int
    {
        $shift = Shift::query()->get()->last();

        return $shift?->shift_id;
    }

    /**
     * Дата текущей смены
     *
     * @return string
     */
    public static function lastShift(): string
    {
        return Shift::query()->get()->last()->title;
    }

    /**
     * Последняя смена - текущая смена?
     *
     * @return bool
     */
    public static function lastShiftIsCurrentShift(): bool
    {
        return Shift::query()->get()->last()->title == self::currentShift();
    }

}
