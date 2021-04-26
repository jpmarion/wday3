<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $request->getId(),
            'apellido' => $request->getApellido(),
            'nombre' => $request->getNombre(),
            'user_id' => $request->getUserId()
        ];
    }
}
