<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model {

    use HasFactory, Filterable;


    protected $table         = 'roles';

    protected $primaryKey    = 'id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $with = [
        //
    ];

    protected $appends = [
        //
    ];


    /**
     * Пользователи с ролью
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pivot_user_role')
            ->using(Permissions::class)
            ->as('permissions')
            ->withPivot('percent');
    }


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'id', 'title', 'note',
        'created_at', 'updated_at',
    ];

    protected $hidden = [
        //
    ];

}
