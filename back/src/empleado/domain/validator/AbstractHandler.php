<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Src\empleado\domain\contracts\Handler;
use src\empleado\domain\contracts\IEmpleadoEntity;

abstract class AbstractHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($iEmpleadoEntity);
        }
        return null;
    }
}
