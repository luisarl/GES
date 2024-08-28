<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_Solicitudes_EncuestasModel extends Model
{
    use HasFactory;

    protected $table = 'sols_solicitudes_encuestas';
    protected $primaryKey = 'id_solicitud_encuesta';

    protected $fillable =  [
        'id_solicitud_encuesta',
        'id_solicitud',
        'comentario',
        'id_usuario',
        'correo',
        'tipo_encuesta',
        'fecha',
        'estatus',
        'pregunta1',
        'calificacion_pregunta1',
        'pregunta2',
        'calificacion_pregunta2',
        'pregunta3',
        'calificacion_pregunta3',
        'pregunta4',
        'calificacion_pregunta4',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function VerEncuesta($IdSolicitud, $IdEncuesta)
    {
        return DB::table('sols_solicitudes_encuestas as e')
                ->join('sols_solicitudes as s', 'e.id_solicitud', '=', 's.id_solicitud')
                ->join('users as u', 'e.id_usuario', '=', 'u.id')
                ->select(
                    's.codigo_solicitud',
                    's.creado_por', 
                    's.id_departamento_servicio',
                    's.id_departamento_solicitud',
                    's.asunto_solicitud',
                    'e.id_solicitud_encuesta',
                    'e.id_solicitud',
                    'e.comentario',
                    'e.id_usuario',
                    'u.name as usuario',
                    'e.correo',
                    'e.tipo_encuesta',
                    'e.fecha',
                    'e.estatus',
                    'e.pregunta1',
                    'e.calificacion_pregunta1',
                    'e.pregunta2',
                    'e.calificacion_pregunta2',
                    'e.pregunta3',
                    'e.calificacion_pregunta3',
                    'e.pregunta4',
                    'e.calificacion_pregunta4',
                )
                ->where('e.id_solicitud', '=', $IdSolicitud)
                ->where('e.id_solicitud_encuesta', '=', $IdEncuesta) 
                ->first();   
    } 
    
    public static function VerEncuestaPorTipo($IdSolicitud,$TipoEncuesta)
    {
        return DB::table('sols_solicitudes_encuestas as e')
                ->join('sols_solicitudes as s', 'e.id_solicitud', '=', 's.id_solicitud')
                ->join('users as u', 'e.id_usuario', '=', 'u.id')
                ->select(
                    's.codigo_solicitud',
                    's.creado_por', 
                    's.id_departamento_servicio',
                    's.id_departamento_solicitud',
                    's.asunto_solicitud',
                    'e.id_solicitud_encuesta',
                    'e.id_solicitud',
                    'e.comentario',
                    'e.id_usuario',
                    'u.name as usuario',
                    'e.correo',
                    'e.tipo_encuesta',
                    'e.fecha',
                    'e.estatus',
                    'e.pregunta1',
                    'e.calificacion_pregunta1',
                    'e.pregunta2',
                    'e.calificacion_pregunta2',
                    'e.pregunta3',
                    'e.calificacion_pregunta3',
                    'e.pregunta4',
                    'e.calificacion_pregunta4',
                )
                ->where('e.id_solicitud', '=', $IdSolicitud)
                ->where('e.tipo_encuesta', '=', $TipoEncuesta) 
                ->first();   
    }   
}
