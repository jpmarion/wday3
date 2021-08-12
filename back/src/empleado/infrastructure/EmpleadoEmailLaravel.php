<?php

declare(strict_types=1);

namespace Src\empleado\infrastructure;

use App\Models\User;
use App\Notifications\SignupActivateEmpleado;

final class EmpleadoEmailLaravel
{
    public function __construct()
    {
    }

    public function __invoke(int $id): void
    {        
        $user = User::findOrFail($id);                
        $user->notify(new SignupActivateEmpleado($user));
    }
}
