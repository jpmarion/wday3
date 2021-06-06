<?php

namespace Src\empleado\domain\contracts;

use Src\empleado\domain\EmpleadoCollection;
use Src\empleado\domain\EmpleadoEntity;

interface IEmpleadosRepository
{
    public function index(): EmpleadoCollection;
    public function store(EmpleadoEntity $empleado): int;
    public function show(int $id): EmpleadoEntity;
    public function update(EmpleadoEntity $empleado): void;
}
