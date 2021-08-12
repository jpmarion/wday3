<?php

declare(strict_types=1);

namespace Src\usuario\application;

use Src\usuario\domain\contracts\IUsuarioEntity;
use Src\usuario\domain\contracts\IUsuarioRepository;
use Src\usuario\domain\validator\EmailHandler;
use Src\usuario\domain\validator\PasswordHandler;

final class LoginUserCU
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $iUsuarioRepository)
    {
        $this->repository = $iUsuarioRepository;
    }

    public function __invoke(IUsuarioEntity $iUsuarioEntity)
    {
        $emailHandler = new EmailHandler();
        $passwordHandler = new PasswordHandler();
        $emailHandler
            ->setNext($passwordHandler)
            ->handle($iUsuarioEntity);
    }
}
