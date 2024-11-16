<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Mostrar todas las citas
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();
        return response()->json($appointments);
    }

    // Crear una nueva cita
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

    // Mostrar una cita por ID
    public function show($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);
        return response()->json($appointment);
    }

    // Eliminar una cita
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
