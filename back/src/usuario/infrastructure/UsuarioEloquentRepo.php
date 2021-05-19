<?php

declare(strict_types=1);

namespace Src\usuario\infrastructure;

use App\Models\Role;
use App\Models\User;
use Src\usuario\domain\contracts\IUsuarioEntity;
use Src\usuario\domain\contracts\IUsuarioRepository;

final class UsuarioEloquentRepo implements IUsuarioRepository
{
    public function __construct()
    {
    }

    public function store(IUsuarioEntity $iUsuarioEntity, int $idRole): int
    {
        $user = new User([
            'name' => '',
            'email' => $iUsuarioEntity->getEmail(),
            'password' => bcrypt($iUsuarioEntity->getPassword()),
            'activation_token' => bcrypt($iUsuarioEntity->getEmail())
        ]);

        $role = Role::findOrFail($idRole);        
        $user->save();
        $user->roles()->save($role);

        return $user->id;
    }
}
