<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Empleado",
 *     title="Empleado",
 *     description="Empleado representation",
 *     @OA\Property(type="integer", property="id", description="Id del empleado"),
 *     @OA\Property(type="string", property="apellido", description="Apellido del empleado"),
 *     @OA\Property(type="string", property="nombre", description="Nombre del empleado"),
 *     @OA\Property(type="object", property="user", ref="#/components/schemas/User")
 * )
 *
 */

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'users';

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
