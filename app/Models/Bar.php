<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model {

    use HasFactory, Filterable;


    protected $table         = 'bar';

    protected $primaryKey    = 'item_id';

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
        'item_id', 'title', 'portion', 'price', 'stock', 'note', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];

}
