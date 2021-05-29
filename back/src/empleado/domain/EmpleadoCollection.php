<?php

declare(strict_types=1);

namespace Src\empleado\domain;

use ArrayObject;

final class EmpleadoCollection
{

    private ArrayObject $empleados;

    public function __construct(ArrayObject $empleados)
    {
        $this->empleados = $empleados;
    }

    public function toArray()
    {
        $itarator = $this->empleados->getIterator();        
        $empleadosArray = array();
        foreach ($itarator as $key => $value) {        
            array_push($empleadosArray, $value->toArray());
        }    
        return $empleadosArray;
    }
}
