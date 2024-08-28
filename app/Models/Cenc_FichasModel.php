<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_FichasModel extends Model
{
    use HasFactory;
   
    protected $table = 'cenc_fichas';
    protected $primaryKey = 'id_ficha';

    protected $fillable = [
        'id_ficha',
    	'codigo_ficha',
        'nombre_ficha',
        'descripcion_ficha',
        'id_tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaFichas()
    {
        return DB::table('cenc_fichas as f')
        ->join('cenc_fichas_tipos as ft', 'f.id_tipo', '=', 'ft.id_tipo')
                ->select(
                    'f.id_ficha',
                    'f.nombre_ficha',
                    'ft.nombre_tipo'
                )
                ->get();
    }

    public function departamento()
    {
        return $this->belongsTo(DepartamentosModel::class, 'id_departamento');
    }

    public static function obtenerNombre($idFicha)
    {
        return DB::table('cenc_fichas_tipos as cft')
                ->join('cenc_fichas as cf','cft.id_tipo','cf.id_tipo')
                ->select(
                    'cft.nombre_tipo'
                )
                ->where('cf.id_ficha','=',$idFicha)
                ->get(); 
    }

    public static function buscarPeso($idFicha)
    {
            return DB::table('cenc_fichas_valores_caracteristicas as cfvc')
            ->select('cfvc.valor_caracteristica')
            ->where('cfvc.id_caracteristica', function ($query) use ($idFicha){
                $query->select('cfc.id_caracteristica')
                    ->from('cenc_fichas as cf')
                    ->join('cenc_fichas_caracteristicas as cfc', 'cf.id_tipo', '=', 'cfc.id_tipo')
                    ->where('cf.id_ficha', '=', $idFicha)
                    ->where('cfc.nombre_caracteristica', 'LIKE', '%PESO%');
            })
            ->where('cfvc.id_ficha', '=',$idFicha) 
            ->pluck('valor_caracteristica')
            ->first();
    }

    public static function buscarIdListaParte($idListaParte)
    {
        return DB::table('cenc_lista_perfiles as cp')
                ->join('cenc_lista_partes as clp','cp.id_lista_parte','clp.id_lista_parte')
                ->select(
                    'cp.id_ficha'
                )
                ->where('clp.id_lista_parte','=',$idListaParte)
                ->pluck('id_ficha')
                ->first();
    }

    public static function buscarEspesorAlma($idFicha)
    {
            return DB::table('cenc_fichas_valores_caracteristicas as cfvc')
            ->select('cfvc.valor_caracteristica')
            ->where('cfvc.id_caracteristica', function ($query) use ($idFicha){
                $query->select('cfc.id_caracteristica')
                    ->from('cenc_fichas as cf')
                    ->join('cenc_fichas_caracteristicas as cfc', 'cf.id_tipo', '=', 'cfc.id_tipo')
                    ->where('cf.id_ficha', '=', $idFicha)
                    ->where('cfc.nombre_caracteristica', 'LIKE', '%S (MM)%');
            })
            ->where('cfvc.id_ficha', '=',$idFicha) 
            ->pluck('valor_caracteristica')
            ->first();
    }

    public static function buscarEspesorAla($idFicha)
    {
            return DB::table('cenc_fichas_valores_caracteristicas as cfvc')
            ->select('cfvc.valor_caracteristica')
            ->where('cfvc.id_caracteristica', function ($query) use ($idFicha){
                $query->select('cfc.id_caracteristica')
                    ->from('cenc_fichas as cf')
                    ->join('cenc_fichas_caracteristicas as cfc', 'cf.id_tipo', '=', 'cfc.id_tipo')
                    ->where('cf.id_ficha', '=', $idFicha)
                    ->where('cfc.nombre_caracteristica', 'LIKE', '%T (MM)%');
            })
            ->where('cfvc.id_ficha', '=',$idFicha) 
            ->pluck('valor_caracteristica')
            ->first();
    }

    // public function tipo()
    // {
    //     return $this->belongsTo(Actv_TiposModel::class, 'id_tipo');
    // }

    // public function subtipo()
    // {
    //     return $this->belongsTo(Actv_SubTiposModel::class, 'id_subtipo');
    // }
}
