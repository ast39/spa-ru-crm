<?php

namespace App\Http\Enums;

/**
 * Типы ролей
 */
enum RoleType: int {

    /**
     * Владелец
     */
    case Owner   = 1;

    /**
     * Администратор
     */
    case Administrator = 2;

    /**
     * Мастер
     */
    case Master  = 3;

    /**
     * Мастер-администратор
     */
    case MasterAdmin  = 5;

}
