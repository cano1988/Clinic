<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Patients",
 *     description="Endpoints relacionados con los pacientes."
 * )
 */

class PatientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/patients",
     *     summary="Obtener todos los pacientes",
     *     tags={"Patients"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pacientes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Patient"))
     *     )
     * )
     */
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    /**
     * @OA\Get(
     *     path="/patients/{id}",
     *     summary="Obtener un paciente por ID",
     *     tags={"Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del paciente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     summary="Crear un nuevo paciente",
     *     tags={"Patients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "birth_date"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="medical_history", type="string", example="Paciente con antecedentes de diabetes.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Paciente creado",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'birth_date' => 'required|date',
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());
        return response()->json($patient, 201);
    }

    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     summary="Actualizar un paciente",
     *     tags={"Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del paciente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="medical_history", type="string", example="Paciente con antecedentes de hipertensión.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return response()->json($patient);
    }

    /**
     * @OA\Delete(
     *     path="/patients/{id}",
     *     summary="Eliminar un paciente",
     *     tags={"Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del paciente a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Paciente eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}
