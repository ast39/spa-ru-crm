<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Report extends Model {

    use HasFactory, Filterable;


    protected $table         = 'z_reports';

    protected $primaryKey    = 'report_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * Информация о смене
     *
     * @return BelongsTo
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    }


    protected $with = [
        'shift',
    ];

    protected $appends = [
        //
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'report_id', 'shift_id', 'clients', 'cash_profit', 'card_profit', 'phone_profit',
        'programs_profit', 'services_profit', 'bar_profit',
        'admin_profit', 'masters_profit', 'sale_sum', 'owner_profit',
        'expenses', 'stock', 'additional',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
