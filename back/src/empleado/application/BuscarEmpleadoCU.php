<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\domain\shared\ObjetoA;

final class BuscarEmpleadoCU
{
    private IEmpleadosRepository $repository;
    public function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke(int $id)
    {
        $empleado =  $this->repository->show($id);

        return $empleado->toArray();
    }
}
