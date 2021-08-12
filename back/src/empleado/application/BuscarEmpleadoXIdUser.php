<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\domain\validator\IdHandler;

final class BuscarEmpleadoXIdUser
{
    private IEmpleadosRepository $repository;

    function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke(int $idUser)
    {
        $empleado = new EmpleadoEntity();
        $empleado->setId($idUser);

        $idHandler = new IdHandler();
        $idHandler->handle($empleado);

        $empleados = $this->repository->showXIdUser($idUser);

        return $empleados->toArray();
    }
}
