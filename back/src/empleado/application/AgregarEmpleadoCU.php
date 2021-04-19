<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\domain\validator\ApellidoHandler;
use Src\empleado\domain\validator\NombreHandler;
use Src\empleado\domain\validator\UserIdHandler;
use Src\empleado\infrastructure\EmpleadoEloquentRepo;

final class AgregarEmpleadoCU
{

    public function __construct()
    {
    }

    public function __invoke(EmpleadoEntity $empleadoEntity): void
    {
        $userIdHandler = new UserIdHandler();
        $apellidoHandler = new ApellidoHandler();
        $nombreHandler = new NombreHandler();
        $userIdHandler
            ->setNext($nombreHandler)
            ->setNext($apellidoHandler)
            ->handle($empleadoEntity);

        $empleadoEloquentRepo = new EmpleadoEloquentRepo();
        $empleadoEloquentRepo->store($empleadoEntity);
    }
}
