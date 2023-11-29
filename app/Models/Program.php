<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model {

    use HasFactory, Filterable;


    protected $table         = 'programs';

    protected $primaryKey    = 'program_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $with = [
        //
    ];

    protected $appends = [
        //
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'program_id', 'title', 'type', 'period', 'price', 'note', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];

}
