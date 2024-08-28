<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Departamento;
use App\Models\DepartamentosModel;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DepartamentosModel::create([
            'id_departamento' => 1,
            'nombre_departamento' => 'Gerencia Sistemas',
            'responsable' => 'Luis Romero',
        ]);
    }
}
