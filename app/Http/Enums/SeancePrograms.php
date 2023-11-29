<?php

namespace App\Http\Enums;

use App\Http\Services\ShiftHelper;
use App\Http\Traits\Filterable;
use App\Models\Program;
use App\Models\SeanceService;
use App\Models\SeanceBar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeancePrograms extends Model {

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
        return $this->belongsTo(User::class, 'master_id', 'master_id');
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
     * Цена программы с учетом корректировки
     *
     * @return int
     */
    public function getSeancePriceAttribute(): int
    {
        if (($this->extra_price ?: 0) > 0) {
            return $this->extra_price;
        }

        return $this->program->price;

    }

    public function scopeLastShift(Builder $builder): void
    {
        $builder->where('open_time', '>=', Carbon::parse(Shift::current())->startOfDay()->addHours(Shift::SHIFT_CHANGE_HOUR));
    }

    /**
     * Сумма доп. услуг
     *
     * @return int
     */
    public function getServicesPriceAttribute(): int
    {
        $services = array_filter($this->services->toArray(), function($e) {
            return $e['gift'] != 1;
        });

        return
            array_sum(
                array_map(function($e) {
                    return $e['service']['price'];
                }, $services)
            );
    }

    /**
     * Сумма доп. товаров
     *
     * @return int
     */
    public function getItemsPriceAttribute(): int
    {
        return
            array_sum(
                array_map(function($e) {
                    return $e['item']['price'] * $e['amount'];
                }, $this->items->toArray())
            );
    }

    /**
     * Цена программы с учетом корректировки
     *
     * @return int
     */
    public function getTotalSaleAttribute(): int
    {
        return floor(array_sum([$this->getSeancePriceAttribute(), $this->getServicesPriceAttribute()]) * $this->sale / 100);
    }

    /**
     * Итого заплатил клиент
     *
     * @return int
     */
    public function getTotalPriceAttribute(): int
    {
        return floor($this->getSeancePriceAttribute()
            + $this->getServicesPriceAttribute()
            + $this->getItemsPriceAttribute()
            - $this->getTotalSaleAttribute());
    }

    /**
     * Заработок администратора с сеанса
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        return $this->getTotalPriceAttribute() * $this->admin->percent / 100;
    }

    /**
     * Заработок мастера с сеанса
     *
     * @return int
     */
    public function getMasterProfitAttribute(): int
    {
        return ($this->getTotalPriceAttribute() - $this->getItemsPriceAttribute()) * $this->master->percent / 100;
    }

    /**
     * Доп. услуги к сеансу
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(SeanceService::class, 'seance_id', 'seance_id');
    }

    /**
     * Доп. товары к сеансу
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SeanceItem::class, 'seance_id', 'seance_id');
    }


    protected $with = [
        'admin',
        'master',
        'program',
        'services',
        'items',
    ];

    protected $appends = [
        'seance_price',
        'services_price',
        'items_price',
        'total_sale',
        'total_price',
        'admin_profit',
        'master_profit',
    ];

    protected $casts = [
        'open_time'  => 'timestamp',
        'close_time' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'seance_id', 'admin_id', 'program_id', 'master_id', 'guest', 'from', 'open_time', 'close_time',
        'sale', 'extra_price', 'pay_type', 'note', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
