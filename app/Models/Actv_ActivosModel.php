<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actv_ActivosModel extends Model
{
    use HasFactory;
   
    protected $table = 'actv_activos';
    protected $primaryKey = 'id_activo';

    protected $fillable = [
        'id_activo',
    	'codigo_activo',
        'nombre_activo',
        'descripcion_activo',
        'imagen_activo',
        'marca',
        'modelo',
        'serial',
        'ubicacion',
        'id_departamento',
        'id_tipo',
        'id_subtipo',
        'estatus',
        'id_estado',
        'responsable'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaActivos()
    {
        return DB::table('actv_activos as a')
                ->join('departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
                ->join('actv_tipos as t', 't.id_tipo', '=', 'a.id_tipo')
                ->join('actv_subtipos as s', 's.id_subtipo', '=', 'a.id_subtipo')
                ->select(
                    'a.id_activo',
                    'a.codigo_activo',
                    'a.nombre_activo',
                    'a.descripcion_activo',
                    'a.imagen_activo',
                    'a.marca',
                    'a.serial',
                    'a.ubicacion',
                    'a.id_departamento',
                    'd.nombre_departamento',
                    'a.id_tipo',
                    't.nombre_tipo',
                    'a.id_subtipo',
                    'a.estatus',
                    's.nombre_subtipo'
                )
                ->get();
    }

    public function departamento()
    {
        return $this->belongsTo(DepartamentosModel::class, 'id_departamento');
    }

    public function tipo()
    {
        return $this->belongsTo(Actv_TiposModel::class, 'id_tipo');
    }

    public function subtipo()
    {
        return $this->belongsTo(Actv_SubTiposModel::class, 'id_subtipo');
    }

    public function estados()
    {
        return $this->belongsTo(Actv_EstadosModel::class, 'id_estado');
    }






    public static function ListadoActivos()
    {
        return DB::table('actv_activos as a')
                ->join('departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
                ->join('actv_activos_caracteristicas as ac', 'ac.id_activo', '=', 'a.id_activo')
                ->join('actv_caracteristicas as c', 'c.id_caracteristica', '=', 'ac.id_caracteristica')
                ->select(
                    'a.codigo_activo',
                    'a.nombre_activo',
                    'a.serial',
                    'a.marca',
                    'a.responsable',
                    'a.id_departamento',
                    'd.nombre_departamento',
                    'a.estatus',
                )->groupBy(
                    'a.codigo_activo',
                    'a.nombre_activo',
                    'a.serial',
                    'a.marca',
                    'a.responsable',
                    'a.id_departamento',
                    'd.nombre_departamento',
                    'a.estatus',
                )
                ->get();
    }

    public static function ReporteActivos($departamento, $estatus)
    {
         $activos = DB::table('actv_activos as a')
         ->join('departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
         ->join('actv_activos_caracteristicas as ac', 'ac.id_activo', '=', 'a.id_activo')
         ->join('actv_caracteristicas as c', 'c.id_caracteristica', '=', 'ac.id_caracteristica')
         ->select(
             'a.codigo_activo',
             'a.nombre_activo',
             'a.serial',
             'a.marca',
             'a.responsable',
             'a.id_departamento',
             'd.nombre_departamento',
             'a.estatus',           
            )->groupBy(
                'a.codigo_activo',
                'a.nombre_activo',
                'a.serial',
                'a.marca',
                'a.responsable',
                'a.id_departamento',
                'd.nombre_departamento',
                'a.estatus',
            );

            if($estatus != 'TODOS' ) 
            {
                $activos->where('a.estatus', '=', $estatus);
            }

            if($departamento != 'TODOS' ) 
            {
                $activos->where('a.id_departamento', '=', $departamento);
            }

        //$activos->where('a.id_activo', '=', $IdActivo); 

            return  $activos->get();
    }

    public static function ReporteActivosPDF($departamento,$estatus)
    {
        $activos = DB::table('actv_activos as a')
        ->join('departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
        ->join('actv_activos_caracteristicas as ac', 'ac.id_activo', '=', 'a.id_activo')
        ->join('actv_caracteristicas as c', 'c.id_caracteristica', '=', 'ac.id_caracteristica')
        ->select(
            'a.codigo_activo',
            'a.nombre_activo',
            'a.serial',
            'a.marca',
            'a.responsable',
            'a.id_departamento',
            'd.nombre_departamento',
            'a.estatus',
            DB::raw(" 
            CASE WHEN a.id_activo IS NULL
            THEN NULL 
                ELSE 
                    STRING_AGG(CONCAT('<tr> <td>', c.nombre_caracteristica, '</td> <td>', ac.valor_caracteristica, '</td> </tr>'), '')
                END  as caracteristicas                                  
            ")
        )
        ->groupBy(
            'a.id_activo',
            'a.codigo_activo',
            'a.nombre_activo',
            'a.serial',
            'a.marca',
            'a.responsable',
            'a.id_departamento',
            'd.nombre_departamento',
            'a.estatus'
        );
    
    if($estatus != 'TODOS' ) {
        $activos->where('a.estatus', '=', $estatus);
    }
    
    if($departamento != 'TODOS' ) {
        $activos->where('a.id_departamento', '=', $departamento);
    }
    
    return $activos->get();

    }

    public static function ListaImpresoras($IdDepartamento)
    {
        return DB::table('actv_activos as a')
                ->select(
                    'a.id_activo',
                    'a.nombre_activo',
                    'a.ubicacion',
                    'a.id_departamento',  
                )
                ->where('a.nombre_activo', 'like','IMPRESORA%')
                ->where('a.id_departamento','=',$IdDepartamento)
                ->where('a.estatus','=','ACTIVO')
                ->get();
    }

}
