<?php

declare(strict_types=1);

namespace Src\empleado\domain\validator;

use Exception;
use src\empleado\domain\contracts\IEmpleadoEntity;
use Src\empleado\domain\contracts\IEmpleadosRepository;

final class ConstraintHandler extends AbstractHandler
{
    private $repository;

    public function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;    
    }

    public function handle(IEmpleadoEntity $iEmpleadoEntity): ?IEmpleadoEntity
    {
        if ($this->ValidarConstraint($iEmpleadoEntity)) {
            throw new Exception("Empleado existente");
        } else {
            return parent::handle($iEmpleadoEntity);
        }
    }

    private function ValidarConstraint(IEmpleadoEntity $iEmpleadoEntity): bool
    {
        return $this->repository->ExisteUsuarioRole($iEmpleadoEntity->getEmail(), $iEmpleadoEntity->getUserId());
    }
}
