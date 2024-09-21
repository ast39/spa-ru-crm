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


class SeanceProgram extends Model {

    use HasFactory, Filterable;


    protected $table         = 'seance_programs';

    protected $primaryKey    = 'seance_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * Администратор
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
     * Второй мастер
     *
     * @return BelongsTo
     */
    public function cover_master(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cover_master_id', 'id');
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
     * Фактическая цена программы до скидок
     *
     * @return int
     */
    public function getSeancePriceAttribute(): int
    {
        return $this->cash_payed + $this->card_payed + $this->phone_payed + $this->cert_payed + $this->sale_payed;
    }

    /**
     * Итого с клиента за программу
     *
     * @return int
     */
    public function getSeancePriceWithSaleAttribute(): int
    {
        return $this->status == 1
            ? $this->seance_price - $this->sale_payed
            : 0;
    }

    /**
     * Заработок администратора с программы
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        return $this->admin_id == $this->master_id || $this->status != 1
            ? 0
            : ($this->admin_percent > 0
                ? $this->admin_percent * $this->getSeancePriceAttribute() / 100
                : Helper::adminPercent($this->admin->roles, PercentType::Service->value) * $this->getSeancePriceAttribute() / 100);
    }

    /**
     * Заработок основного мастера с программы
     *
     * @return int
     */
    public function getMasterProfitAttribute(): int
    {
        return $this->status == 1
            ? ($this->master_percent > 0
                ? $this->master_percent * $this->getSeancePriceAttribute() / 100
                : Helper::adminPercent($this->master->roles, PercentType::Service->value) * $this->getSeancePriceAttribute() / 100)
            : 0;
    }

    /**
     * Заработок второго мастера с программы
     *
     * @return int
     */
    public function getCoverMasterProfitAttribute(): int
    {
        if (is_null($this->cover_master_id)) {
            return 0;
        }

        return $this->status == 1
            ? ($this->cover_master_percent > 0
                ? $this->cover_master_percent * $this->getSeancePriceAttribute() / 100
                : Helper::adminPercent($this->cover_master->roles, PercentType::Service->value) *$this->getSeancePriceAttribute() / 100)
            : 0;
    }

    /**
     * Заработок руководителя с программы
     *
     * @return int
     */
    public function getOwnerProfitAttribute(): int
    {
        return $this->seance_price_with_sale - $this->admin_profit - $this->master_profit - $this->cover_master_profit;
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
    ];

    protected $appends = [

        'seance_price',
        'seance_price_with_sale',
        'admin_profit',
        'master_profit',
        'cover_master_profit',
        'owner_profit',
    ];

    protected $casts = [

        'open_time'  => 'timestamp',
        'close_time' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [

        'seance_id', 'shift_id', 'admin_id', 'master_id', 'cover_master_id', 'program_id', 'guest', 'from',
        'admin_percent', 'master_percent', 'cover_master_percent',
        'open_time', 'close_time', 'note', 'status',
        'cash_payed', 'card_payed', 'phone_payed', 'cert_payed', 'sale_payed', 'handle_price',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
