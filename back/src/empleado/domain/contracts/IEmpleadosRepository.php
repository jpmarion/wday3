<?php

namespace Src\empleado\domain\contracts;

use Src\empleado\domain\EmpleadoCollection;
use Src\empleado\domain\EmpleadoEntity;

interface IEmpleadosRepository
{
    public function index(): EmpleadoCollection;
    public function store(EmpleadoEntity $empleado): int;
    public function show(int $id): EmpleadoEntity;
    public function showXIdUser(int $idUser): EmpleadoCollection;
    public function update(EmpleadoEntity $empleado): void;
    public function delete(int $id): void;
    public function ExisteUsuarioRole(string $email, int $userIdEmpresa): bool;
    public function BeginTransaction();
    public function CommitTransacction();
    public function RollbackTransaction();
}
