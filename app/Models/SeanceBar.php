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
     * Товар
     *
     * @return BelongsTo
     */
    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class, 'item_id', 'item_id');
    }


    /**
     * Итоговый оборот с бара
     *
     * @return int
     */
    public function getTotalPriceAttribute(): int
    {
        return (int) ($this->amount * $this->bar->price);
    }

    /**
     * Итоговая скидка с бара
     *
     * @return int
     */
    public function getSaleSumAttribute(): int
    {
        return (int) ($this->gift > 0
            ? $this->total_price
            : $this->total_price * $this->sale / 100);
    }

    /**
     * Итого с клиента за бар
     *
     * @return int
     */
    public function getTotalPriceWithSaleAttribute(): int
    {
        return $this->total_price - $this->sale_sum;
    }

    /**
     * Заработок администратора с бара
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        return Helper::adminPercent($this->admin->roles, PercentType::Program->value) * $this->total_price / 100;
    }

    /**
     * Заработок руковолителя с бара
     *
     * @return int
     */
    public function getOwnerProfitAttribute(): int
    {
        return $this->total_price_with_sale - $this->admin_profit;
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
        'total_price',
        'sale_sum',
        'total_price_with_sale',
        'admin_profit',
        'owner_profit',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'record_id', 'shift_id', 'seance_id', 'item_id', 'admin_id', 'guest',
        'amount', 'sale', 'gift', 'pay_type', 'note',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
