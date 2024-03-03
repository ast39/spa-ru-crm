<?php

namespace App\Http\Services;

use App\Http\Enums\PayType;
use App\Http\Enums\ProgramType;
use App\Http\Enums\RoleType;
use Illuminate\Support\Collection;


class Helper {

    /**
     * Помощь в поиске услуги в списке
     *
     * @param Collection $list
     * @param int $id
     * @return array|int[]
     */
    public static function findServiceInList(Collection $list, int $id): array
    {
        foreach ($list as $item) {
            if ($item->service_id == $id) {
                return [
                    'amount' => $item->amount,
                    'gift' => $item->gift,
                ];
            }
        }

        return [
            'amount' => 0,
            'gift' => 0,
        ];
    }

    /**
     * Помощь в поиске напитка в списке
     *
     * @param Collection $list
     * @param int $id
     * @return array|int[]
     */
    public static function findBarInList(Collection $list, int $id): array
    {
        foreach ($list as $item) {
            if ($item->item_id == $id) {
                return [
                    'amount' => $item->amount,
                    'gift' => $item->gift,
                ];
            }
        }

        return [
            'amount' => 0,
            'gift' => 0,
        ];
    }

    /**
     * Роль пользователя словами
     *
     * @param Collection $roles
     * @return string
     */
    public static function detectRole(Collection $roles): string
    {
        $answer = 0;

        foreach ($roles as $role) {
            $answer += $role->id;
        }

        switch ($answer) {

            case 1 : return __(RoleType::Owner->name);
            case 2 : return __(RoleType::Administrator->name);
            case 3 : return __(RoleType::Master->name);
            case 5 : return __(RoleType::MasterAdmin->name);

            default : return __('NoRole');
        }
    }

    /**
     * Сумма ролей
     *
     * @param Collection $roles
     * @return int
     */
    public static function roleSum(Collection $roles): int
    {
        $answer = 0;

        foreach ($roles as $role) {
            $answer += $role->id;
        }

        return $answer;
    }

    /**
     * Процент администратора
     *
     * @param Collection $roles
     * @param string $type
     * @return int
     */
    public static function adminPercent(Collection $roles, string $type): int
    {
        foreach ($roles as $role) {
            if ($role->id == RoleType::Administrator->value) {
                return $role->permissions->$type;
            }
        }

        return 0;
    }

    /**
     * Процент мастера
     *
     * @param Collection $roles
     * @param string $type
     * @return int
     */
    public static function masterPercent(Collection $roles, string $type): int
    {
        foreach ($roles as $role) {
            if ($role->id == RoleType::Master->value) {
                return $role->permissions->$type;
            }
        }

        return 0;
    }

    /**
     * @param int $status
     * @return string
     */
    public static function programStatus(int $status): string
    {
        switch ($status) {

            case 1  : return 'Доступна';

            default : return 'Закрыта';
        }
    }

    /**
     * @param int $num
     * @param array $words
     * @return string
     */
    public static function num2word(int $num, array $words): string
    {
        $num = $num % 100;

        if ($num > 19) {
            $num = $num % 10;
        }

        switch ($num) {

            case 1  : return($words[0]);
            case 2  :
            case 3  :
            case 4  : return($words[1]);

            default : return($words[2]);
        }
    }

    /**
     * @param int $status
     * @return string
     */
    public static function seanceStatus(int $status): string
    {
        switch ($status) {

            case 2  : return 'отказ';

            default : return 'состоялась';
        }
    }

    /**
     * @param int $status
     * @return string
     */
    public static function serviceStatus($status): string
    {
        switch ($status) {

            case 2  : return 'отказ';

            default : return 'оказана';
        }
    }

    /**
     * @param int $status
     * @return string
     */
    public static function itemStatus(int $status): string
    {
        switch ($status) {

            case 1  : return 'В наличии';

            default : return 'Закончился';
        }
    }

    /**
     * @param int $service_id
     * @param array $services
     * @return array|null
     */
    public static function findService(int $service_id, array $services):? array
    {
        foreach ($services as $service) {
            if ($service['service_id'] == $service_id) {
                return $service;
            }
        }

        return null;
    }

    /**
     * @param int $item_id
     * @param array $items
     * @return array|null
     */
    public static function findItem(int $item_id, array $items):? array
    {
        foreach ($items as $item) {
            if ($item['item_id'] == $item_id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param int $type
     * @return string
     */
    public static function programType(int $type): string
    {
        switch ($type) {

            case ProgramType::Man->value   : return 'Для мужчин';
            case ProgramType::Woman->value : return 'Для женщин';
            case ProgramType::Pair->value  : return 'Для пар';

            default : return 'Для всех';
        }
    }

    /**
     * @param int $type
     * @return string
     */
    public static function payType(int $type): string
    {
        switch ($type) {

            case PayType::Cash->value  : return 'наличкой';
            case PayType::Card->value  : return 'картой';
            case PayType::Phone->value : return 'переводом';
            case PayType::Cert->value : return 'сертификатом';

            default : return '???';
        }
    }

}
