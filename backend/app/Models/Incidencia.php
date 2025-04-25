<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'empleado_id',
        'concepto_id',
        'cantidad',
        'fecha',
        'tipo_incidencia',
        'periodo',
        'hora_entrada',
        'hora_salida',
        'observaciones',
        'estado',
        'last_modified_by',
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
        'cantidad' => 'decimal:2',
    ];
    
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
    
    public function concepto()
    {
        return $this->belongsTo(Concepto::class);
    }
}
