<?php

namespace App\Http\Enums;

/**
 * Типы заработка
 */
enum PercentType: string {

    /**
     * С программ
     */
    case Program   = 'percent_program';

    /**
     * С услуг
     */
    case Service   = 'percent_service';

    /**
     * С товаров
     */
    case Bar  = 'percent_bar';

}
