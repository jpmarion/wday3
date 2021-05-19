<?php

declare(strict_types=1);

namespace Src\usuario\domain\validator;

use Exception;
use Src\usuario\domain\contracts\IUsuarioEntity;

class EmailHandler extends AbstractHandler
{
    public function handle(IUsuarioEntity $iUsuarioEntity): ?IUsuarioEntity
    {
        if (empty($iUsuarioEntity->getEmail())) {
            throw new Exception('Campo Email requerido');
        } else {
            return parent::handle($iUsuarioEntity);
        }
    }
}
