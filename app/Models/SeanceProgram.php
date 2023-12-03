<?php

namespace App\Models;

use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeanceProgram extends Model {

    use HasFactory, Filterable;


    protected $table         = 'seance_programs';

    protected $primaryKey    = 'seance_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * Мастер
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    /**
     * Мастер
     *
     * @return BelongsTo
     */
    public function master(): BelongsTo
    {
        return $this->belongsTo(User::class, 'master_id', 'id');
    }

    /**
     * Программа
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    /**
     * Доп. услуги к программе
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(SeanceService::class, 'seance_id', 'seance_id');
    }

    /**
     * Напитки к программе
     *
     * @return HasMany
     */
    public function bar(): HasMany
    {
        return $this->hasMany(SeanceBar::class, 'seance_id', 'seance_id');
    }

    /**
     * Цена программы с учетом корректировки
     *
     * @return int
     */
    public function getSeancePriceAttribute(): int
    {
        return ($this->handle_price ?: 0) != 0
            ?  $this->handle_price
            : $this->program->price;
    }

    /**
     * Сумма доп. услуг
     *
     * @return int
     */
    public function getServicesPriceAttribute(): int
    {
        return
            array_sum(
                array_map(function($e) {
                    return $e['total_price'];
                }, $this->services->toArray())
            );
    }

    /**
     * Сумма напитков
     *
     * @return int
     */
    public function getBarPriceAttribute(): int
    {
        return
            array_sum(
                array_map(function($e) {
                    return $e['total_price'];
                }, $this->bar->toArray())
            );
    }

    /**
     * Итоговый оборот с программы
     *
     * @return int
     */
    public function getTotalPriceAttribute(): int
    {
        return $this->seance_price;
    }

    /**
     * Итоговый оборот с программы, услуг и бара
     *
     * @return int
     */
    public function getSeanceTotalPriceAttribute(): int
    {
        $services_price = array_sum(
            array_map(function($e) {
                return $e['total_price'];
            }, $this->services->toArray())
        );

        $bar_price = array_sum(
            array_map(function($e) {
                return $e['total_price'];
            }, $this->bar->toArray())
        );

        return $this->seance_price + $services_price + $bar_price;
    }

    /**
     * Итоговая скидка с программы
     *
     * @return int
     */
    public function getSaleSumAttribute(): int
    {
        return (int) ($this->total_price * $this->sale / 100);
    }

    /**
     * Итоговая скидка с программы, услуг и бара
     *
     * @return int
     */
    public function getSeanceSaleSumAttribute(): int
    {
        $services_sale = array_sum(
            array_map(function($e) {
                return $e['sale_sum'];
            }, $this->services->toArray())
        );

        $bar_sale = array_sum(
            array_map(function($e) {
                return $e['sale_sum'];
            }, $this->bar->toArray())
        );

        return $this->sale_sum + $services_sale + $bar_sale;
    }

    /**
     * Итого с клиента за программу
     *
     * @return int
     */
    public function getTotalPriceWithSaleAttribute(): int
    {
        return $this->total_price - $this->sale_sum;
    }

    /**
     * Итого с клиента за программу, услуги и бар
     *
     * @return int
     */
    public function getSeanceTotalPriceWithSaleAttribute(): int
    {
        return $this->seance_total_price - $this->seance_sale_sum;
    }

    /**
     * Заработок администратора с программы
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        return $this->admin_id == $this->master_id
            ? 0
            : Helper::adminPercent($this->admin->roles, PercentType::Program->value) * $this->total_price / 100;
    }

    /**
     * Заработок администратора с программы, услуг и бара
     *
     * @return int
     */
    public function getSeanceAdminProfitAttribute(): int
    {
        $seance_profit = array_sum(
            array_map(function($e) {
                return $e['admin_profit'];
            }, $this->services->toArray())
        );

        $bar_profit = array_sum(
            array_map(function($e) {
                return $e['admin_profit'];
            }, $this->bar->toArray())
        );

        return $this->admin_profit + $seance_profit + $bar_profit;
    }

    /**
     * Заработок мастера с программы
     *
     * @return int
     */
    public function getMasterProfitAttribute(): int
    {
        return Helper::masterPercent($this->master->roles, PercentType::Program->value) * $this->total_price / 100;
    }

    /**
     * Заработок мастера с программы, услуг и бара
     *
     * @return int
     */
    public function getSeanceMasterProfitAttribute(): int
    {
        $seance_profit = array_sum(
            array_map(function($e) {
                return $e['master_profit'];
            }, $this->services->toArray())
        );

        return $this->master_profit + $seance_profit;
    }

    /**
     * Заработок руковолителя с программы
     *
     * @return int
     */
    public function getOwnerProfitAttribute(): int
    {
        return $this->total_price_with_sale - $this->admin_profit - $this->master_profit;
    }

    /**
     * Заработок руковолителя с программы, услуг и бара
     *
     * @return int
     */
    public function getSeanceOwnerProfitAttribute(): int
    {
        $seance_profit = array_sum(
            array_map(function($e) {
                return $e['owner_profit'];
            }, $this->services->toArray())
        );

        $bar_profit = array_sum(
            array_map(function($e) {
                return $e['owner_profit'];
            }, $this->bar->toArray())
        );

        return $this->owner_profit + $seance_profit + $bar_profit;
    }


    /**
     * Выборка за текущую смену
     *
     * @param Builder $builder
     * @return void
     */
    public function scopeLastShift(Builder $builder): void
    {
        $builder->where('shift_id', ShiftHelper::currentShiftId());
    }


    protected $with = [
        'admin',
        'master',
        'program',
        'services',
        'bar',
    ];

    protected $appends = [
        'seance_price',
        'services_price',
        'bar_price',

        'total_price',
        'sale_sum',
        'total_price_with_sale',
        'admin_profit',
        'master_profit',
        'owner_profit',

        'seance_total_price',
        'seance_sale_sum',
        'seance_total_price_with_sale',
        'seance_admin_profit',
        'seance_master_profit',
        'seance_owner_profit',
    ];

    protected $casts = [
        'open_time'  => 'timestamp',
        'close_time' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'seance_id', 'shift_id', 'admin_id', 'master_id', 'program_id', 'guest', 'from',
        'open_time', 'close_time', 'handle_price', 'sale', 'pay_type', 'note', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
