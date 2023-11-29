<?php

namespace App\Http\Enums;

/**
 * Типы программ
 */
enum ProgramType: int {

    /**
     * Для мужчин
     */
    case Man   = 1;

    /**
     * Для женщин
     */
    case Woman = 2;

    /**
     * Для пар
     */
    case Pair  = 3;

    /**
     * Для всех
     */
    case All   = 4;

}
