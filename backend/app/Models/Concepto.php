<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'codigo',
        'nombre',
        'requiere_cantidad',
        'requiere_tipo_incidencia',
        'requiere_periodo',
        'requiere_entrada_salida',
    ];
    
    protected $casts = [
        'requiere_cantidad' => 'boolean',
        'requiere_tipo_incidencia' => 'boolean',
        'requiere_periodo' => 'boolean',
        'requiere_entrada_salida' => 'boolean',
    ];
    
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
