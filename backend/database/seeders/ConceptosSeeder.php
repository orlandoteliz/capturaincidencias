<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conceptos = [
            [
                'codigo' => 'BONO',
                'nombre' => 'Bono de Productividad',
                'requiere_cantidad' => true,
                'requiere_tipo_incidencia' => false,
                'requiere_periodo' => false,
                'requiere_entrada_salida' => false,
            ],
            [
                'codigo' => '917',
                'nombre' => 'Falta Injustificada',
                'requiere_cantidad' => true,
                'requiere_tipo_incidencia' => true,
                'requiere_periodo' => false,
                'requiere_entrada_salida' => false,
            ],
            [
                'codigo' => '925',
                'nombre' => 'Horas Extras',
                'requiere_cantidad' => false,
                'requiere_tipo_incidencia' => false,
                'requiere_periodo' => false,
                'requiere_entrada_salida' => true,
            ],
            [
                'codigo' => '915',
                'nombre' => 'Concepto con Periodo',
                'requiere_cantidad' => true,
                'requiere_tipo_incidencia' => false,
                'requiere_periodo' => true,
                'requiere_entrada_salida' => false,
            ],
        ];

        foreach ($conceptos as $concepto) {
            \App\Models\Concepto::create($concepto);
        }
    }
}
