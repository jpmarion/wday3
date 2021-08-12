<?php

namespace Src\empleado\domain\contracts;

use src\empleado\domain\contracts\IEmpleadoEntity;

interface Handler
{
    public function setNext(Handler $handler): Handler;
    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity;
}
