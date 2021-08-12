<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Exception;
use src\empleado\domain\contracts\IEmpleadoEntity;

class ApellidoHandler extends AbstractHandler
{
    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if (empty($iEmpleadoEntity->getApellido())) {
            throw new Exception('El campo apellido es requerido');
        } else {
            return parent::handle($iEmpleadoEntity);
        }
    }
}
