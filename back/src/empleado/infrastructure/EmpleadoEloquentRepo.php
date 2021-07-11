<?php

declare(strict_types=1);

namespace Src\empleado\infrastructure;

use App\Models\Role;
use App\Models\User;
use ArrayObject;
use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoCollection;
use Src\empleado\domain\EmpleadoEntity;
use Src\shared\EloquentRepo;

final class EmpleadoEloquentRepo extends EloquentRepo implements IEmpleadosRepository
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
            $empleadoNew->setEmail($empleado->email);

            $empleadoArrayObject->append($empleadoNew);
        }

        $empleadoCollection = new EmpleadoCollection($empleadoArrayObject);

        return $empleadoCollection;
    }



    public function store(EmpleadoEntity $empleado): int
    {
        $empleadoId = 0;
        $empleadoFind = User::where('email', $empleado->getEmail())->first();
        if (!empty($empleadoFind->email)) {
            $empleadoFind->apellido = $empleado->getApellido();
            $empleadoFind->name = $empleado->getNombre();
            $role = Role::find(self::EMPLEADO);
            $empleadoFind->roles()->attach($role, ['user_id_empresa' => $empleado->getUserId()]);
            $empleadoFind->save();
        } else {
            $empleadoStore = new User();
            $empleadoStore->apellido = $empleado->getApellido();
            $empleadoStore->name = $empleado->getNombre();
            $empleadoStore->email = $empleado->getEmail();
            $empleadoStore->password = bcrypt($empleado->getApellido());
            $empleadoStore->activation_token = bcrypt($empleado->getEmail());            
            $empleadoStore->save();

            $role = Role::find(self::EMPLEADO);
            $empleadoStore->roles()->attach($role, ['user_id_empresa' => $empleado->getUserId()]);
            $empleadoStore->save();

            $empleadoId = $empleadoStore->id;
        }
        return $empleadoId;
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
        }

        return $empleado;
    }

    public function showXIdUser(int $idUser): EmpleadoCollection
    {
        $empleadoORM = User::whereHas('roles', function ($query) use ($idUser) {
            $query->where('roles.id', self::EMPLEADO)
                ->where('role_user.user_id_empresa', $idUser);
        })->get();

        $empleadoArrayObject = new ArrayObject();
        foreach ($empleadoORM as $empleado) {
            $empleadoNew = new EmpleadoEntity();
            $empleadoNew->setId($empleado->id);
            $empleadoNew->setApellido($empleado->apellido);
            $empleadoNew->setNombre($empleado->name);
            $empleadoNew->setEmail($empleado->email);

            $empleadoArrayObject->append($empleadoNew);
        }

        $empleadoCollection = new EmpleadoCollection($empleadoArrayObject);

        return $empleadoCollection;
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
