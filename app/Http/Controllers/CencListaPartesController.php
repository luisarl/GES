<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cenc_ListaPartesModel;
use App\Models\Cenc_ListaPartesPerfilesModel;
use App\Models\Cenc_ListaPartesPerfilesCPModel;
use App\Models\Cenc_ListaPartesPlanchasModel;
use App\Models\Cenc_ListaPartesPlanchasCPModel;
use App\Models\Cenc_FichasModel;
use App\Models\Cenc_ConapModel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CencListaPartesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listap = Cenc_ListaPartesModel::ListaPartes();
        $conaps	= Cenc_ConapModel::ListaConaps();
        return view('CentroCorte.ListaPartes.ListaPartes', compact('listap','conaps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fichas = Cenc_FichasModel::ListaFichas();
        $conaps	= Cenc_ConapModel::ListaConaps();

        return view('CentroCorte.ListaPartes.ListaPartesCreate', compact('fichas','conaps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $IdUsuario = Auth::user()->id;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $IdListaParte = Cenc_ListaPartesModel::max('id_lista_parte') + 1;

        try
        {
            DB::transaction(function () use ($IdUsuario, $FechaActual, $request)
            {
                if($request['select_tipo']==="PLANCHAS") 
                {
                    $data = json_decode($request['datos_lplancha']);

                    $Observaciones = $data->observaciones;

                        foreach ($Observaciones as $text)
                        {
                            $observaciones = $text->observaciones_lista;
                        }

                    $IdListaParte = Cenc_ListaPartesModel::max('id_lista_parte') + 1;
                    Cenc_ListaPartesModel::create([
                        'id_lista_parte'    => $IdListaParte,
                        'nro_conap'         => $request['nro_conap_lp'],
                        'tipo_lista'        => $request['select_tipo'],
                        'estatus'           => 'ACTIVADO',
                        'observaciones'     => $observaciones,
                        'creado_por'        => $IdUsuario,
                        'fecha_creado'      => $FechaActual
                    ]);
                
                    $ListaDatos = $data->lista_datos;
                   
                    foreach($ListaDatos as $parte)
                    {
                        $IdLplancha = Cenc_ListaPartesPlanchasModel::max('id_lplancha') + 1;
                        $NroParte = $parte->nroparte_pla; 

                        //Verificar si ya existe un registro con el mismo id_lista_parte y nro_partes 
                        $existe = Cenc_ListaPartesPlanchasModel::where('id_lista_parte', $IdListaParte)
                                ->where('nro_partes',$NroParte)
                                ->first(); 

                        if($existe) 
                        {
                            // registro solo en la tabla perforaciones si tiene mas de una perforacion la pieza 
                            $IdLplanchaPerf = Cenc_ListaPartesPlanchasCPModel::max('id_perforacion_plancha') + 1;
                            Cenc_ListaPartesPlanchasCPModel::create([
                                'id_perforacion_plancha'   =>  $IdLplanchaPerf,  
                                'id_plancha'               =>  $existe->id_lplancha,      
                                'diametro_perforacion'     =>  $parte->diametro_perf_pla,
                                'cantidad_perforacion'     =>  $parte->cant_perf_pla,
                                'cantidad_total'           =>  $parte->cant_total_pla
                            ]);
                        } 
                        else 
                        {
                            $IdLplancha = Cenc_ListaPartesPlanchasModel::max('id_lplancha') + 1;
                            Cenc_ListaPartesPlanchasModel::create([
                                'id_lplancha'     =>  $IdLplancha,   //PK
                                'id_lista_parte'  =>  $IdListaParte, //FK
                                'nro_partes'      =>  $parte->nroparte_pla,
                                'descripcion'     =>  $parte->descripcion_pla,
                                'prioridad'       =>  $parte->prioridad_pla,
                                'dimensiones'     =>  $parte->datos_dim_pla,
                                'espesor'         =>  $parte->espesor_pla,
                                'cantidad_piezas' =>  $parte->cantpiezas_pla,
                                'peso_unit'       =>  $parte->peso_unit_pla,
                                'peso_total'      =>  $parte->peso_total_pla,
                                'creado_por'      =>  $IdUsuario,
                                'fecha_creado'    =>  $FechaActual
                            ]);

                            // Registro en la tabla perforaciones porque siempre tendra asi sea 0 
                            $IdLplanchaPerf = Cenc_ListaPartesPlanchasCPModel::max('id_perforacion_plancha') + 1;
                            Cenc_ListaPartesPlanchasCPModel::create([
                                'id_perforacion_plancha'   =>  $IdLplanchaPerf,  //PK
                                'id_plancha'               =>  $IdLplancha,      //FK
                                'diametro_perforacion'     =>  $parte->diametro_perf_pla,
                                'cantidad_perforacion'     =>  $parte->cant_perf_pla,
                                'cantidad_total'           =>  $parte->cant_total_pla
                            ]);
                        }
                    }
                }
                else
                {
                    if($request['select_tipo']==="PERFILES")
                    {
                        $data = json_decode($request['datos_lperfil']);

                        $Observaciones = $data->observaciones;

                        foreach ($Observaciones as $text)
                        {
                            $observaciones = $text->observaciones_lista;
                        }

                        $IdListaParte = Cenc_ListaPartesModel::max('id_lista_parte') + 1;
                        Cenc_ListaPartesModel::create([
                            'id_lista_parte'    => $IdListaParte,
                            'nro_conap'         => $request['nro_conap_lp'],
                            'tipo_lista'        => $request['select_tipo'],
                            'estatus'           => 'ACTIVADO',
                            'observaciones'     => $observaciones,
                            'creado_por'        => $IdUsuario,
                            'fecha_creado'      => $FechaActual
                        ]);
                    
                        $ListaDatos = $data->lista_perfiles;
                      
                        foreach($ListaDatos as $parte)
                        {
                            $IdLperfil = Cenc_ListaPartesPerfilesModel::max('id_lperfil') + 1;
                            $NroParte = $parte->nroparte_per; 
                            $peso = (float)Cenc_FichasModel::buscarPeso($parte->id_perfil); 
                            $peso = ($peso * ((float)$parte->longitud_pieza_per * 0.001));
                            $PesoTotal = (float)($peso * (int)$parte->cantidad_piezas_per);

                            //Verificar si ya existe un registro con el mismo id_lista_parte y nro_partes 
                            $existe = Cenc_ListaPartesPerfilesModel::where('id_lista_parte', $IdListaParte)
                                    ->where('nro_partes',$NroParte)
                                    ->first();
                            if($existe) 
                            {
                                // registro solo en la tabla perforaciones si tiene mas de una perforacion la pieza 
                                $IdLperfilPerf = Cenc_ListaPartesPerfilesCPModel::max('id_perforacion_perfil') + 1;
                                Cenc_ListaPartesPerfilesCPModel::create([
                                    'id_perforacion_perfil'     =>  $IdLperfilPerf,  //PK
                                    'id_lperfil'                =>  $existe->id_lperfil,      //FK
                                    'diametro_perforacion'      =>  $parte->diametro_perf_per,
                                    't_ala'                     =>  $parte->cantidad_t_per,
                                    's_alma'                    =>  $parte->cantidad_s_per,
                                    'cantidad_total'            =>  $parte->total_per_per
                                ]);
                            } 
                            else 
                            {
                                $IdLperfil = Cenc_ListaPartesPerfilesModel::max('id_lperfil') + 1;

                                Cenc_ListaPartesPerfilesModel::create([
                                    'id_lperfil'        =>  $IdLperfil,   //PK
                                    'id_lista_parte'    =>  $IdListaParte, //FK
                                    'id_ficha'          =>  $parte->id_perfil,
                                    'nro_partes'        =>  $parte->nroparte_per,
                                    'cantidad_piezas'   =>  $parte->cantidad_piezas_per,
                                    'prioridad'         =>  $parte->prioridad_per,
                                    'longitud_pieza'    =>  $parte->longitud_pieza_per,
                                    'tipo_corte'        =>  $parte->tipo_corte_per,
                                    'peso_unit'         =>  $peso,
                                    'peso_total'        =>  $PesoTotal,
                                    'creado_por'        =>  $IdUsuario,
                                    'fecha_creado'      =>  $FechaActual
                                ]);
                                
                                // Registro en la tabla perforaciones porque siempre tendra asi sea 0 
                                $IdLperfilPerf = Cenc_ListaPartesPerfilesCPModel::max('id_perforacion_perfil') + 1;
                                Cenc_ListaPartesPerfilesCPModel::create([
                                    'id_perforacion_perfil'     =>  $IdLperfilPerf,  //PK
                                    'id_lperfil'                =>  $IdLperfil,      //FK
                                    'diametro_perforacion'      =>  $parte->diametro_perf_per,
                                    't_ala'                     =>  $parte->cantidad_t_per,
                                    's_alma'                    =>  $parte->cantidad_s_per,
                                    'cantidad_total'            =>  $parte->total_per_per
                                ]);
                            }
                        }
                    }
            
                }
            });
        }  catch(Exception $ex){
                return redirect()->back()->withError('Ha Ocurrido Un Error al Crear Lista de Partes '.$ex->getMessage())->withInput();
        }
        return redirect()->route('cenclistapartes.show', $IdListaParte)->withSuccess('Se Ha Creado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdListaParte)
    {
        $tipos = Cenc_ListaPartesModel::ListaPartes_tipo($IdListaParte);
     
        foreach ($tipos as $tipo) {
            
            if ($tipo->tipo_lista === 'PLANCHAS')
            {
                $DetalleListaPartePlancha = Cenc_ListaPartesModel::ListaPartesDetalladaPlancha($tipo->id_lista_parte);
                $SumListaPla = Cenc_ListaPartesModel::SumListaPartesPlanchas($tipo->id_lista_parte);
                $CantPerfPla = Cenc_ListaPartesModel::CantPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $SumPerfPla = Cenc_ListaPartesModel::SumPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $MetrosPerfPla = Cenc_ListaPartesModel::MetrosPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $TotalMetrosPerfPla = Cenc_ListaPartesModel::TotalMetrosPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $UsuarioListaParteAnulado = Cenc_ListaPartesModel::UsuarioListaParteAnulado($tipo->id_lista_parte);
                $UsuarioListaParteFinalizado = Cenc_ListaPartesModel::UsuarioListaParteFinalizado($tipo->id_lista_parte);
               
                return view('CentroCorte.ListaPartes.ListaPartesShow', compact(
                    'DetalleListaPartePlancha',
                    'tipos',
                    'SumListaPla',
                    'CantPerfPla',
                    'SumPerfPla',
                    'MetrosPerfPla',
                    'TotalMetrosPerfPla',
                    'UsuarioListaParteAnulado',
                    'UsuarioListaParteFinalizado'
                ));
            }
            else 
            {
                $DetalleListaPartePerfil = Cenc_ListaPartesModel::ListaPartesDetalladaPerfil($tipo->id_lista_parte);
                $SumListaPer = Cenc_ListaPartesModel::SumListaPartesPerfiles($tipo->id_lista_parte);
                $CantPerfPer = Cenc_ListaPartesModel::CantPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $SumPerfPer = Cenc_ListaPartesModel::SumPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $MetrosPerfPer = Cenc_ListaPartesModel::MetrosPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $TotalMetrosPerfPer = Cenc_ListaPartesModel::TotalMetrosPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $IdFicha = (int)Cenc_FichasModel::buscarIdListaParte($tipo->id_lista_parte); // ME AYUDA A LOCALIZAR EL IDFICHA ENLAZADO AL ID_LISTA_PARTE
                $alma = (float)Cenc_FichasModel::buscarEspesorAlma($IdFicha); 
                $ala = (float)Cenc_FichasModel::buscarEspesorAla($IdFicha);
                $UsuarioListaParteAnulado = Cenc_ListaPartesModel::UsuarioListaParteAnulado((int)$tipo->id_lista_parte);
                $UsuarioListaParteFinalizado = Cenc_ListaPartesModel::UsuarioListaParteFinalizado($tipo->id_lista_parte);
                // dump($tipo->id_lista_parte);

                // dump($UsuarioListaParteAnulado);
                // dump($UsuarioListaParteFinalizado);

                // dd("ok");
                return view('CentroCorte.ListaPartes.ListaPartesShow', compact(
                    'DetalleListaPartePerfil',
                    'tipos',
                    'SumListaPer',
                    'CantPerfPer',
                    'SumPerfPer',
                    'MetrosPerfPer',
                    'TotalMetrosPerfPer',
                    'alma',
                    'ala',
                    'UsuarioListaParteAnulado',
                    'UsuarioListaParteFinalizado'
                ));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdLista)
    {
        $tipos = Cenc_ListaPartesModel::ListaPartes_tipo($IdLista);
        $fichas = Cenc_FichasModel::ListaFichas();
        
        foreach ($tipos as $lista) {
            
            if ($lista->tipo_lista === 'PLANCHAS')
            {
                $planchas = Cenc_ListaPartesPlanchasModel::ListaPartesPlanchasID($lista->id_lista_parte);
                return view('CentroCorte.ListaPartes.ListaPartesEdit', compact('tipos','planchas','lista'));
            } 
            else 
            {
                $perfiles = Cenc_ListaPartesPerfilesModel::ListaPartesPerfilesID($lista->id_lista_parte);
                return view('CentroCorte.ListaPartes.ListaPartesEdit', compact('tipos','perfiles','fichas','lista'));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdListaParte)
    {
        $IdUsuario = Auth::user()->id;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        try
        {
            DB::transaction(function () use ($IdUsuario, $FechaActual, $request, $IdListaParte) 
            {
                if($request['datos_lplancha'] !== null) 
                {
                    $data = json_decode($request['datos_lplancha']);
                    $ListaDatos = $data->lista_datos;
                    $Observaciones = $data->observaciones;

                    foreach ($Observaciones as $text)
                    {
                        $observaciones = $text->observaciones_plancha;
                    }

                    if ($IdListaParte == '') 
                    {
                        $id_lista_parte = Cenc_ListaPartesModel::max('id_lista_parte') + 1;
                    } 
                    else 
                    {
                        $id_lista_parte = $IdListaParte;
                    }

                    Cenc_ListaPartesModel::updateOrCreate(
                        [
                            'id_lista_parte'    => (int)$id_lista_parte,
                        ],
                        [
                            'id_lista_parte'    => (int)$id_lista_parte,
                            'estatus'           => 'ACTIVADO',
                            'observaciones'     => $observaciones,
                            'creado_por'        => $IdUsuario,
                            'fecha_creado'      => $FechaActual
                        ]);

                    foreach($ListaDatos as $parte)
                    {
                        $IdLplancha = Cenc_ListaPartesPlanchasModel::max('id_lplancha') + 1;
                        $NroParte = $parte->nroparte_pla; 
                        $IdListaParte = intval($parte->lista_parte_pla);

                        //Verificar si ya existe un registro con el mismo id_lista_parte y nro_partes 
                        $existe = Cenc_ListaPartesPlanchasModel::where('id_lista_parte', $IdListaParte)
                                ->where('nro_partes',$NroParte)
                                ->first();

                        if($existe) 
                        {
                            // registro solo en la tabla perforaciones si tiene mas de una perforacion la pieza 
                            $IdLplanchaPerf = Cenc_ListaPartesPlanchasCPModel::max('id_perforacion_plancha') + 1;
                            Cenc_ListaPartesPlanchasCPModel::create([
                                'id_perforacion_plancha'   =>  $IdLplanchaPerf,  //PK
                                'id_plancha'               =>  $existe->id_lplancha,      //FK
                                'diametro_perforacion'     =>  $parte->diametro_perf_pla,
                                'cantidad_perforacion'     =>  $parte->cant_perf_pla,
                                'cantidad_total'           =>  $parte->cant_total_pla
                            ]);
                        } 
                        else 
                        {
                            $IdLplancha = Cenc_ListaPartesPlanchasModel::max('id_lplancha') + 1;
                            Cenc_ListaPartesPlanchasModel::create([
                                'id_lplancha'     =>  $IdLplancha,   //PK
                                'id_lista_parte'  =>  $IdListaParte, //FK
                                'nro_partes'      =>  $parte->nroparte_pla,
                                'descripcion'     =>  $parte->descripcion_pla,
                                'prioridad'       =>  $parte->prioridad_pla,
                                'dimensiones'     =>  $parte->datos_dim_pla,
                                'espesor'         =>  $parte->espesor_pla,
                                'cantidad_piezas' =>  $parte->cantpiezas_pla,
                                'peso_unit'       =>  $parte->peso_unit_pla,
                                'peso_total'      =>  $parte->peso_total_pla,
                                'creado_por'      =>  $IdUsuario,
                                'fecha_creado'    =>  $FechaActual
                            ]);

                            // Registro en la tabla perforaciones porque siempre tendra asi sea 0 
                            $IdLplanchaPerf = Cenc_ListaPartesPlanchasCPModel::max('id_perforacion_plancha') + 1;
                            Cenc_ListaPartesPlanchasCPModel::create([
                                'id_perforacion_plancha'   =>  $IdLplanchaPerf,  //PK
                                'id_plancha'               =>  $IdLplancha,      //FK
                                'diametro_perforacion'     =>  $parte->diametro_perf_pla,
                                'cantidad_perforacion'     =>  $parte->cant_perf_pla,
                                'cantidad_total'           =>  $parte->cant_total_pla
                            ]);
                        }
                    }
                }
                else
                {
                    if($request['datos_lperfil'] !== null)
                    {
                        $data = json_decode($request['datos_lperfil']);
                        $ListaDatos = $data->lista_perfiles;
                        $Observaciones = $data->observaciones;

                        foreach ($Observaciones as $text)
                        {
                            $observaciones = $text->observaciones_perfil;
                        }

                        if ($IdListaParte == '') 
                        {
                            $id_lista_parte = Cenc_ListaPartesModel::max('id_lista_parte') + 1;
                        } 
                        else 
                        {
                            $id_lista_parte = $IdListaParte;
                        }

                        Cenc_ListaPartesModel::updateOrCreate(
                            [
                                'id_lista_parte'    => (int)$id_lista_parte,
                            ],
                            [
                                'id_lista_parte'    => (int)$id_lista_parte,
                                'estatus'           => 'ACTIVADO',
                                'observaciones'     => $observaciones,
                                'creado_por'        => $IdUsuario,
                                'fecha_creado'      => $FechaActual
                            ]);
                        
                        foreach($ListaDatos as $parte)
                        {
                            $NroParte = $parte->nroparte_per; 
                            $peso = (float)Cenc_FichasModel::buscarPeso($parte->id_perfil); 
                            $peso = ($peso * ((float)$parte->longitud_pieza_per * 0.001));
                            $PesoTotal = (float)($peso * (int)$parte->cantidad_piezas_per);
                            $IdListaParte = intval($parte->lista_parte_per);

                            //Verificar si ya existe un registro con el mismo id_lista_parte y nro_partes 
                            $existe = Cenc_ListaPartesPerfilesModel::where('id_lista_parte', $IdListaParte)
                                    ->where('nro_partes',$NroParte)
                                    ->first();
                            if($existe) 
                            {
                                // registro solo en la tabla perforaciones si tiene mas de una perforacion la pieza 
                                $IdLperfilPerf = Cenc_ListaPartesPerfilesCPModel::max('id_perforacion_perfil') + 1;
                                Cenc_ListaPartesPerfilesCPModel::create([
                                    'id_perforacion_perfil'     =>  $IdLperfilPerf,  //PK
                                    'id_lperfil'                =>  $existe->id_lperfil,      //FK
                                    'diametro_perforacion'      =>  $parte->diametro_perf_per,
                                    't_ala'                     =>  $parte->cantidad_t_per,
                                    's_alma'                    =>  $parte->cantidad_s_per,
                                    'cantidad_total'            =>  $parte->total_per_per
                                ]);
                            } 
                            else 
                            {
                                $IdLperfil = Cenc_ListaPartesPerfilesModel::max('id_lperfil') + 1;

                                Cenc_ListaPartesPerfilesModel::create([
                                    'id_lperfil'        =>  $IdLperfil,   //PK
                                    'id_lista_parte'    =>  $IdListaParte, //FK
                                    'id_ficha'          =>  $parte->id_perfil,
                                    'nro_partes'        =>  $parte->nroparte_per,
                                    'cantidad_piezas'   =>  $parte->cantidad_piezas_per,
                                    'prioridad'         =>  $parte->prioridad_per,
                                    'longitud_pieza'    =>  $parte->longitud_pieza_per,
                                    'tipo_corte'        =>  $parte->tipo_corte_per,
                                    'peso_unit'         =>  $peso,
                                    'peso_total'        =>  $PesoTotal,
                                    'creado_por'        =>  $IdUsuario,
                                    'fecha_creado'      => $FechaActual
                                ]);
                                
                                // Registro en la tabla perforaciones porque siempre tendra asi sea 0 
                                $IdLperfilPerf = Cenc_ListaPartesPerfilesCPModel::max('id_perforacion_perfil') + 1;
                                Cenc_ListaPartesPerfilesCPModel::create([
                                    'id_perforacion_perfil'     =>  $IdLperfilPerf,  //PK
                                    'id_lperfil'                =>  $IdLperfil,      //FK
                                    'diametro_perforacion'      =>  $parte->diametro_perf_per,
                                    't_ala'                     =>  $parte->cantidad_t_per,
                                    's_alma'                    =>  $parte->cantidad_s_per,
                                    'cantidad_total'            =>  $parte->total_per_per
                                ]);
                            }
                        }
                    }
                }
            });
        }  
        catch(Exception $ex)
        {
                return redirect()->back()->withError('Ha Ocurrido Un Error al Editar Lista de Partes '.$ex->getMessage())->withInput();
        }
        return redirect()->back()->withSuccess('Se Ha Editado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Anula la lista de parte, no la elimina 
    public function destroy($IdListaParte) 
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try
        {
            $salida = Cenc_ListaPartesModel::find($IdListaParte);

            $salida->fill([
                'id_lista_parte' => $IdListaParte,
                'fecha_anulado' => $FechaActual,
                'estatus' => 'ANULADO',
                'anulado_por' => Auth::user()->id
            ]);  
            $salida->save();
        }
        catch (Exception $ex)
        {
            return redirect()->route('cenclistapartes.index')->withError('Error Al Anular la lista de parte '.$ex->getMessage());
        }
        return redirect()->route('cenclistapartes.index')->withSuccess('La lista de parte ha sido anulada exitosamente');
    }

    // Activa la lista de parte
    public function activar($IdListaParte) 
    {
        try
        {
            $salida = Cenc_ListaPartesModel::find($IdListaParte);

            $salida->fill([
                'id_lista_parte' => $IdListaParte,
                'estatus' => 'ACTIVADO'
            ]);  
            $salida->save();
        }
        catch (Exception $ex)
        {
            return redirect()->route('cenclistapartes.index')->withError('Error Al Activar la lista de parte '.$ex->getMessage());
        }
        return redirect()->route('cenclistapartes.index')->withSuccess('La lista de parte ha sido activada exitosamente');
    }

    //Eliminar registro de la lista 
    public function EliminarDetalleListaParte($id) 
    {
        try
        {
            $partes = explode(" ", $id); // Dividir la cadena en base al espacio en blanco
            $IdListaParte = intval($partes[0]); // id_lperfil
            $Id_Lista = intval($partes[1]); // id_perforacion_perfil 
            $Tipo_Lista = $partes[2]; // perfil o plancha 
              
            if ($Tipo_Lista === 'PERFILES')
            {
                $AuxPer = Cenc_ListaPartesPerfilesCPModel::Contador($IdListaParte); 
                Cenc_ListaPartesPerfilesCPModel::destroy($Id_Lista); // primero se elimina en tabla perforacion
                if($AuxPer == 1) // si solo tiene 1 registro en perforacion, puedes eliminar de la tabla perfiles 
                {
                    Cenc_ListaPartesPerfilesModel::destroy($IdListaParte);
                }
                return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
            }
            else 
            {
                $AuxPla = Cenc_ListaPartesPlanchasCPModel::Contador($IdListaParte); 
                Cenc_ListaPartesPlanchasCPModel::destroy($Id_Lista); // primero se elimina en tabla perforacion
                if($AuxPla === 1) // solo tiene 1 registro en perforacion, puedes eliminar de la tabla perfiles 
                {
                    Cenc_ListaPartesPlanchasModel::destroy($IdListaParte); // despues se elimina en tabla planchas
                }
                return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
            }
             
        }
        catch (Exception $e)
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro'); 
        }
        
    }

    public function ImprimirResumenListaPartes($IdListaParte)
    {
        $FechaActual = Carbon::now();
        $tipos = Cenc_ListaPartesModel::ListaPartes_tipo($IdListaParte);
      
        foreach ($tipos as $tipo) 
        {
            if ($tipo->tipo_lista === 'PLANCHAS')
            {
                $SumListaPla = Cenc_ListaPartesModel::SumListaPartesPlanchas($tipo->id_lista_parte);
                $CantPerfPla = Cenc_ListaPartesModel::CantPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $SumPerfPla = Cenc_ListaPartesModel::SumPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $MetrosPerfPla = Cenc_ListaPartesModel::MetrosPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                $TotalMetrosPerfPla = Cenc_ListaPartesModel::TotalMetrosPerforacionesListaPartesPlanchas($tipo->id_lista_parte);
                //return view('CentroCorte.ListaPartes.ListaPartesResumenPDF', compact('tipos','SumListaPla','CantPerfPla','SumPerfPla','MetrosPerfPla','TotalMetrosPerfPla'));
                $pdf = PDF::loadView('CentroCorte.ListaPartes.ListaPartesResumenPDF', compact('tipos','SumListaPla','CantPerfPla','SumPerfPla','MetrosPerfPla','TotalMetrosPerfPla'));
                return $pdf->stream('ListaPartesPlancha_' . $IdListaParte . '_' . $FechaActual . '.pdf');
            } 
            else 
            {
                $SumListaPer = Cenc_ListaPartesModel::SumListaPartesPerfiles($tipo->id_lista_parte);
                $CantPerfPer = Cenc_ListaPartesModel::CantPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $SumPerfPer = Cenc_ListaPartesModel::SumPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $MetrosPerfPer = Cenc_ListaPartesModel::MetrosPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $TotalMetrosPerfPer = Cenc_ListaPartesModel::TotalMetrosPerforacionesListaPartesPerfiles($tipo->id_lista_parte);
                $IdFicha = (int)Cenc_FichasModel::buscarIdListaParte($tipo->id_lista_parte); 
                $alma = (float)Cenc_FichasModel::buscarEspesorAlma($IdFicha); 
                $ala = (float)Cenc_FichasModel::buscarEspesorAla($IdFicha);
                //return view('CentroCorte.ListaPartes.ListaPartesResumenPDF', compact('tipos','SumListaPer','CantPerfPer','SumPerfPer','MetrosPerfPer','TotalMetrosPerfPer'));  
                $pdf = PDF::loadView('CentroCorte.ListaPartes.ListaPartesResumenPDF', compact('tipos','SumListaPer','CantPerfPer','SumPerfPer','MetrosPerfPer','TotalMetrosPerfPer','ala','alma'));  
                return $pdf->stream('ListaPartesPerfil_' . $IdListaParte . '_' . $FechaActual . '.pdf');
            }
        } 
    }

    public function ImprimirDetalleListaPartes($IdListaParte)
    {
        $FechaActual = Carbon::now();
        $tipos = Cenc_ListaPartesModel::ListaPartes_tipo($IdListaParte);
      
        foreach ($tipos as $tipo) 
        {
            if ($tipo->tipo_lista === 'PLANCHAS')
            {
                $ListaPartesPlanchas2 = Cenc_ListaPartesPlanchasModel::ListaPartesPlanchasID($tipo->id_lista_parte);
                $DiccionarioPlanchas = [];
                $ListaPartesPlanchas = array_map(function ($item) use (&$DiccionarioPlanchas) {
                    if (isset($DiccionarioPlanchas[$item->nro_partes])) {
                        $item->nro_partes = "";
                        $item->prioridad = "";
                        $item->descripcion = "";
                        $item->dimensiones = "";
                        $item->espesor = NULL;
                        $item->cantidad_piezas = "";
                        $item->peso_unit = NULL;
                        $item->peso_total = NULL;
                    } else {
                        $DiccionarioPlanchas[$item->nro_partes] = true;
                    }

                    return $item;}, $ListaPartesPlanchas2->toArray());

                $pdf = PDF::loadView('CentroCorte.ListaPartes.ListaPartesDetallePDF', compact('tipos','ListaPartesPlanchas'))->setPaper('letter','landscape');
                // return view('CentroCorte.ListaPartes.ListaPartesDetallePDF', compact('tipos','ListaPartesPlanchas'));
                return $pdf->stream('ListaPartesPlancha_' . $IdListaParte . '_' . $FechaActual . '.pdf');

            } else {
                $ListaPartesPerfiles2 = Cenc_ListaPartesPerfilesModel::ListaPartesPerfilesID($tipo->id_lista_parte);
                $ListaPartesPerfiles = [];
                $ListaPartesPerfiles = array_map(function ($item) use (&$ListaPartesPerfiles) {
                    if (isset($ListaPartesPerfiles[$item->nro_partes])) {
                        $item->nro_partes = "";
                        $item->nombre_ficha = "";
                        $item->cantidad_piezas = "";
                        $item->prioridad = "";
                        $item->longitud_pieza = NULL;
                        $item->tipo_corte = "";
                        $item->peso_unit = NULL;
                        $item->peso_total = NULL;
                    } else {
                        $ListaPartesPerfiles[$item->nro_partes] = true;
                    }
                    return $item;}, $ListaPartesPerfiles2->toArray());
                $pdf = PDF::loadView('CentroCorte.ListaPartes.ListaPartesDetallePDF', compact('tipos','ListaPartesPerfiles'))->setPaper('letter','landscape');
                return $pdf->stream('ListaPartesPerfil_' . $IdListaParte . '_' . $FechaActual . '.pdf');
                //return view('CentroCorte.ListaPartes.ListaPartesDetallePDF', compact('tipos','ListaPartesPerfiles'));
            }
        } 
    }

}