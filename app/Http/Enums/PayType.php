<?php

namespace App\Http\Enums;

/**
 * Типы оплаты
 */
enum PayType: int {

    /**
     * Наличная оплата
     */
    case Cash   = 1;

    /**
     * Оплата по карте
     */
    case Card   = 2;

    /**
     * Оплата переводом
     */
    case Phone  = 3;

}
