<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegistrarseRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }

    /**
     * @OA\Schema(
     *     schema="AuthRegistrarseRequest",
     *     title="AuthRegistrarseRequest",
     *     description="Registrarse Request",
     *     @OA\Property(type="string", property="email", format="email", description="Email del usuario"),
     *     @OA\Property(type="string", property="password", format="password", description="Contraseña del usuario"),
     * )
     */
}
