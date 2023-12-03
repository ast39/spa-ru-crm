<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CabinetOwnerFilter extends AbstractFilter {

    public const FROM = 'from';

    public const TO = 'to';

    public const USER = 'user';


    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::FROM => [$this, 'from'],
            self::TO => [$this, 'to'],
            self::USER => [$this, 'user'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function from(Builder $builder, $value): void
    {
        $builder->where('title', '>=', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function to(Builder $builder, $value): void
    {
        $builder->where('title', '<=', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function user(Builder $builder, $value): void
    {
        $builder->where("opened_admin_id", $value)
            ->orWhereHas('shiftPrograms', function($q) use ($value) {
                $q->where('seance_programs.master_id', $value);
            })
            ->orWhereHas('shiftServices', function($q) use ($value) {
                $q->where('seance_services.master_id', $value);
            });
    }

}
