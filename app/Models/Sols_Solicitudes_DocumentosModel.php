<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sols_Solicitudes_DocumentosModel extends Model
{
    use HasFactory;

    protected $table = 'sols_solicitudes_documentos';
    protected $primaryKey = 'id_solicitud_documento';

    protected $fillable =  [
        'id_solicitud_documento',
        'id_solicitud',
        'id_solicitud_detalle',
        'nombre_documento',
        'ubicacion_documento',
        'tipo_documento'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
