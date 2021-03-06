<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Representación del usuario",
 *     @OA\Property(type="integer", property="id", description="Id del usuario"),
 *     @OA\Property(type="string", property="name", description="Nombre del usuario"),
 *     @OA\Property(type="string", property="email", format="email", description="Email del usuario"),
 *     @OA\Property(type="string", format="date-time", property="email_verified_at", description="Cuando el usuario verifica su email", nullable=true),
 *     @OA\Property(type="boolean", property="active", description="Si usuario se encuentra activo"),
 *     @OA\Property(type="array", property="empleados",
 *          @OA\Items(
 *              type="object", ref="#/components/schemas/Empleado"
 *          )
 *      )
 * )
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    const ADMINSTRADOR = 1;
    const EMPLEADO = 2;

    protected $dates = ['deleted_at'];
    // protected $with = ['roles'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'apellido',
        'password',
        'active',
        'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('user_id_empresa')->withTimestamps();
    }

    public function esAdmin(): bool
    {
        $es_admin = false;
        if ($this->roles()->find(self::ADMINSTRADOR)) {
            $es_admin = true;
        }
        return $es_admin;
    }

    public function esEmpleado(): bool
    {
        $es_empleado = false;
        if ($this->roles()->find(self::EMPLEADO)) {
            $es_empleado = true;
        }
        return $es_empleado;
    }
}
