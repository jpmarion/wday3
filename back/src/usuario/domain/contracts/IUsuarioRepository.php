<?php 

declare(strict_types=1);

namespace Src\usuario\domain\contracts;

use App\Models\User;
use Src\usuario\domain\contracts\IUsuarioEntity;

interface IUsuarioRepository{
    public function store(IUsuarioEntity $iUsuarioEntity, int $idRole):int;
}