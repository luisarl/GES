<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_TablasConsumoModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_tablas_consumo';
    protected $primaryKey = 'id_tabla_consumo';

    protected $fillable =  [
        'id_tabla_consumo',
        'id_equipo_consumible',
        'espesor',
        'valor'
    ];

    public static function ListaEspesores()
    {
        return DB::table('cenc_tablas_consumo as tc')
        ->join('cenc_equipos_consumibles as ec', 'tc.id_equipo_consumible', '=', 'ec.id_equipo_consumible')
        ->join('cenc_equipos_tecnologias as et', 'ec.id_equipotecnologia', '=', 'et.id_equipotecnologia')
        ->join('cenc_equipos as e', 'et.id_equipo', '=', 'e.id_equipo')
        ->join('cenc_tecnologias as ct', 'et.id_tecnologia', '=', 'ct.id_tecnologia')
        ->select(
            'tc.espesor',
            'e.nombre_equipo',
            'ct.nombre_tecnologia',
            DB::raw('MAX(tc.created_at) as max_created_at'), // Utilizar MAX para obtener la fecha máxima
            DB::raw('MAX(tc.id_tabla_consumo) as id_tabla_consumo') // Utilizar MAX para obtener un id_tabla_consumo arbitrario
        )
        ->groupBy('tc.espesor', 'e.nombre_equipo', 'ct.nombre_tecnologia')
        ->orderBy('max_created_at', 'asc') // Ordenar por la fecha máxima
        ->get();
    }

    // muestra el id_tecnologia_equipo a partir del id_equipo y el id_tecnologia 
    public static function idConsumible($IdEquipoTecnologia) 
    {
        return DB::table('cenc_equipos_consumibles as cec') 
                ->join('cenc_consumibles as cc', 'cec.id_consumible', '=', 'cc.id_consumible')
                ->select(
                    'cec.id_equipo_consumible',
                    'cc.nombre_consumible',
                    'cc.unidad_consumible'
                )
                ->where('cec.id_equipotecnologia', '=', $IdEquipoTecnologia)
                ->get();
    }

        // muestra los parametros con sus respectivos valores  
        public static function parametros2($IdEquipoTecnologia,$espesor) 
        {
            //dd($IdEquipoTecnologia,$espesor);
            return DB::table('cenc_equipos_consumibles as cec') 
                    ->join('cenc_consumibles as cc', 'cec.id_consumible', '=', 'cc.id_consumible')
                    ->join('cenc_tablas_consumo as ctc', 'cec.id_equipo_consumible', '=', 'ctc.id_equipo_consumible')
                    ->select(
                        'ctc.id_tabla_consumo',
                        'cec.id_equipo_consumible',
                        'cc.nombre_consumible',
                        'cc.unidad_consumible',
                        'ctc.espesor', 
                        'ctc.valor'
                    )
                    ->where('cec.id_equipotecnologia', '=', $IdEquipoTecnologia)
                    ->where('ctc.espesor', '=', $espesor)
                    ->get();
        }

    public static function obtenerIdEquipotecnologia($IdEquipoConsumible)
    {
        return DB::table('cenc_equipos_consumibles as cec')
                ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia', '=','cet.id_equipotecnologia')
                ->select(
                    'cet.id_equipotecnologia'
                )
                ->where('cec.id_equipo_consumible','=', $IdEquipoConsumible)
                ->get(); 
    }

    public static function obtenerDatos($idTablaConsumo)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ce.nombre_equipo',
            'ct.nombre_tecnologia'
        )
        ->where('ctc.id_tabla_consumo','=',$idTablaConsumo)
        ->get(); 
    }

    public static function buscarEspesorTablaConsumo($espesor,$tecnologia,$equipo)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.espesor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('ce.id_equipo','=',$equipo)
        ->first(); 
    }

    
    public static function buscarEspesorTablaConsumoE($espesor,$tecnologia,$equipo)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.espesor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('ce.id_equipo','=',$equipo)
        ->groupBy(
            'ctc.espesor'
        )
        ->get(); 
    }


    public static function buscarVelocidadCorte($espesor,$tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','7')
        ->first(); 
    }


    // public static function buscarEspesorTablaConsumoPlasma($espesor,$tecnologia)
    // {
    //     return DB::table('cenc_tablas_consumo as ctc')
    //     ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
    //     ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
    //     ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
    //     ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
    //     ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
    //     ->select(
    //         'ctc.espesor'
    //     )
    //     ->where('ctc.espesor','=',$espesor)
    //     ->where('ct.id_tecnologia','=',$tecnologia)
    //     ->first(); 
    // }


    public static function idTablafiltroAntorcha($espesor,$antorcha){
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->select(
            'ctc.id_tabla_consumo'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ctc.valor','=',$antorcha)
        ->first(); 
    }

    public static function buscarNuevaAntorcha($antorcha)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.valor','>',$antorcha)
        ->where('ctc.id_equipo_consumible','=','14')
        ->limit(1)
        ->first();
    }

    public static function rangodevalores($idTablaconsumo) {
        $fiveRecords = DB::table('cenc_tablas_consumo as ctc')
            ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
            ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
            ->select('ctc.valor', 'ctc.id_equipo_consumible')
            ->where('ctc.id_tabla_consumo', '<', $idTablaconsumo)
            ->orderBy('ctc.id_tabla_consumo', 'desc')
            ->limit(5)
            ->get();
    
        $filteredRecords = $fiveRecords->filter(function ($record) {
            return $record->id_equipo_consumible == 13;
        });
    
        return $filteredRecords;
    }


    // antes de buscar la velocidad corte, debo filtrar segun el juego de antorcha 
    public static function buscarVelocidadCortePlasma($espesor,$tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','13')
        ->first(); 
    }

    public static function buscarRangoFlujo($idTablaconsumo)
    {
        $fiveRecords = DB::table('cenc_tablas_consumo as ctc')
            ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
            ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
            ->select('ctc.valor', 'ctc.id_equipo_consumible')
            ->where('ctc.id_tabla_consumo', '<', $idTablaconsumo)
            ->orderBy('ctc.id_tabla_consumo', 'desc')
            ->limit(5)
            ->get();
    
        $filteredRecords = $fiveRecords->filter(function ($record) {
            return $record->id_equipo_consumible == 12;
        });
    

        return $filteredRecords;
    }
    
    public static function buscarConsumoOxigenoPrecalentando($espesor,$tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','5')
        ->first(); 
    }

    public static function buscarConsumoOxigenoCortando($espesor,$tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','4')
        ->first(); 
    }

    public static function buscarConsumoGas($espesor,$tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ctc.espesor','=',$espesor)
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','6')
        ->first(); 
    }

    public static function TodosEspesoresTablaConsumo($tecnologia)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.espesor'
        )
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->groupBy(
            'ctc.espesor'
        )
        ->get(); 
    }

    public static function BuscarVelocidadTablaConsumo($tecnologia,$espesor)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.valor'
        )
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('c.id_consumible','=','7')
        ->where('ctc.espesor','=',$espesor)
        ->first(); 
    }

    public static function TodosEspesoresTablaConsumoSegunAntorcha($tecnologia,$antorcha)
    {
        return DB::table('cenc_tablas_consumo as ctc')
        ->join('cenc_equipos_consumibles as cec', 'ctc.id_equipo_consumible','=','cec.id_equipo_consumible')
        ->join('cenc_consumibles as c', 'c.id_consumible','=','cec.id_consumible')
        ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia','=','cet.id_equipotecnologia')
        ->join('cenc_equipos as ce', 'cet.id_equipo','=','ce.id_equipo')
        ->join('cenc_tecnologias as ct', 'cet.id_tecnologia','=','ct.id_tecnologia')
        ->select(
            'ctc.espesor'
        )
        ->where('ct.id_tecnologia','=',$tecnologia)
        ->where('ctc.valor','=',$antorcha)
        ->groupBy(
            'ctc.espesor'
        )
        ->get(); 
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
