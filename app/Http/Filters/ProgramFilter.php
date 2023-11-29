<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProgramFilter extends AbstractFilter {

    public const TITLE  = 'title';
    public const TYPE   = 'type';
    public const PERIOD = 'period';
    public const STATUS = 'status';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::TITLE  => [$this, 'title'],
            self::TYPE   => [$this, 'type'],
            self::PERIOD => [$this, 'period'],
            self::STATUS => [$this, 'status'],
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

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function type(Builder $builder, $value): void
    {
        $builder->where('type', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function period(Builder $builder, $value): void
    {
        $builder->where('period', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function status(Builder $builder, $value): void
    {
        $builder->where('status', $value);
    }

}
