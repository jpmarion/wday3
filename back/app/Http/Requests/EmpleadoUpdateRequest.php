<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'nombre' => 'required',
            'apellido' => 'required'
        ];
    }

    /**
     * @OA\Schema(
     *     schema="EmpleadoUpdateRequest",
     *     title="EmpleadoUpdateRequest",
     *     description="Empleado Update Request",
     *     @OA\Property(type="integer", property="id", description="Id del empleado"),
     *     @OA\Property(type="string", property="nombre", description="Nombre del empleado"),
     *     @OA\Property(type="string", property="apellido", description="Apellido del empleado")
     * )
     */
}
