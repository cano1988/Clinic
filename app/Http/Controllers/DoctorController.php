<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Doctors",
 *     description="Endpoints relacionados con los doctores."
 * )
 */

class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/doctors",
     *     summary="Obtener todos los doctores",
     *     tags={"Doctors"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de doctores",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Doctor"))
     *     )
     * )
     */
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    /**
     * @OA\Get(
     *     path="/doctors/{id}",
     *     summary="Obtener un doctor por ID",
     *     tags={"Doctors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del doctor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    /**
     * @OA\Post(
     *     path="/doctors",
     *     summary="Crear un nuevo doctor",
     *     tags={"Doctors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="specialization", type="string", example="Cardiología")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Doctor creado",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization' => 'required|string|max:255',
        ]);

        $doctor = Doctor::create($request->all());
        return response()->json($doctor, 201);
    }

    /**
     * @OA\Put(
     *     path="/doctors/{id}",
     *     summary="Actualizar un doctor",
     *     tags={"Doctors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del doctor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="specialization", type="string", example="Neurología")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Doctor")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'specialization' => 'required|string|max:255',
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());

        return response()->json($doctor);
    }

    /**
     * @OA\Delete(
     *     path="/doctors/{id}",
     *     summary="Eliminar un doctor",
     *     tags={"Doctors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del doctor a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Doctor deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
