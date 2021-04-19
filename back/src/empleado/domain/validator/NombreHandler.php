<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Exception;
use Src\empleado\domain\contracts\IEmpleadoEntity;

class NombreHandler extends AbstractHandler
{
    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if (empty($iEmpleadoEntity->getNombre())) {
            throw new Exception('Campo nombre requerido');
        }else{
            return parent::handle($iEmpleadoEntity);
        }
    }
}
