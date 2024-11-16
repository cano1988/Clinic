<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Mostrar todos los doctores
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    // Mostrar un doctor por ID
    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    // Crear un nuevo doctor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
        ]);

        $doctor = Doctor::create($request->all());

        return response()->json($doctor, 201);
    }

    // Actualizar un doctor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());

        return response()->json($doctor);
    }

    // Eliminar un doctor
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
