<?php

declare(strict_types=1);

namespace Src\empleado\infrastructure;

use App\Models\Empleado;
use App\Models\Role;
use App\Models\User;
use ArrayObject;
use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoCollection;
use Src\empleado\domain\EmpleadoEntity;

final class EmpleadoEloquentRepo implements IEmpleadosRepository
{
    const EMPLEADO = 2;

    public function __construct()
    {
    }

    public function index(): EmpleadoCollection
    {
        $empleadoORM = User::whereHas('roles', function ($query) {
            $query->where('roles.id', self::EMPLEADO);
        })->get();

        $empleadoArrayObject = new ArrayObject();
        foreach ($empleadoORM as $empleado) {
            $empleadoNew = new EmpleadoEntity();
            $empleadoNew->setId($empleado->id);
            $empleadoNew->setApellido($empleado->apellido);
            $empleadoNew->setNombre($empleado->name);
            $empleadoNew->setUserId($empleado->user_id);
            $empleadoNew->setEmail($empleado->email);

            $empleadoArrayObject->append($empleadoNew);
        }

        $empleadoCollection = new EmpleadoCollection($empleadoArrayObject);

        return $empleadoCollection;
    }

    public function store(EmpleadoEntity $empleado): void
    {

        $empleadoFind = User::where('email', $empleado->getEmail())->first();
        if (!empty($empleadoFind)) {
            $empleadoFind->apellido = $empleado->getApellido();
            $empleadoFind->name = $empleado->getNombre();
            $empleadoFind->user_id = $empleado->getUserId();
            $empleadoFind->save();

            $role = Role::find(self::EMPLEADO);
            $empleadoFind->roles()->save($role);
        } else {
            $empleadoStore = new User();
            $empleadoStore->apellido = $empleado->getApellido();
            $empleadoStore->name = $empleado->getNombre();
            $empleadoStore->user_id = $empleado->getUserId();
            $empleadoStore->save();

            $role = Role::find(self::EMPLEADO);
            $empleadoStore->roles()->save($role);
        }
    }

    public function show(int $id): EmpleadoEntity
    {
        $empleadoORM = User::whereHas('roles', function ($query) use ($id) {
            $query->where('roles.id', self::EMPLEADO)
                ->where('users.id', $id);
        })->firstOrFail();
        $empleado = new EmpleadoEntity();

        if ($empleadoORM->esEmpleado()) {
            $empleado->setId($empleadoORM->id);
            $empleado->setApellido($empleadoORM->apellido);
            $empleado->setNombre($empleadoORM->name);
            $empleado->setEmail($empleadoORM->email);
            $empleado->setUserId($empleadoORM->user_id);
        }

        return $empleado;
    }

    public function update(EmpleadoEntity $empleado): void
    {
        $id = $empleado->getId();
        $empleadoUpdate = User::whereHas('roles', function ($query) use ($id) {
            $query->where('roles.id', self::EMPLEADO)
                ->where('users.id', $id);
        })->firstOrFail();

        if ($empleadoUpdate->esEmpleado()) {
            $empleadoUpdate->apellido = $empleado->getApellido();
            $empleadoUpdate->name = $empleado->getNombre();
            $empleadoUpdate->save();
        }
    }

    public function delete(int $id): void
    {
        $empleadoDelete = User::whereHas('roles', function ($query) use ($id) {
            $query->where('roles.id', self::EMPLEADO)
                ->where('users.id', $id);
        })->firstOrFail();

        $empleadoDelete->roles()->detach(self::EMPLEADO);
    }
}
