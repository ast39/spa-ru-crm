<?php

namespace App\Http\Enums;

/**
 * Статусы сеансов
 */
enum SeanceStatus: int {

    /**
     * В процессе
     */
    case InProgress = 0;

    /**
     * Завеершен
     */
    case Completed = 1;

    /**
     * Отказ по инициативе клиента
     */
    case Rejected  = 2;

    /**
     * Отказ по инициативе мастера
     */
    case Canceled  = 3;

}
