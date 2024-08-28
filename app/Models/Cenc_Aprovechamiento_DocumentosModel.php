<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_Aprovechamiento_DocumentosModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_aprovechamiento_documentos';
    protected $primaryKey = 'id_aprovechamiento_documento';

    protected $fillable =  [
        'id_aprovechamiento_documento',
        'id_aprovechamiento',
        'nombre_documento',
        'ubicacion_documento',
        'tipo_documento',
    ];

    public static function obtenerIdaprovechamientoDocumento($idaprovechamiento)
    {
        return DB::table('cenc_aprovechamiento_documentos as cd')
        ->join('cenc_aprovechamientos as cc','cd.id_aprovechamiento','=','cc.id_aprovechamiento')
            ->select('cd.id_aprovechamiento_documento')
            ->where('cd.id_aprovechamiento','=',$idaprovechamiento)
            ->value('cd.id_aprovechamiento_documento');
    }

    public static function obtenerAprovechamientoDocumentos($idaprovechamiento)
    {
        return DB::table('cenc_aprovechamiento_documentos as cd')
        ->join('cenc_aprovechamientos as cc','cd.id_aprovechamiento','=','cc.id_aprovechamiento')
            ->select(
                    'cd.id_aprovechamiento_documento',
                    'cd.nombre_documento',
                    'cd.ubicacion_documento',
                    'cd.tipo_documento'
                    )
            ->where('cd.id_aprovechamiento','=',$idaprovechamiento)
            ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
