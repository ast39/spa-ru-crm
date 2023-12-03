<?php

namespace App\Models;

use App\Http\Services\DailyReport;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model {

    use HasFactory, Filterable;


    protected $table         = 'shifts';

    protected $primaryKey    = 'shift_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * Администратор, открывший смену
     *
     * @return BelongsTo
     */
    public function openedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_admin_id', 'id');
    }

    /**
     * Администратор, закрывший смену
     *
     * @return BelongsTo
     */
    public function closedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_admin_id', 'id');
    }

    /**
     * Программы смены
     *
     * @return HasMany
     */
    public function shiftPrograms(): HasMany
    {
        return $this->hasMany(SeanceProgram::class, 'shift_id', 'shift_id');
    }

    /**
     * Доп. услуги смены
     *
     * @return HasMany
     */
    public function shiftServices(): HasMany
    {
        return $this->hasMany(SeanceService::class, 'shift_id', 'shift_id');
    }

    /**
     * Напитки смены
     *
     * @return HasMany
     */
    public function shiftBar(): HasMany
    {
        return $this->hasMany(SeanceBar::class, 'shift_id', 'shift_id');
    }


    /**
     * Программы смены
     *
     * @return Collection
     */
    public function getProgramsAttribute(): Collection
    {
        return SeanceProgram::query()->where('shift_id', $this->shift_id)
            ->get();
    }

    /**
     * Услуги смены
     *
     * @return Collection
     */
    public function getServicesAttribute()
    {
        return SeanceService::query()->whereBetween('created_at', [
            Carbon::parse($this->title)->startOfDay()->addHours(ShiftHelper::SHIFT_CHANGE_HOUR),
            Carbon::parse($this->title)->startOfDay()->addHours(ShiftHelper::SHIFT_CHANGE_HOUR)->addDay(),
        ])
            ->get();
    }

    /**
     * Напитки смены
     *
     * @return Collection
     */
    public function getBarAttribute()
    {
        return SeanceBar::query()->whereBetween('created_at', [
            Carbon::parse($this->title)->startOfDay()->addHours(ShiftHelper::SHIFT_CHANGE_HOUR),
            Carbon::parse($this->title)->startOfDay()->addHours(ShiftHelper::SHIFT_CHANGE_HOUR)->addDay(),
        ])
            ->get();
    }

    /**
     * Детализация зарплаты администратора смены
     *
     * @return int
     */
    public function getAdminProfitAttribute(): int
    {
        $profit = 0;

        foreach ($this->programs as $program) {
            $profit += $program->admin_profit;
        }

        foreach ($this->services as $service) {
            $profit += $service->admin_profit;
        }

        foreach ($this->bar as $item) {
            $profit += $item->admin_profit;
        }

        return $profit;
    }

    /**
     * Детализация зарплаты мсастеров в смене
     *
     * @return array
     */
    public function getMastersProfitsAttribute(): array
    {
        $profits = [];

        foreach ($this->programs as $program) {
            if (!key_exists($program->master_id, $profits)) {
                $profits[$program->master_id] = [
                    'name' => $program->master->name,
                    'profit' => 0,
                ];
            }
            $profits[$program->master_id]['profit'] += $program->master_profit;
        }

        foreach ($this->services as $service) {
            if (!key_exists($service->master_id, $profits)) {
                $profits[$service->master_id] = [
                    'name' => $service->master->name,
                    'profit' => 0,
                ];
            }
            $profits[$service->master_id]['profit'] += $service->master_profit;
        }

        return $profits;
    }


    protected $with = [
        'openedAdmin',
        'closedAdmin',
        'shiftPrograms',
        'shiftServices',
        'shiftBar'
    ];

    protected $appends = [
        'programs',
        'services',
        'bar',
        'admin_profit',
        'masters_profits',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'shift_id', 'title', 'opened_admin_id', 'closed_admin_id', 'opened_time', 'closed_time', 'note', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
