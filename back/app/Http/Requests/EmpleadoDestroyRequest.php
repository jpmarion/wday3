<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoDestroyRequest extends FormRequest
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
            'id' => 'required'
        ];
    }

    /**
     * @OA\Schema(
     *     schema="EmpleadoDestroyRequest",
     *     title="EmpleadoDestroyRequest",
     *     description="Empleado Destroy Request",
     *     @OA\Property(type="integer", property="id", description="Id del empleado")
     * )
     */
}
