<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\domain\validator\IdHandler;

final class BuscarEmpleadoCU
{
    private IEmpleadosRepository $repository;
    function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke(int $id)
    {        
        $empleado = new EmpleadoEntity();
        $empleado->setId($id);

        $IdHandler = new IdHandler();
        $IdHandler->handle($empleado);

        $empleado =  $this->repository->show($id);

        return $empleado->toArray();
    }
}
