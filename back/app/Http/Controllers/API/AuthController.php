<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegistrarseRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Src\usuario\application\RegistrarUserCU;
use Src\usuario\domain\UsuarioEntity;
use Src\usuario\infrastructure\UsuarioEloquentRepo;

/**
 *  @OA\Info(
 *      description="Backend sistema de gestión de personal",
 *      version="1.0.0",
 *      title="wday3",
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      ),
 *      contact={"email": "totomarion@gmail.com"}
 *  )
 *
 *  @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *  )
 */


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/auth/registrarse",
     *      tags={"AuthController"},
     *      summary="Crear de usuario",
     *      operationId="registrarseAuthController",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthRegistrarseRequest")
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
    public function registrarse(AuthRegistrarseRequest $request)
    {
        try {
            $usuario = new UsuarioEntity();
            $usuario->setEmail($request->email);
            $usuario->setPassword($request->password);

            $usuarioRepo = new UsuarioEloquentRepo();
            $registrarUserCU = new RegistrarUserCU($usuarioRepo);
            $registrarUserCU($usuario);
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      tags={"AuthController"},
     *      summary="Login de usuario",
     *      operationId="loginAuthController",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthLoginRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuario logueado",
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
    public function login(AuthLoginRequest $request)
    {
        $credential = request(['email', 'password']);
        if (!Auth::attempt($credential)) {
            return response()->json(['msg' => 'No autorizado'], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/logout",
     *      tags={"AuthController"},
     *      summary="Logout de usuario",
     *      operationId="logoutAuthController",
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Sesión cerrada",
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
     *          response=404,
     *          description="No encontrado"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error validación"
     *      )
     *  )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['msg' => 'Logout exitoso'], 200);
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return response()->json(['msg' => 'El token de activación es inválido'], 404);
        }

        $user->active = true;
        $user->activation_token = '';
        $user->save();

        return response()->json(['msg' => 'Registro exitoso'], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/user",
     *      tags={"AuthController"},
     *      summary="Datos del usuario",
     *      operationId="userAuthController",
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Usuario",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
     *          response=404,
     *          description="No encontrado"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error validación"
     *      )
     *  )
     */
    public function user(Request $request)
    {
        // return response()->json($request->user());
        return response()->json(new UserResource($request->user()));
    }
}
