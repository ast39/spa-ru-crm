<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BarFilter extends AbstractFilter {

    public const TITLE  = 'title';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::TITLE  => [$this, 'title'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function title(Builder $builder, $value): void
    {
        $builder->where('title', 'like', '%' . $value . '%');
    }

}
