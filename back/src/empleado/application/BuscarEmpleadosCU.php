<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\contracts\IEmpleadosRepository;

final class BuscarEmpleadosCU
{
    private IEmpleadosRepository $repository;

    function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke()
    {
        $empleados = $this->repository->index();
        
        return $empleados->toArray();
    }
}
