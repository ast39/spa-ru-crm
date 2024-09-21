<?php

namespace App\Models;

use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Http\Services\ShiftHelper;use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SeanceBar extends Model {

    use HasFactory, Filterable;


    protected $table         = 'seance_bar';

    protected $primaryKey    = 'record_id';

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
     * Напиток
     *
     * @return BelongsTo
     */
    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class, 'item_id', 'item_id');
    }


    /**
     * Фактическая цена напитка до скидок
     *
     * @return int
     */
    public function getBarPriceAttribute(): int
    {
        return $this->cash_payed + $this->card_payed + $this->phone_payed + $this->cert_payed + $this->sale_payed;
    }

    /**
     * Итого с клиента за напиток
     *
     * @return int
     */
    public function getBarPriceWithSaleAttribute(): int
    {
        return $this->bar_price - $this->sale_payed;
    }

    /**
     * Заработок администратора с напитка
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        return $this->admin_percent > 0
            ? $this->admin_percent * $this->getBarPriceAttribute() / 100
            : Helper::adminPercent($this->admin->roles, PercentType::Service->value) * $this->getBarPriceAttribute() / 100;
    }

    /**
     * Заработок руководителя с товаров
     *
     * @return int
     */
    public function getOwnerProfitAttribute(): int
    {
        return $this->bar_price_with_sale - $this->admin_profit;
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
        'bar',
    ];

    protected $appends = [
        'bar_price',
        'bar_price_with_sale',
        'admin_profit',
        'owner_profit',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'record_id', 'shift_id', 'item_id', 'admin_id', 'guest', 'note',
        'admin_percent',
        'cash_payed', 'card_payed', 'phone_payed', 'cert_payed', 'sale_payed', 'handle_price',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
