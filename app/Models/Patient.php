<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    use HasFactory;

    // Relación muchos a muchos con el modelo Doctor a través de la tabla appointments
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'appointments')
                    ->withPivot('date_time', 'reason', 'notes')
                    ->withTimestamps();
    }
}
