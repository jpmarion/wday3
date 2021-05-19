<?php

declare(strict_types=1);

namespace Src\usuario\domain\validator;

use Exception;
use Src\usuario\domain\contracts\IUsuarioEntity;

class IdHandler extends AbstractHandler
{
    public function handle(IUsuarioEntity $iUsuarioEntity): ?IUsuarioEntity
    {
        if (empty($iUsuarioEntity->getId())) {
            throw new Exception('Campo Id requerido');
        } elseif (!is_int($iUsuarioEntity->getId())) {
            throw new Exception('Campo Id debe ser integer' . $iUsuarioEntity->getId());
        } else {
            return parent::handle($iUsuarioEntity);
        }
    }
}
