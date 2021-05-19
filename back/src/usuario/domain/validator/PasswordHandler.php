<?php

declare(strict_types=1);

namespace Src\usuario\domain\validator;

use Src\usuario\domain\contracts\IUsuarioEntity;

class PasswordHandler extends AbstractHandler{
    public function handle(IUsuarioEntity $iUsuarioEntity): ?IUsuarioEntity
    {
        if (empty($iUsuarioEntity->getPassword())) {
            throw new Exception('Campo Password requerido');
        }else{
            return parent::handle($iUsuarioEntity);
        }
    }
}