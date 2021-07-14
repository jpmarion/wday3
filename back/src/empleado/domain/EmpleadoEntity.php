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
    private string $email;

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
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'apellido' => $this->getApellido(),
            'nombre' => $this->getNombre(),
            'email' => $this->getEmail()
        ];
    }

    /**
     * Get the value of userId
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
