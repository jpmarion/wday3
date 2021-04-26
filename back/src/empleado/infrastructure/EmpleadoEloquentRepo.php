<?php

declare(strict_types=1);

namespace Src\empleado\infrastructure;

use App\Models\Empleado;
use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoCollection;
use Src\empleado\domain\EmpleadoEntity;

final class EmpleadoEloquentRepo implements IEmpleadosRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Empleado();
    }

    public function index(): EmpleadoCollection
    {
        $empleadoCollection = new EmpleadoCollection();
        foreach (Empleado::all()->cursor() as $empleado) {
            $empleadoNew = new EmpleadoEntity();
            $empleadoNew->setId($empleado->id);
            $empleadoNew->setApellido($empleado->apellido);
            $empleadoNew->setNombre($empleado->nombre);

            $empleadoCollection->append($empleadoNew);
        }

        return $empleadoCollection;
    }

    public function store(EmpleadoEntity $empleado): void
    {
        $empleadoStore = new Empleado();
        $empleadoStore->apellido = $empleado->getApellido();
        $empleadoStore->nombre = $empleado->getNombre();
        $empleadoStore->user_id = $empleado->getUserId();
        $empleadoStore->save();
    }

    public function show(int $id): EmpleadoEntity
    {
        $empleadoORM =  $this->model->findOrFail($id);
        $empleado = new EmpleadoEntity();
        $empleado->setId($empleadoORM->id);
        $empleado->setApellido($empleadoORM->apellido);
        $empleado->setNombre($empleadoORM->nombre);
        $empleado->setUserId($empleadoORM->user_id);

        return $empleado;
    }

    public function update(EmpleadoEntity $empleado): void
    {
        $empleadoUpdate = Empleado::find($empleado->getId());
        $empleadoUpdate->apellido = $empleado->getApellido();
        $empleadoUpdate->nombre = $empleado->getNombre();
        $empleadoUpdate->save();
    }
}
