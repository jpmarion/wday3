<?php

declare(strict_types=1);

namespace Src\empleado\domain;

use Src\empleado\domain\contracts\IEmpleadoEntity;

final class EmpleadoEntity implements IEmpleadoEntity
{
    private int $id;
    private int $userId;
    private string $apellido;
    private string $nombre;
    private string $error;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of apellido
     */
    public function getApellido(): string
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */
    public function setApellido(string $apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of error
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @return  self
     */
    public function setError(string $error)
    {
        $this->error = $error;
    }
}
