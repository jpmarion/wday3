<?php

declare(strict_types=1);

namespace Src\usuario\domain\contracts;

use Src\usuario\domain\contracts\IUsuarioEntity;

interface Handler
{
    public function setNext(Handler $handler): Handler;
    public function handle(IUsuarioEntity $iUsuarioEntity): ?IUsuarioEntity;
}
