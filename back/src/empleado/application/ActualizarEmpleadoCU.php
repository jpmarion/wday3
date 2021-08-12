<?php

declare(strict_types=1);

namespace Src\empleado\application;

use src\empleado\domain\contracts\IEmpleadoEntity;
use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\validator\ApellidoHandler;
use Src\empleado\domain\validator\IdHandler;
use Src\empleado\domain\validator\NombreHandler;

final class ActualizarEmpleadoCU
{
    private IEmpleadosRepository $repository;

    function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke(IEmpleadoEntity $iEmpleadoEntity)
    {
        $idHandler = new IdHandler();
        $apellidoHandler = new ApellidoHandler();
        $nombreHandler = new NombreHandler();
        $idHandler->setNext($apellidoHandler)
            ->setNext($nombreHandler)
            ->handle($iEmpleadoEntity);        

        $this->repository->update($iEmpleadoEntity);
    }
}
