<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{

    use HasFactory;

    // Relación muchos a muchos con el modelo Patient a través de la tabla appointments
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'appointments')
                    ->withPivot('date_time', 'reason', 'notes') // Aseguramos que los campos de la tabla intermedia estén disponibles
                    ->withTimestamps(); // Esto agrega automáticamente created_at y updated_at en la tabla intermedia
    }
    
}
