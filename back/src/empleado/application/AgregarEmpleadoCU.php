<?php

declare(strict_types=1);

namespace Src\empleado\application;

use Src\empleado\domain\contracts\IEmpleadosRepository;
use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\domain\validator\ApellidoHandler;
use Src\empleado\domain\validator\ConstraintHandler;
use Src\empleado\domain\validator\EmailHandler;
use Src\empleado\domain\validator\NombreHandler;
use Src\empleado\domain\validator\UserIdHandler;
use Src\empleado\infrastructure\EmpleadoEmailLaravel;

final class AgregarEmpleadoCU
{
    private $repository;

    public function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->repository = $iEmpleadosRepository;
    }

    public function __invoke(EmpleadoEntity $empleadoEntity): void
    {
        $userIdHandler = new UserIdHandler();
        $apellidoHandler = new ApellidoHandler();
        $nombreHandler = new NombreHandler();
        $emailHandler = new EmailHandler();
        $constraintHandler = new ConstraintHandler($this->repository);
        $userIdHandler            
            ->setNext($nombreHandler)
            ->setNext($apellidoHandler)
            ->setNext($emailHandler)
            ->setNext($constraintHandler)
            ->handle($empleadoEntity);

        try {
            // $this->repository->BeginTransaction();
            // $empleadoId =  $this->repository->store($empleadoEntity);
            // if ($empleadoId != 0) {
            //     $empleadoMail = new EmpleadoEmailLaravel();
            //     $empleadoMail($empleadoId);
            // }
            // $this->repository->CommitTransacction();
        } catch (\Throwable $th) {
            $this->repository->RollbackTransaction();
            throw $th;
        }
    }
}
