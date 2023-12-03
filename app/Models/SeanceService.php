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

class SeanceService extends Model {

    use HasFactory, Filterable;


    protected $table         = 'seance_services';

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
     * Мастер
     *
     * @return BelongsTo
     */
    public function master(): BelongsTo
    {
        return $this->belongsTo(User::class, 'master_id', 'id');
    }

    /**
     * Услуга
     *
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }


    /**
     * Итоговый оборот с услуг
     *
     * @return int
     */
    public function getTotalPriceAttribute(): int
    {
        return (int) ($this->amount * $this->service->price);
    }

    /**
     * Итоговая скидка с услуг
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
     * Итого с клиента за услуги
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
        return $this->admin_id == $this->master_id
            ? 0
            : Helper::adminPercent($this->admin->roles, PercentType::Service->value) * $this->total_price / 100;
    }

    /**
     * Заработок мастера с бара
     *
     * @return int
     */
    public function getMasterProfitAttribute(): int
    {
        return Helper::masterPercent($this->master->roles, PercentType::Service->value) * $this->total_price / 100;
    }

    /**
     * Заработок руковолителя с бара
     *
     * @return int
     */
    public function getOwnerProfitAttribute(): int
    {
        return $this->total_price_with_sale - $this->admin_profit - $this->master_profit;
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
        'service',
    ];

    protected $appends = [
        'total_price',
        'sale_sum',
        'total_price_with_sale',
        'admin_profit',
        'master_profit',
        'owner_profit',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'record_id', 'shift_id', 'seance_id',  'admin_id', 'master_id', 'service_id', 'guest',
        'amount', 'sale', 'gift', 'pay_type', 'note',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
