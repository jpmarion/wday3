<?php

declare(strict_types=1);

namespace Src\usuario\domain\validator;

use Src\usuario\domain\contracts\Handler;
use Src\usuario\domain\contracts\IUsuarioEntity;

abstract class AbstractHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(IUsuarioEntity $iUsuarioEntity): ?IUsuarioEntity
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($iUsuarioEntity);
        }
        return null;
    }
}
