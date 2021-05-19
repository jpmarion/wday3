<?php

declare(strict_types=1);

namespace Src\usuario\domain\contracts;

interface IUsuarioEntity
{
    public function getId(): int;
    public function setId(int $id);
    public function getName(): string;
    public function setName(string $nombre);
    public function getEmail(): string;
    public function setEmail(string $email);
    public function getPassword(): string;
    public function setPassword(string $email);
}
