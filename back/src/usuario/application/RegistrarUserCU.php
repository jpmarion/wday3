<?php

declare(strict_types=1);

namespace Src\usuario\application;

use Src\usuario\domain\contracts\IUsuarioEntity;
use Src\usuario\domain\contracts\IUsuarioRepository;
use Src\usuario\domain\validator\EmailHandler;
use Src\usuario\domain\validator\IdHandler;
use Src\usuario\domain\validator\PasswordHandler;
use Src\usuario\infrastructure\UsuarioEmailLaravel;

final class RegistrarUserCU
{
    const ADMINISTRADOR = 1;

    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $iUsuarioRepository)
    {
        $this->repository = $iUsuarioRepository;
    }

    public function __invoke(IUsuarioEntity $iUsuarioEntity)
    {
        $idHandler = new IdHandler();
        $emailHandler = new EmailHandler();
        $passwordHandler = new PasswordHandler();
        $idHandler
            ->setNext($emailHandler)
            ->setNext($passwordHandler)
            ->handle($iUsuarioEntity);

        try {
            $this->repository->BeginTransaction();
            $userId = $this->repository->store($iUsuarioEntity, self::ADMINISTRADOR);
            $email = new UsuarioEmailLaravel();
            $email($userId);
            $this->repository->CommitTransacction();
        } catch (\Throwable $th) {
            $this->repository->RollbackTransaction();
            throw $th;
        }
    }
}
