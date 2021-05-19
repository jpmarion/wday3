<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use App\Models\User;
use Exception;
use src\empleado\domain\contracts\IEmpleadoEntity;
use Src\empleado\infrastructure\EmpleadoEloquentRepo;

final class IdHandler extends AbstractHandler
{
    private User $empleado;

    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if (empty($iEmpleadoEntity->getId())) {
            throw new Exception('El campo Id es requerido');
        // } elseif (!$this->EsEmpleado($iEmpleadoEntity->getId())) {
        //     throw new Exception('El Id no es un empledo');
        } else {
            return parent::handle($iEmpleadoEntity);
        }
    }

    private function EsEmpleado(int $id): bool
    {
        $esEmpleado = false;

        $repository = new EmpleadoEloquentRepo();
        $empleado = $repository->show($id);
        if ($empleado->getId()) {
            $esEmpleado = true;
        }

        return $esEmpleado;
    }
}
