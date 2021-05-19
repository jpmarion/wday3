<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Exception;
use src\empleado\domain\contracts\IEmpleadoEntity;

final class EmailHandler extends AbstractHandler
{
    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if (empty($iEmpleadoEntity->getEmail())) {
            throw new Exception('El campo Email es requerido');
        } elseif (!filter_var($iEmpleadoEntity->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception('No es um email valido');
        } else {
            return parent::handle($iEmpleadoEntity);
        }
    }
}
