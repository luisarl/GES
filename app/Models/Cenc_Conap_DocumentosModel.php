<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_Conap_DocumentosModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_conaps_documentos';
    protected $primaryKey = 'id_conap_documento';

    protected $fillable =  [
        'id_conap_documento',
        'id_conap',
        'nombre_documento',
        'ubicacion_documento',
        'tipo_documento',
    ];

    public static function obtenerIdConapDocumento($idconap)
    {
        return DB::table('cenc_conaps_documentos as cd')
        ->join('cenc_conaps as cc','cd.id_conap','=','cc.id_conap')
            ->select('cd.id_conap_documento')
            ->where('cd.id_conap','=',$idconap)
            ->value('cd.id_conap_documento');
    }

    public static function obtenerConapDocumentos($idconap)
    {
        return DB::table('cenc_conaps_documentos as cd')
        ->join('cenc_conaps as cc','cd.id_conap','=','cc.id_conap')
            ->select('cd.id_conap_documento',
                     'cd.nombre_documento',
                     'cd.ubicacion_documento',
                     'cd.tipo_documento',
                     )
            ->where('cd.id_conap','=',$idconap)
            ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
