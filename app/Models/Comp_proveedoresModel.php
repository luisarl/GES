<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_ProveedoresModel extends Model
{
    use HasFactory;

    protected $table = 'comp_proveedores';
    protected $primaryKey = 'id_proveedor'; 

    protected $fillable = [
        'id_proveedor',
        'codigo_proveedor',
        'nombre_proveedor',
        'nit',
        'rif',
        'correo',
        'activo',
        'direccion',
        'responsable',
        'nacional',
        'ciudad',
        'codigo_postal',
        'telefonos',
        'website',
        'ruc',
        'lae',
        'pago1',
        'pago2',
        'pago3',
        'pago4',
        'codigo_actividad',
        'tipo_persona',
        'cont_especial',
        'porc_retencion',
        'comentario',
        'documento',
        'creado_por',
        'actualizado_por',
        'estatus',
        'id_tipo',
        'id_segmento',
        'id_zona',
        'id_pais' 
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    //Relacion de zona
    public function zona()
    {
        return $this->belongsTo(Comp_ZonasModel::class, 'id_zona');
    }
    //Relacion de pais
    public function pais()
    {
        return $this->belongsTo(PaisesModel::class, 'id_pais');
    }
    //Relacion de tipo proveedor
    public function tiposProveedores()
    {
        return $this->belongsTo(Comp_Tipo_ProveedorModel::class, 'id_tipo');
    }
    //Relacion de segmento
    public function segmento()
    {
        return $this->belongsTo(Comp_SegmentoProveedorModel::class, 'id_segmento');
    }
    //Relacion de muchos a muchos entre proveedores y empresas
    // public function empresas()
    // {
    //     return $this->belongsToMany(Model::class,'id_proveedor_empresa','id_empresa','id_proveedores');
    // }
}
