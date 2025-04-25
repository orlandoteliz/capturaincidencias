<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleados = [
            [
                'numero_empleado' => 'EMP001',
                'nombre' => 'Juan Pérez',
                'departamento' => 'Recursos Humanos',
            ],
            [
                'numero_empleado' => 'EMP002',
                'nombre' => 'María González',
                'departamento' => 'Contabilidad',
            ],
            [
                'numero_empleado' => 'EMP003',
                'nombre' => 'Carlos Rodríguez',
                'departamento' => 'Sistemas',
            ],
            [
                'numero_empleado' => 'EMP004',
                'nombre' => 'Ana Martínez',
                'departamento' => 'Ventas',
            ],
            [
                'numero_empleado' => 'EMP005',
                'nombre' => 'Roberto Sánchez',
                'departamento' => 'Operaciones',
            ],
        ];

        foreach ($empleados as $empleado) {
            \App\Models\Empleado::create($empleado);
        }
    }
}
