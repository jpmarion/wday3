<?php

declare(strict_types=1);

namespace Src\usuario\infrastructure;

use App\Models\User;
use App\Notifications\SignupActivate;

final class UsuarioEmailLaravel
{
    public function __construct()
    {
    }

    public function __invoke(int $id): void
    {
        $user = User::findOrFail($id);        
        $user->notify(new SignupActivate($user));
    }
}
