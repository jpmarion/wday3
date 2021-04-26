<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoStoreRequest;
use App\Http\Resources\EmpleadoResource;
use Exception;
use Illuminate\Http\Request;
use Src\empleado\application\AgregarEmpleadoCU;
use Src\empleado\application\BuscarEmpleadoCU;
use Src\empleado\domain\EmpleadoEntity;
use Src\empleado\infrastructure\EmpleadoEloquentRepo;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/api/empleado",
     *      tags={"EmpleadoController"},
     *      summary="Crear empleado",
     *      operationId="storeEmpleadoController",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EmpleadoStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Empleado creado",
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
    public function store(EmpleadoStoreRequest $request)
    {
        try {
            $empleado = new EmpleadoEntity();
            $empleado->setUserId($request->user_id);
            $empleado->setApellido($request->apellido);
            $empleado->setNombre($request->nombre);

            $repository = new EmpleadoEloquentRepo();

            $agregarEmpleado = new AgregarEmpleadoCU($repository);
            $agregarEmpleado($empleado);
            return response()->json(['msg' => 'Empleado creado con exito'], 201);
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/empleado/{id}",
     *      tags={"EmpleadoController"},
     *      summary="Buscar un empleado",
     *      operationId="empleadoShow",
     *      security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     description="Id del empleado",
     *     required=true,
     *     in="path",
     *       @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Empleado",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Solicitud no válida"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No encontrado"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Error validación"
     *  )
     *)
     */
    public function show($id)
    {
        try {
            $repository = new EmpleadoEloquentRepo();
            $buscarEmpleado = new BuscarEmpleadoCU($repository);
            $empleado = $buscarEmpleado($id);

            return response()->json($empleado, 200);
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
