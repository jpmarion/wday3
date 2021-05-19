<?php

namespace src\empleado\domain\contracts;

interface IEmpleadoEntity
{
    public function getId(): int;
    public function setId(int $id);
    public function getUserId(): int;
    public function setUserId(int $userId);
    public function getApellido(): string;
    public function setApellido(string $apellido);
    public function getNombre(): string;
    public function setNombre(string $nombre);
    public function getEmail():string;
    public function setEmail(string $email);    
}
