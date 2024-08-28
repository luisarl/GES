<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorreosModel extends Model
{
    use HasFactory;

    protected $table = 'correos';
    protected $primaryKey = 'id_correo';

    protected $fillable = [
        'id_correo',
        'modulo',
        'proceso',
    	'correo_destinatario',
		'nombre_destinatario',
        'id_usuario'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha

    public static function UsuariosCorreos(){

        return DB::table('correos as a')
                    ->join('users as u', 'u.id', '=', 'a.id_usuario')
                    ->select(
                        'a.id_correo',
                        'a.id_usuario',
                        'u.name',
                        'a.modulo',
                        'a.proceso',
                        'a.correo_destinatario',
                        'a.nombre_destinatario'
                     )
                     //->where('a.id_usuario', '=', $IdUsuario)
                    ->get();
    }

    public static function FictCorreosDestinatarios($IdUsuario, $IdSolicitante, $Empresas, $Proceso)
    {
       
        switch ($Proceso){
           
            case 'CREAR':
               
                $DepartamentoSolicitante = DB::table('users')->select('id_departamento')->where('id', '=', $IdUsuario)->first(); //Departamento Solicitante
                $CorreosDepartamentoSolicitante = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento)
                                                    ->where('activo', '=', 'SI'); //Correos Del Departamento Solicitante

                $destinatarios =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')
                            ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento) //Responsable departamento
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            ->where('id_usuario', '=', $IdUsuario)
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreosDepartamentoSolicitante)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();            
                
            break;

            case 'APROBAR':
            
                $CorreoAlmacenes = DB::table('empresas')->select('correo_responsable AS email', 'responsable_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del almacenista
                $CorreoSuperiorAlmacenes = DB::table('empresas')->select('correo_superior AS email', 'superior_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del superior almacenista
                
                $DepartamentoSolicitante = DB::table('users')->select('id_departamento')->where('id', '=', $IdUsuario)->first(); //Departamento Solicitante
                $CorreosDepartamentoSolicitante = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento)
                                                    ->where('activo', '=', 'SI'); //Correos Del Departamento Solicitante

                $destinatarios = DB::table('users AS u')
                            ->join('model_has_roles AS r', 'u.id', '=', 'r.model_id')
                            ->select('u.email', 'u.name')
                            ->where('r.role_id', '=', 2) //CORREOS CATALOGADORES
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacenes)
                            ->union($CorreoSuperiorAlmacenes)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            ->where('id_usuario', '=', $IdUsuario)
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreosDepartamentoSolicitante)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();            
                
            break;
            
            case 'EDITAR':
            
                $DepartamentoSolicitante = DB::table('users')->select('id_departamento')->where('id', '=', $IdUsuario)->first(); //Departamento Solicitante
                $CorreosDepartamentoSolicitante = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento)
                                                    ->where('activo', '=', 'SI'); //Correos Del Departamento Solicitante

                $destinatarios =  DB::table('departamentos')
                            ->select('correo as email', 'responsable as name')
                            ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento) //Responsable departamento
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            ->where('id_usuario', '=', $IdUsuario)
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreosDepartamentoSolicitante)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) 
                            ->where('activo', '=', 'SI')//Correos Del Departamento de Sistemas   
                            ->get();            
                
            break;

            case 'MIGRAR':
                
                $CorreoAlmacenes = DB::table('empresas')->select('correo_responsable AS email', 'responsable_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del almacenista
                $CorreoSuperiorAlmacenes = DB::table('empresas')->select('correo_superior AS email', 'superior_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del superior almacenista
                
                $DepartamentoSolicitante = DB::table('users')->select('id_departamento')->where('id', '=', $IdSolicitante)->first(); //Departamento Solicitante
                
                $CorreoCatalogador = DB::table('users')->select('email', 'name') ->where('id', '=', $IdUsuario)->where('activo', '=', 'SI'); //Correo Catalogador
                $CorreosDepartamentoCompras = DB::table('users')->select('email', 'name')->where('id_departamento', '=', 2)->where('activo', '=', 'SI'); //Correos Del Departamento de Compras   
                
                $destinatarios = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento) 
                            ->where('activo', '=', 'SI')//Correos Del Departamento Solicitante
                            ->union($CorreoAlmacenes)
                            ->union($CorreoSuperiorAlmacenes)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            ->where('id_usuario', '=', $IdUsuario)
                            ->where('proceso', '=', 'MIGRAR')
                            ->union($CorreoCatalogador)
                            ->union($CorreosDepartamentoCompras)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) 
                            ->where('activo', '=', 'SI')//Correos Del Departamento de Sistemas   
                            ->get();            

            break;
        
            case 'SOLICITUD':

                $DepartamentoSolicitante = DB::table('users')->select('id_departamento')->where('id', '=', $IdUsuario)->first(); //Departamento Solicitante        
                $CorreoAlmacenes = DB::table('empresas')->select('correo_responsable AS email', 'responsable_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del almacenista
                $CorreoSuperiorAlmacenes = DB::table('empresas')->select('correo_superior AS email', 'superior_almacen AS name')->whereIn('id_empresa', $Empresas); //Correo del superior almacenista
                
                $destinatarios =  DB::table('users AS u')
                            ->join('model_has_roles AS r', 'u.id', '=', 'r.model_id')
                            ->select('u.email', 'u.name')
                            ->where('r.role_id', '=', 2) 
                            ->where('u.activo', '=', 'SI')//Correos Catalogadores
                            ->union($CorreoAlmacenes)
                            ->union($CorreoSuperiorAlmacenes)
                            ->get();
                
                $EnCopia = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', $DepartamentoSolicitante->id_departamento) //Correos Del Departamento Solicitante  
                            ->where('activo', '=', 'SI')
                            ->get();            
                
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();              
                                 
            break;            
        }

        return array($destinatarios, $EnCopia, $EnCopiaOculta);
    }

    //DESTINATARIOS PARA LOS CORREOS DE AUTORIZACION DE SALIDAS
    public static function AsalCorreosDestinatarios($IdUsuario, $Solicitante, $Departamento, $IdAlmacen, $Proceso)
    {    
        switch ($Proceso){
           
            case 'CREAR':
                    
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('name', '=', $Solicitante);
                $CorreoSuperiorSolicitante = DB::table('departamentos')->select('correo AS email', 'responsable AS name')->where('nombre_departamento', '=', $Departamento); //Responsable departamento
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario);

                $destinatarios = DB::table('users AS u')
                            ->join('departamentos AS d', 'd.id_departamento', '=', 'u.id_departamento')
                            ->select('u.email', 'u.name')
                            ->where('d.nombre_departamento', '=', 'SEGURIDAD') //CORREOS DEPARTAMENTO SEGURIDAD
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            ->union($CorreoSolicitante)
                            ->union($CorreoSuperiorSolicitante)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'ASAL')
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();  
            break;

            case 'APROBAR':
            
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('name', '=', $Solicitante);
                $CorreoSuperiorSolicitante = DB::table('departamentos')->select('correo AS email', 'responsable AS name')->where('nombre_departamento', '=', $Departamento); //Responsable departamento
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario);

                $destinatarios = DB::table('users AS u')
                            ->join('departamentos AS d', 'd.id_departamento', '=', 'u.id_departamento')
                            ->select('u.email', 'u.name')
                            ->where('d.nombre_departamento', '=', 'SEGURIDAD') //CORREOS DEPARTAMENTO SEGURIDAD
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            ->union($CorreoSolicitante)
                            ->union($CorreoSuperiorSolicitante)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'ASAL')
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();         
                
            break;

            case 'VALIDAR':
            
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('name', '=', $Solicitante);
                $CorreoSuperiorSolicitante = DB::table('departamentos')->select('correo AS email', 'responsable AS name')->where('nombre_departamento', '=', $Departamento); //Responsable departamento
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario);

                $destinatarios = DB::table('users AS u')
                            ->join('departamentos AS d', 'd.id_departamento', '=', 'u.id_departamento')
                            ->select('u.email', 'u.name')
                            ->where('d.nombre_departamento', '=', 'SEGURIDAD') //CORREOS DEPARTAMENTO SEGURIDAD
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            ->union($CorreoSolicitante)
                            ->union($CorreoSuperiorSolicitante)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'ASAL')
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();         
                
            break;
            
            case 'EDITAR':
            
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('name', '=', $Solicitante);
                $CorreoSuperiorSolicitante = DB::table('departamentos')->select('correo AS email', 'responsable AS name')->where('nombre_departamento', '=', $Departamento); //Responsable departamento
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario);

                $destinatarios = DB::table('users AS u')
                            ->join('departamentos AS d', 'd.id_departamento', '=', 'u.id_departamento')
                            ->select('u.email', 'u.name')
                            ->where('d.nombre_departamento', '=', 'SEGURIDAD') //CORREOS DEPARTAMENTO SEGURIDAD
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            ->union($CorreoSolicitante)
                            ->union($CorreoSuperiorSolicitante)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'ASAL')
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();  
                
            break;

            case 'CERRAR':
            
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('name', '=', $Solicitante);
                $CorreoSuperiorSolicitante = DB::table('departamentos')->select('correo AS email', 'responsable AS name')->where('nombre_departamento', '=', $Departamento); //Responsable departamento
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario);

                $destinatarios = DB::table('users AS u')
                            ->join('departamentos AS d', 'd.id_departamento', '=', 'u.id_departamento')
                            ->select('u.email', 'u.name')
                            ->where('d.nombre_departamento', '=', 'SEGURIDAD') //CORREOS DEPARTAMENTO SEGURIDAD
                            ->where('u.activo', '=', 'SI')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            ->union($CorreoSolicitante)
                            ->union($CorreoSuperiorSolicitante)
                            ->get();

                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'ASAL')
                            ->where('proceso', '=', 'CREAR')
                            ->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get();         
                
            break;
       
        }

        return array($destinatarios, $EnCopia, $EnCopiaOculta);
    }

    //DESTINATARIOS PARA LOS CORREOS DE CONTROL DE HERRAMIENTAS
    public static function CnthCorreosDestinatarios($Solicitante, $IdAlmacen, $Proceso)
    {    
        $IdUsuario = Auth::user()->id;
        
        switch ($Proceso){
            
            case 'DESPACHO':
              
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                
                //$DepartamentoSolicitante = DB::table('users')->where('id', '=', $Solicitante)->value('id_departamento'); //Departamento Solicitante

               // dd($DepartamentoSolicitante); 
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario)->get();    
              
                // $destinatarios = DB::table('departamentos')
                //                     ->select('correo AS email', 'responsable AS name')
                //                     ->where('id_departamento', '=', $DepartamentoSolicitante) //Responsable departamento
                //                     ->get();
                
                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'CNTH')
                            ->where('proceso', '=', 'DESPACHO')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            //->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get(); 
                            
            break;

            case 'RECEPCION':
                
                $CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->where('id_almacen', $IdAlmacen); //Correo del almacenista
                $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', $IdAlmacen); //Correo del superior almacenista
                
                //$DepartamentoSolicitante = DB::table('users')->where('id', '=', $Solicitante)->value('id_departamento'); //Departamento Solicitante

               // dd($DepartamentoSolicitante); 
                $CorreoEmisor = DB::table('users')->select('email', 'name')->where('id', '=', $IdUsuario)->get();    
              
                // $destinatarios = DB::table('departamentos')
                //                     ->select('correo AS email', 'responsable AS name')
                //                     ->where('id_departamento', '=', $DepartamentoSolicitante) //Responsable departamento
                //                     ->get();
                
                $EnCopia = DB::table('correos')
                            ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                            //->where('id_usuario', '=', $IdUsuario)
                            ->where('modulo', '=', 'CNTH')
                            ->where('proceso', '=', 'DESPACHO')
                            ->union($CorreoAlmacen)
                            ->union($CorreoSuperiorAlmacen)
                            //->union($CorreoEmisor)
                            ->get();

                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1)
                            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas   
                            ->get(); 
            break;    
           
        }

        return array($CorreoEmisor, $EnCopia, $EnCopiaOculta);
        
    }

    public static function CnthCorreoHerramientasRecepcionPendiente($IdAlmacen)
    {       
        //$CorreoAlmacen = DB::table('almacenes')->select('correo AS email', 'responsable AS name')->whereIn('id_almacen', $IdAlmacen); //Correo del almacenista
        $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', '=', $IdAlmacen); //Correo del superior almacenista
        // $DepartamentoAuditoria = DB::table('users')
        //                         ->select('email', 'name')
        //                         ->where('id_departamento', '=', 19)
        //                         ->where('activo', '=', 'SI'); //Correos Del Departamento de Auditoria; 
        
        $para = DB::table('almacenes')
                    ->select('correo AS email', 'responsable AS name')
                    ->where('id_almacen', '=', $IdAlmacen)
                    ->union($CorreoSuperiorAlmacen)  
                    //->union($DepartamentoAuditoria)  
                    ->get();

        $EnCopia = DB::table('correos')
                    ->select('correo_destinatario AS email', 'nombre_destinatario AS name') //Correos Adicionales   
                    //->where('id_usuario', '=', $IdUsuario)
                    ->where('modulo', '=', 'CNTH')
                    ->where('proceso', '=', 'PENDIENTES')
                    //->union($CorreoEmisor)
                    ->get();

        $EnCopiaOculta = DB::table('users')
                    ->select('email', 'name')
                    ->whereIn('id_departamento', [1, 19])
                    ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas y Auditoria   
                    ->get(); 
                            
      
        return array($para, $EnCopia, $EnCopiaOculta);
    }

    public static function InvCorreoStockMinimoArticulos($IdAlmacen)
    {       
        $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', '=', $IdAlmacen); //Correo del superior almacenista

        $para = DB::table('almacenes')
                    ->select('correo AS email', 'responsable AS name')
                    ->where('id_almacen', '=', $IdAlmacen)
                    ->union($CorreoSuperiorAlmacen)  
                    //->union($DepartamentoAuditoria)  
                    ->get();

        $EnCopia = null;

        $EnCopiaOculta = DB::table('users')
                    ->select('email', 'name')
                    ->whereIn('id_departamento', [1])
                    ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas
                    ->get(); 
                            
        return array($para, $EnCopia, $EnCopiaOculta);
    }


    public static function InvCorreoPuntoPedidoArticulos($IdAlmacen)
    {       
        $CorreoSuperiorAlmacen = DB::table('almacenes')->select('correo2 AS email', 'superior AS name')->where('id_almacen', '=', $IdAlmacen); //Correo del superior almacenista

        $para = DB::table('almacenes')
                    ->select('correo AS email', 'responsable AS name')
                    ->where('id_almacen', '=', $IdAlmacen)
                    ->union($CorreoSuperiorAlmacen)  
                    //->union($DepartamentoAuditoria)  
                    ->get();

        $EnCopia = null;

        $EnCopiaOculta = DB::table('users')
                    ->select('email', 'name')
                    ->whereIn('id_departamento', [1])
                    ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas
                    ->get(); 
                            
        return array($para, $EnCopia, $EnCopiaOculta);
    }
    //DESTINATARIOS PARA LOS CORREOS DE SOLICITUDES DE SERVICIO
    public static function SolsCorreosDestinatarios($Solicitante, $DepartamentoServicio, $DepartamentoSolicitante, $Proceso)
    {
        switch ($Proceso){
           
            case 'CREAR':
               
                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();            
    
            break; 
                     
            case 'ACEPTAR':

                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;

            case 'ASIGNAR':

                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;

            case 'COMENTARIO':

                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;

            case 'REABRIR':

                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;

            case 'ENCUESTA SOLICITUD':

                //$CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios = DB::table('users')->select('email', 'name')
                                                    ->where('id_departamento', '=', $DepartamentoServicio)
                                                    ->where('activo', '=', 'SI')
                                                    ->get(); //Correos Del Departamento Servicio
               
                $EnCopia =  '';
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;

            case 'ENCUESTA SERVICIO':

                $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
                
                $destinatarios =  DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $DepartamentoSolicitante) 
                            ->union($CorreoSolicitante)
                            ->get();
                
                $EnCopia = ''; 
                            
                $EnCopiaOculta = DB::table('users')
                            ->select('email', 'name')
                            ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                            ->where('activo', '=', 'SI')
                            ->get();       
                            
            break;
        }

       return array($destinatarios, $EnCopia, $EnCopiaOculta);
    }
    
   //DESTINATARIOS PARA LOS CORREOS DE SOLICITUDES DE SERVICIO
   public static function CntcCorreosDestinatarios($Solicitante,$DepartamentoSolicitante,$IdCombustible, $Proceso)
   {
       switch ($Proceso){
          
           case 'CREAR':
              
               $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
               $CombustibleResponsable=DB::table('cntc_tipo_combustible')->where('id_tipo_combustible','=',$IdCombustible)->value('id_departamento_encargado');

               if($CombustibleResponsable==19)
               {
                    $destinatarios = DB::table('users')->select('email', 'name')
                            ->where('id_departamento', '=', $CombustibleResponsable)
                            ->where('activo', '=', 'SI')
                            ->get(); //Correos Del Departamento Auditoria
              

               }elseif($CombustibleResponsable==9)
               {
                    $destinatarios= DB::table('departamentos')
                            ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                            ->where('id_departamento', '=', $CombustibleResponsable) 
                            ->get();//Correos Del Departamento Logistica
               }
              
               $EnCopia =  DB::table('departamentos')
                           ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                           ->where('id_departamento', '=', $DepartamentoSolicitante) 
                           ->union($CorreoSolicitante)
                           ->get();
                           
               $EnCopiaOculta = DB::table('users')
                           ->select('email', 'name')
                           ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                           ->where('activo', '=', 'SI')
                           ->get();            
   
           break; 
                    
           case 'ACEPTAR':

            $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
            $CombustibleResponsable=DB::table('cntc_tipo_combustible')->where('id_tipo_combustible','=',$IdCombustible)->value('id_departamento_encargado');

            if($CombustibleResponsable==19)
            {
                 $destinatarios = DB::table('users')->select('email', 'name')
                         ->where('id_departamento', '=', $CombustibleResponsable)
                         ->where('activo', '=', 'SI')
                         ->get(); //Correos Del Departamento Auditoria
           

            }elseif($CombustibleResponsable==9)
            {
                $CorreoLogistica = DB::table('departamentos')->select('correo','responsable')->where('id_departamento', '=', $CombustibleResponsable); //Correo departamento logistica
                $destinatarios= DB::table('users')
                        ->select('email','name')  //Responsable departamento
                        ->wherein('id_departamento',  [10, 14]) 
                        ->where('activo', '=', 'SI')
                        ->union($CorreoLogistica)
                        ->get();//Correos Del Departamento mantenimiento y almacen mantenimiento
            }
           
            $EnCopia =  DB::table('departamentos')
                        ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                        ->where('id_departamento', '=', $DepartamentoSolicitante) 
                        ->union($CorreoSolicitante)
                        ->get();
                        
            $EnCopiaOculta = DB::table('users')
                        ->select('email', 'name')
                        ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                        ->where('activo', '=', 'SI')
                        ->get();        
                           
           break;

           case 'PROCESADO':

            $CorreoSolicitante = DB::table('users')->select('email', 'name')->where('id', '=', $Solicitante); //Correo Solicitante
            $CombustibleResponsable=DB::table('cntc_tipo_combustible')->where('id_tipo_combustible','=',$IdCombustible)->value('id_departamento_encargado');

            if($CombustibleResponsable==19)
            {
                 $destinatarios = DB::table('users')->select('email', 'name')
                         ->where('id_departamento', '=', $CombustibleResponsable)
                         ->where('activo', '=', 'SI')
                         ->get(); //Correos Del Departamento Auditoria
           

            }elseif($CombustibleResponsable==9)
            {
                $CorreoLogistica = DB::table('departamentos')->select('correo','responsable')->where('id_departamento', '=', $CombustibleResponsable); //Correo departamento logistica
                $destinatarios= DB::table('users')
                        ->select('email','name')  //Responsable departamento
                        ->wherein('id_departamento',  [10, 14]) 
                        ->where('activo', '=', 'SI')
                        ->union($CorreoLogistica)
                        ->get();//Correos Del Departamento mantenimiento y almacen mantenimiento
            }
           
            $EnCopia =  DB::table('departamentos')
                        ->select('correo AS email', 'responsable AS name')  //Responsable departamento
                        ->where('id_departamento', '=', $DepartamentoSolicitante) 
                        ->union($CorreoSolicitante)
                        ->get();
                        
            $EnCopiaOculta = DB::table('users')
                        ->select('email', 'name')
                        ->where('id_departamento', '=', 1) //Correos Del Departamento de Sistemas   
                        ->where('activo', '=', 'SI')
                        ->get();        
                           
           break;
           
       }

      return array($destinatarios, $EnCopia, $EnCopiaOculta);
   }
    

    //DESTINATARIOS CORREO OC INTERNACIONAL COSTO CERO
    public static function CompCorreoOcInternacionalCostoCero()
    {
        $destinatarios = DB::table('users')
                ->select(
                    'email',
                    'name'
                    )
                ->whereIN('id', [14,28,94,106]) //gismar, hislenis, gborges, angely
                ->get();

        $EnCopia = null;

        $EnCopiaOculta = DB::table('users')
            ->select('email', 'name')
            ->whereIn('id_departamento', [1])
            ->where('activo', '=', 'SI') //Correos Del Departamento de Sistemas  
            ->get();

        return array($destinatarios, $EnCopia, $EnCopiaOculta);
    }

    //Relacion de muchos a muchos entre articulos y unidad
    public function User()
    {
        return $this->hasMany(User::class, 'id');
    }
}
