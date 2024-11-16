<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="API Documentation", version="1.0")
 * @OA\Tag(
 *     name="Appointments",
 *     description="Endpoints relacionados con las citas médicas."
 * )
 */

class AppointmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/appointments",
     *     summary="Obtener todas las citas",
     *     tags={"Appointments"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de citas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Appointment"))
     *     )
     * )
     */
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();
        return response()->json($appointments);
    }

    /**
     * @OA\Post(
     *     path="/appointments",
     *     summary="Crear una nueva cita",
     *     tags={"Appointments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"doctor_id", "patient_id", "date_time", "reason"},
     *             @OA\Property(property="doctor_id", type="integer", example=1),
     *             @OA\Property(property="patient_id", type="integer", example=1),
     *             @OA\Property(property="date_time", type="string", format="date-time", example="2024-12-01 10:00:00"),
     *             @OA\Property(property="reason", type="string", example="Consulta general"),
     *             @OA\Property(property="notes", type="string", example="Traer resultados de laboratorio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cita creada",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date_time' => 'required|date',
            'reason' => 'required|string',
        ]);

        $appointment = Appointment::create($request->all());
        return response()->json($appointment, 201);
    }

    /**
     * @OA\Get(
     *     path="/appointments/{id}",
     *     summary="Obtener una cita por ID",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la cita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cita encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cita no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);
        return response()->json($appointment);
    }

    /**
     * @OA\Delete(
     *     path="/appointments/{id}",
     *     summary="Eliminar una cita",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la cita a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cita eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Appointment deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cita no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}

