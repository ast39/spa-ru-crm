<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ReportFilter extends AbstractFilter {

    public const FROM = 'from';

    public const TO = 'to';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::FROM => [$this, 'from'],
            self::TO => [$this, 'to'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function from(Builder $builder, $value): void
    {
        $builder->whereHas('shift', function ($q) use ($value) {
            $q->where("shifts.title", '>=', $value);
        });
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function to(Builder $builder, $value): void
    {
        $builder->whereHas('shift', function ($q) use ($value) {
            $q->where("shifts.title", '<=', $value);
        });
    }

}
