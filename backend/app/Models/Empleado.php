<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'numero_empleado',
        'nombre',
        'departamento',
    ];
    
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
