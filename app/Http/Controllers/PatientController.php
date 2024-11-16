<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Mostrar todos los pacientes
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Mostrar un paciente por ID
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    // Crear un nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());

        return response()->json($patient, 201);
    }

    // Actualizar un paciente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return response()->json($patient);
    }

    // Eliminar un paciente
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
