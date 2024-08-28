<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comp_Proveedores_EmpresasModel extends Model
{
    use HasFactory;
    protected $table = 'comp_proveedores_empresas';
    protected $primaryKey = 'id_proveedor_empresa'; 

    protected $fillable = [
        //'id_proveedor_empresa',
        'id_proveedor',
        'id_empresa',
        'solicitado',
        'usuario_solicitante',
        'fecha_solicitud',
        'migrado',
        'usuario_migracion',
        'fecha_migracion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    public static function MigrarProveedorProfit($bd, $codigo, $nombre, $segmento, $zona, $direccion, $telefonos, $responsable, $fecha, $tipo, $rif, $nacional,
                                                 $nit, $correo, $comentario, $ruc, $lae, $cod_actividad, $pago1, $pago2, $pago3, $pago4, $tipo_prov, $tipo_persona,
                                                 $pais, $ciudad, $codigo_postal, $website, $porc_retencion, $cont_especial   )
    {
        if($nacional == 'SI')
        {
            $nacional = 1;
        }
        else
            {
                $nacional = 0;
            }

        if($cont_especial == 'SI') 
        {
            $cont_especial = 1;
        }
        else
            {
                $cont_especial = 0;
            }

        if($cod_actividad == NULL)
        {
            $cod_actividad = " ";
        }

        if($codigo_postal == NULL)
        {
            $codigo_postal = " ";
        }

        if($website == NULL)
        {
            $website = " ";
        }

        


        DB::connection('profit')
            ->table($bd.'.dbo.prov')
            ->updateOrInsert(
                ['co_prov' => $codigo],
                [
                'co_prov' => $codigo,
                'prov_des' => $nombre,
                'co_seg' => $segmento,
                'co_zon' => $zona,
                //'inactivo',
                //'productos',
                'direc1' => $direccion,
                //'direc2',
                'telefonos' => $telefonos,
                // 'fax',
                'respons' => $responsable,
                'fecha_reg' => $fecha,
                'tipo' => $tipo,
                'com_ult_co' => 0,
                //'fec_ult_co',
                'net_ult_co' => 0,
                'saldo' => 0,
                'saldo_ini' => 0,
                'mont_cre' => 0,
                'plaz_pag' => 0,
                'desc_ppago' => 0,
                'desc_glob' => 0,
                //'tipo_iva',
                'iva' => 0,
                'rif' => $rif,
                'nacional' => $nacional,
                //'dis_cen',
                'nit' => $nit,
                'email' => $correo,
                'co_ingr' => '00000',
                'comentario' => $comentario,
                'campo1' => $ruc,
                'campo2' => $lae,
                'campo3' => $cod_actividad,
                //'campo4',
                'campo5' => $pago1,
                'campo6' => $pago2,
                'campo7' => $pago3,
                'campo8' => $pago4,
                'co_us_in' => 999,
                //'fe_us_in',
                //'co_us_mo',
                //'fe_us_mo',
                //'co_us_el',
                //'fe_us_el',
                //'revisado',
                //'trasnfe',
                'co_sucu' => '000001',
                //'rowguid',
                'juridico' => 0,
                'tipo_adi' => $tipo_prov,
                //'matriz',
                'co_tab' => $tipo_persona,
                'tipo_per' => $tipo_persona,
                'co_pais' => $pais,
                'ciudad' => $ciudad,
                'zip' => $codigo_postal,
                'website' => $website,
                //'formtype',
                //'taxid',
                'porc_esp' => $porc_retencion,
                'contribu_e' => $cont_especial
                ]);
    }

        //funcion que muestra el estatus de migracion de un Proveedor
        public static function EstatusProveedorMigracion($IdProveedor, $IdEmpresa)
        {
            return DB::table('comp_proveedores_empresas')
                        ->select(
                                'usuario_migracion',
                                'migrado', 
                                'fecha_migracion'
                                )
                        ->where('id_proveedor', $IdProveedor)
                        ->where('id_empresa', $IdEmpresa)
                        ->first();
        }

}
