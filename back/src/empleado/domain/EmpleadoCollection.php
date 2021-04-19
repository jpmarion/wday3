<?php

declare(strict_types=1);

namespace Src\empleado\domain;

use ArrayObject;

final class EmpleadoCollection extends ArrayObject
{
    public function __construct(EmpleadoEntity ...$empleadoEntity)
    {
        parent::__construct($empleadoEntity);
    }

    public function append($value)
    {
        if ($value instanceof EmpleadoEntity) {
            parent::append($value);
        } else {
            throw new Exception("No se puede agregar una persona que no sea un", __CLASS__);
        }
    }

    public function offsetSet($index, $newval)
    {
        if ($newval instanceof EmpleadoEntity) {
            parent::offsetSet($index, $newval);
        } else {
            throw new Exception("No se puede agregar una persona que no sea un", __CLASS__);
        }
    }
}
