<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Exception;
use src\empleado\domain\contracts\IEmpleadoEntity;

class UserIdHandler extends AbstractHandler
{
    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if (empty($iEmpleadoEntity->getUserId())) {
            throw new Exception('Campo UserId requerido');
        } elseif (!is_int($iEmpleadoEntity->getUserId())) {
            throw new Exception('Campo UserId debe ser integer'.$iEmpleadoEntity->getUserId());
        } else {
            return parent::handle($iEmpleadoEntity);
        }
    }
}
