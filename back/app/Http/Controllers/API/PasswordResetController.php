<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetCreateRequest;
use App\Http\Requests\PasswordResetResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/password/create",
     *      tags={"PasswordResetController"},
     *      summary="Solicitar reset contraseña",
     *      operationId="createPasswordResetController",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PasswordResetCreateRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Usuario creado",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Solicitud no válida"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error validación"
     *      )
     *)
     */
    public function create(PasswordResetCreateRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return  response()->json(['msg' => 'No pondemos encontrar un usuario con el email ingresado.'], 404);
        }
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => bcrypt($user->email)
            ]
        );
        if ($user && $passwordReset) {
            $user->notify(new PasswordResetRequest($passwordReset->token));
            return response()->json(['msg' => '¡Hemos enviado un correo electrónico con el enlace de restablecimiento de contraseña!']);
        }
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            response()->json(['msg' => 'Este token de restablecimiento de contraseña no es válido.']);
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json(['msg' => 'Este token de restablecimiento de contraseña no es válido.'], 404);
        }
        return response()->json($passwordReset);
    }

    public function reset(PasswordResetResetRequest $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)->first();
        if (!$passwordReset) {
            return response()->json([
                'msg' => 'Este token de restablecimiento de contraseña no es válido'
            ], 404);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(
                [
                    'msg' => 'No podemos encontrar un usuario con esa dirección de correo electrónico'
                ],
                404
            );
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess ($passwordReset));
        return response()->json($user);
    }
}
