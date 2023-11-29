<?php

namespace App\Http\Enums;

/**
 * Простые статусы
 */
enum SoftStatus: int {

    /**
     * Не доступен
     */
    case Off   = 0;

    /**
     * Доступен
     */
    case On = 1;

}
