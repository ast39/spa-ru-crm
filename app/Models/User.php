<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Enums\RoleType;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable, Filterable;


    protected $table         = 'users';

    protected $primaryKey    = 'id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    public function checkRole(int $role): bool
    {
        return in_array($role, Arr::pluck($this->roles, 'id'));
    }

    protected $with = [
        'roles',
    ];

    protected $appends = [
        //
    ];


    /**
     * Роли пользрвателя
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'pivot_user_role')
            ->using(Permissions::class)
            ->as('permissions')
            ->withPivot('percent_program', 'percent_service', 'percent_bar');
    }


    /**
     * Только руководитель
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnlyOwner($query): mixed
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('role_id', RoleType::Owner->value);
        });
    }

    /**
     * Только администраторы
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnlyAdmins($query): mixed
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('role_id', RoleType::Administrator->value);
        });
    }

    /**
     * Только мастера
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnlyMasters($query): mixed
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('role_id', RoleType::Master->value);
        });
    }


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'password' => 'hashed',
    ];

    protected $fillable = [
        'name', 'login', 'password', 'note',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
