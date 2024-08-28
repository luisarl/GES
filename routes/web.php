<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function(){

    /*** DASHBOARD PRINCIPAL ***/
    Route::get('/',[App\Http\Controllers\InicioController::class, 'inicio']);
    /*** FIN DASHBOARD PRINCIPAL ***/

    /*** FICHA TECNICA ***/

    //ARTICULOS
    Route::get('dashboardfict',[App\Http\Controllers\InicioController::class, 'DashboardFichaTecnica'])->name('dashboardfict');
    Route::resource('articulos','App\Http\Controllers\FictArticulosController')->middleware('can:fict.articulos.inicio');
    Route::get('habilitar/{articulo}',[App\Http\Controllers\FictArticulosController::class, 'HabilitarArticulo'])->name('habilitar')->middleware('can:fict.articulos.habilitar');// habilitar articulo
    Route::get('inactivar/{articulo}',[App\Http\Controllers\FictArticulosController::class, 'InactivarArticulo'])->name('inactivar')->middleware('can:fict.articulos.activo');// inactivar articulo 
    Route::post('aprobar/{articulo}',[App\Http\Controllers\FictArticulosController::class, 'AprobarArticulo'])->name('aprobar')->middleware('can:fict.articulos.aprobar');// aprobar articulo 
    Route::get('autocompletar', [App\Http\Controllers\FictArticulosController::class, 'AutoCompletar'])->name('autocompletar');
    Route::get('generarcodigoarticulo',[App\Http\Controllers\FictArticulosController::class, 'generarcodigo'])->name('generarcodigoarticulo');
    Route::get('autocompletararticulo', [App\Http\Controllers\FictArticulosController::class, 'AutoCompletarArticulo'])->name('autocompletararticulo');
    Route::delete('eliminaradicionales/{id}',[App\Http\Controllers\FictArticulosController::class, 'eliminaradicionales'])->name('eliminaradicionales');
    Route::delete('eliminarimagen/{id_articulo_imagen}',[App\Http\Controllers\FictArticulosController::class, 'EliminarImagen'])->name('eliminarimagen');
    Route::get('unidadesarticulo/{id}',[App\Http\Controllers\FictArticulosController::class, 'unidadesarticulo'])->name('unidadesarticulo'); //obtener unidades de medida de un articulo
    Route::post('solicitud',[App\Http\Controllers\FictArticulosController::class, 'solicitudmigracion'])->name('solicitud')->middleware('can:fict.articulos.solicitud.migracion');
    Route::post('migracion',[App\Http\Controllers\FictArticulosController::class, 'migrate'])->name('migracion')->middleware('can:fict.articulos.migracion');
    Route::put('zonasActualizar/{id}',[App\Http\Controllers\FictArticulosController::class, 'zonasActualizar'])->name('zonasActualizar');
    //Route::post('updateZona/{id}',[App\Http\Controllers\FictArticulosController::class, 'updateZona'])->name('updateZona'); // actualizar zona en editar ficha tecnica 
    Route::post('registroUbicacion/{id}',[App\Http\Controllers\FictArticulosController::class, 'registroUbicacion'])->name('registroUbicacion');
    Route::get('fictimprimiretiquetas/{id_articulo}/{id_almacen}/{id_subalmacen}',[App\Http\Controllers\FictArticulosController::class, 'ImprimirEtiquetas'])->name('fictimprimiretiquetas');//->middleware('can:fict.grupos.migracion');
    Route::get('fictbuscararticulo/{articulo}',[App\Http\Controllers\FictArticulosController::class, 'BuscarArticulos'])->name('fictbuscararticulo');
    //GRUPOS
    Route::resource('grupos','App\Http\Controllers\FictGruposController')->middleware('can:fict.grupos.inicio');
    Route::get('subgruposarticulo/{id}',[App\Http\Controllers\FictArticulosController::class, 'subgruposarticulo'])->name('subgruposarticulo');
    Route::get('migraciongrupos',[App\Http\Controllers\FictGruposController::class, 'migrate'])->name('migraciongrupos')->middleware('can:fict.grupos.migracion');

    //SUBGRUPOS
    Route::resource('subgrupos','App\Http\Controllers\FictSubgruposController')->middleware('can:fict.subgrupos.inicio');
    Route::get('migracionsubgrupos',[App\Http\Controllers\FictSubgruposController::class, 'migrate'])->name('migracionsubgrupos')->middleware('can:fict.subgrupos.migracion');

    //CATEGORIAS
    Route::resource('categorias','App\Http\Controllers\FictCategoriasController')->middleware('can:fict.categorias.inicio');
    Route::get('migracioncategorias',[App\Http\Controllers\FictCategoriasController::class, 'migrate'])->name('migracioncategorias')->middleware('can:fict.categorias.migracion');

    //UNIDADES
    Route::resource('unidades','App\Http\Controllers\FictUnidadesController')->middleware('can:fict.unidades.inicio');
    Route::get('migracionunidades',[App\Http\Controllers\FictUnidadesController::class, 'migrate'])->name('migracionunidades')->middleware('can:fict.unidades.migracion');

    //CLASIFICACIONES
    Route::resource('clasificaciones','App\Http\Controllers\FictClasificacionesController')->middleware('can:fict.clasificaciones.inicio');

    //SUBCLASIFICACIONES
    Route::resource('subclasificaciones','App\Http\Controllers\FictSubclasificacionesController')->middleware('can:fict.subclasificaciones.inicio');
    Route::get('subclasificacionarticulo/{id}',[App\Http\Controllers\FictArticulosController::class, 'subclasificacionarticulo'])->name('subclasificacionarticulo');
   
    //UBICACIONES ZONAS
    Route::resource('ubicacionesarticulos', 'App\Http\Controllers\FictUbicacionesController')->middleware('can:fict.ubicaciones.inicio');

    //ARTICULOS UBICACIONES VISTA ASIGNAR UBICACIONES DE LOS ARTICULOS POR ALMACENES Y ZONAS
    Route::resource('articulosubicaciones', 'App\Http\Controllers\FictArticulosUbicacionesController')->middleware('can:fict.articulos.ubicacion');
    Route::get('filtroarticulosubicaciones/{codigo}/{grupo}/{categoria}/{almacen}/{subalmacen}/{zona}', [App\Http\Controllers\FictArticulosUbicacionesController::class,'FiltroArticulosUbicaciones'])->name('filtroarticulosubicaciones')->middleware('can:fict.articulos.ubicacion');
    Route::get('obtenersubalmacen/{id}', [App\Http\Controllers\FictArticulosUbicacionesController::class,'ObtenerSubalmacen'])->name('obtenersubalmacen');
    Route::get('obtenerzonas/{id}', [App\Http\Controllers\FictArticulosUbicacionesController::class,'ObtenerZonas'])->name('obtenerzonas');
    Route::delete('eliminarubicaciones/{id}',[App\Http\Controllers\FictArticulosUbicacionesController::class, 'EliminarUbicaciones'])->name('eliminarubicaciones');
    /*** FIN FICHA TECNICA ***/

    /*** ACTIVOS ***/

    //ACTIVOS
    Route::resource('activos','App\Http\Controllers\ActvActivosController')->middleware('can:actv.activos.inicio');
    Route::get('actvsubtipos/{id}',[App\Http\Controllers\ActvActivosController::class, 'SubtiposActivos'])->name('actvsubtipos');
    Route::get('actvcaracteristicas/{id}',[App\Http\Controllers\ActvActivosController::class, 'CaracteristicasActivos'])->name('caracteristicasactivos');

    //TIPOS
    Route::resource('tiposactivos','App\Http\Controllers\ActvTiposController')->middleware('can:actv.tipos.inicio');

    //SUBTIPOS
    Route::resource('subtiposactivos','App\Http\Controllers\ActvSubtiposController')->middleware('can:actv.subtipos.inicio');

    //CARACTERISTICAS
    Route::resource('caracteristicasactivos','App\Http\Controllers\ActvCaracteristicasController')->middleware('can:actv.caracteristicas.inicio');
    Route::delete('actveliminarcaracteristica/{id}',[App\Http\Controllers\ActvActivosController::class, 'EliminarCaracteristica'])->name('actveliminarcaracteristica');

    //ESTADOS
    Route::resource('estadosactivos','App\Http\Controllers\ActvEstadosController')->middleware('can:actv.estados.inicio');

    /*** FIN DE ACTIVOS ***/

    /*** COMPRAS ***/

    //PROVEEDORES
    Route::resource('proveedores','App\Http\Controllers\CompProveedoresController')->middleware('can:comp.proveedores.inicio');
    Route::post('migracionproveedor',[App\Http\Controllers\CompProveedoresController::class,'migrate'])->name('migracionproveedor')->middleware('can:comp.proveedores.migracion');
    Route::get('inactivarproveedor/{proveedor}',[App\Http\Controllers\CompProveedoresController::class, 'InactivarProveedor'])->name('inactivarproveedor')->middleware('can:comp.proveedores.activo');// inactivar proveedor 
        
    //TIPOS PROVEEDOR
    Route::resource('tiposproveedor','App\Http\Controllers\CompTipoProveedorController')->middleware('can:comp.tiposproveedor.inicio');
    
    //ZONAS
    Route::resource('zonas','App\Http\Controllers\CompZonasController')->middleware('can:comp.zonas.inicio');

    //SEGMENTOS
    Route::resource('segmentos','App\Http\Controllers\CompSegmentoProveedorController')->middleware('can:comp.segmentos.inicio');

    //ORDEN DE COMPRAS
    Route::resource('compactualizarpreciosoc','App\Http\Controllers\CompActualizarPreciosOCController')->middleware('can:comp.actualizarpreciosoc');
        
    /*** FIN COMPRAS ***/

    /*** AUTORIZACION SALIDA DE MATERIALES ***/

    //SALIDA MATERIALES
    Route::resource('autorizacionsalidas','App\Http\Controllers\AsalSalidasController')->middleware('can:asal.salidamateriales.inicio');
    Route::get('validarsalida/{id_salida}',[App\Http\Controllers\AsalSalidasController::class, 'ValidarSalida'])->name('validarsalida');// validar salida
    Route::get('validarsalidaalmacen/{id_salida}',[App\Http\Controllers\AsalSalidasController::class, 'ValidarSalidaAlmacen'])->name('validarsalidaalmacen');// validar salida 
    Route::get('importarnde',[App\Http\Controllers\AsalSalidasController::class, 'ImportarNotaEntregaProfit'])->name('importarnde');//importar nota de entrega profit
    Route::delete('eliminardetalle/{id}',[App\Http\Controllers\AsalSalidasController::class, 'eliminardetalle'])->name('eliminardetalle');
    Route::get('buscararticulosalidas/{articulo}', [App\Http\Controllers\AsalSalidasController::class, 'BuscarArticulos'])->name('buscararticulosalidas');
        
    //RETORNO MATERIALES
    Route::get('retornosalidas/{id}',[App\Http\Controllers\AsalSalidasController::class, 'retorno'])->name('retornosalidas')->middleware('can:asal.salidamateriales.retorno');
    Route::put('guardaretornosalidas/{id}',[App\Http\Controllers\AsalSalidasController::class, 'RetornoSalidas'])->name('guardaretornosalidas');

    //CIERRE ALMACEN
    Route::get('cerrarsalidaalmacen/{id_salida}',[App\Http\Controllers\AsalSalidasController::class, 'CerrarSalidaAlmacen'])->name('cerrarsalidaalmacen')->middleware('can:asal.salidamateriales.cerrar');
    Route::put('guardarcierresalidaalmacen/{id_salida}',[App\Http\Controllers\AsalSalidasController::class, 'GuardarCierreSalidaAlmacen'])->name('guardarcierresalidaalmacen');

    //VEHICULOS
    Route::resource('vehiculos','App\Http\Controllers\AsalVehiculosController')->middleware('can:asal.vehiculos.inicio');
  
    //TIPOS
    Route::resource('asaltipos','App\Http\Controllers\AsalTiposController')->middleware('can:asal.tipos.inicio');

    //SUBTIPOS
    Route::resource('asalsubtipos','App\Http\Controllers\AsalSubTiposController')->middleware('can:asal.subtipos.inicio');
    Route::get('asalsubtipossalidas/{id_tipo}',[App\Http\Controllers\AsalSubTiposController::class, 'SubTiposSalidas'])->name('asalsubtipossalidas');

    /*** FIN AUTORIZACION SALIDA DE MATERIALES ***/
   
    /*** SOLICITUDES DE SERVICIOS  ***/

    //SOLICITUDES
    Route::get('dashboardsols',[App\Http\Controllers\InicioController::class, 'DashboardSolicitudesServicios'])->name('dashboardsols');
    Route::resource('solicitudes','App\Http\Controllers\SolsSolicitudesController')->middleware('can:sols.solicitudes.inicio');
    Route::post('solsreabrir/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'reabrir'])->name('solsreabrir')->middleware('can:sols.solicitudes.reabrir');// reabrir solicitud
    Route::post('solsaceptar/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'aceptar'])->name('solsaceptar')->middleware('can:sols.solicitudes.aceptar');// aceptar solicitud    
    Route::post('solsasignarresponsables/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'AsignarResponsables'])->name('solsasignarresponsables')->middleware('can:sols.solicitudes.asignar');// aceptar solicitud  
    Route::post('solscomentariointerno/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'ComentarioInterno'])->name('solscomentariointerno');// comentario interno solicitud      
    Route::post('solupdateservicios/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'UpdateServicios'])->name('solupdateservicios')->middleware('can:sols.solicitudes.editarservicio'); // servicio y subservicio
    Route::get('solicitudes/missolicitudes/usuario',[App\Http\Controllers\SolsSolicitudesController::class, 'SolicitudesUsuario'])->name('solicitudes/missolicitudes/usuario');// mis solicitudes usuario 
    Route::get('solicitudes/asignadas/usuario',[App\Http\Controllers\SolsSolicitudesController::class, 'SolicitudesAsignadas'])->name('solicitudes/asignadas/usuario');// solicitudes  asignadas
    Route::get('solicitudes/todas/departamento',[App\Http\Controllers\SolsSolicitudesController::class, 'SolicitudesTodas'])->name('solicitudes/todas/departamento');// mis solicitudes  
    Route::delete('EliminarResponsables/{id}',[App\Http\Controllers\SolsSolicitudesController::class, 'EliminarResponsables'])->name('eliminarresponsables');
    
    // ENCUESTAS
    Route::get('solicitudes/encuestasolicitud/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'EncuestaSolicitud'])->name('solicitudes/encuestasolicitud');// encuesta evaluacion solicitud    
    Route::get('solicitudes/encuestaservicio/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'EncuestaServicio'])->name('solicitudes/encuestaservicio'); // encuesta evaluacion servicio  
    Route::post('solsencuestasolicitud/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'GuardarEncuestaSolicitud'])->name('solsencuestasolicitud');// guardar evaluacion solicitud    
    Route::post('solsencuestaservicio/{solicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'GuardarEncuestaServicio'])->name('solsencuestaservicio');// guardar evaluacion servicios    
    
    //SERVICIOS
    Route::resource('servicios','App\Http\Controllers\SolsServiciosController')->middleware('can:sols.servicios.inicio');
    Route::get('serviciosdepartamento/{id}',[App\Http\Controllers\SolsSolicitudesController::class, 'serviciosdepartamento'])->name('serviciosdepartamento');
    
    //SUBSERVICIOS
    Route::resource('subservicios','App\Http\Controllers\SolsSubServiciosController')->middleware('can:sols.subservicios.inicio');;
    Route::get('subserviciosdepartamento/{id}',[App\Http\Controllers\SolsSolicitudesController::class, 'subserviciosdepartamento'])->name('subserviciosdepartamento');
 
    //RESPONSABLES
    Route::resource('responsables','App\Http\Controllers\SolsResponsablesController')->middleware('can:sols.responsables.inicio');
    
    /*** FIN SOLICITUDES ***/

    /*** CONTROL DE HERRAMIENTAS ***/

    //DASHBOARD
    Route::get('dashboardcnth',[App\Http\Controllers\InicioController::class, 'DashboardControlHerramientas'])->name('dashboardcnth');
    
    //HERRAMIENTAS
    Route::resource('herramientas','App\Http\Controllers\CnthHerramientasController')->middleware('can:cnth.herramientas.inicio');
    Route::get('generarcodigoherramienta/{codigo}',[App\Http\Controllers\CnthHerramientasController::class, 'generarcodigoherramienta'])->name('generarcodigoherramienta');
    Route::get('importararticulo/{codigo}',[App\Http\Controllers\CnthHerramientasController::class, 'importararticulo'])->name('importararticulo');
    Route::get('subgruposherramientas/{id}',[App\Http\Controllers\CnthHerramientasController::class, 'subgruposherramientas'])->name('subgruposherramientas');
    Route::get('almacenesherramientas/{id}',[App\Http\Controllers\CnthHerramientasController::class, 'almacenesherramientas'])->name('almacenesherramientas');
    Route::get('ubicacionesHerramientas/{id}',[App\Http\Controllers\CnthHerramientasController::class, 'ubicacionesHerramientas'])->name('ubicacionesherramientas');
    
    //PLANTILLAS
    Route::resource('plantillas', 'App\Http\Controllers\CnthPlantillasController')->middleware('can:cnth.plantillas.inicio');
    Route::delete('eliminarherramientaplantilla/{id_detalle}',[App\Http\Controllers\CnthPlantillasController::class, 'EliminarHerramienta'])->name('eliminarherramientaplantilla');
    
    //MOVIMIENTOS DESPACHO RECEPCION
    //DESPACHOS
    Route::resource('despachos', 'App\Http\Controllers\CnthMovimientosController')->middleware('can:cnth.movimientos.inicio');
    Route::get('datosdespachos',[App\Http\Controllers\CnthMovimientosController::class, 'DatosDespachos'])->name('datosdespachos'); //vista despachos
    Route::get('herramientasalmacen/{id_almacen}', [App\Http\Controllers\CnthMovimientosController::class, 'HerramientasAlmacen'])->name('herramientasalmacen');
    Route::get('herramientasdespacho/{id_movimiento}', [App\Http\Controllers\CnthMovimientosController::class, 'HerramientasDespacho'])->name('herramientasdespacho');
    Route::get('plantillasalmacen/{id_almacen}', [App\Http\Controllers\CnthPlantillasController::class, 'PlantillasAlmacen'])->name('plantillasalmacen');
    Route::get('herramientasplantilla/{id_plantilla}', [App\Http\Controllers\CnthPlantillasController::class, 'HerramientasPlantilla'])->name('herramientasplantilla');

    //RECEPCION
    Route::get('recepcion/{id}',[App\Http\Controllers\CnthMovimientosController::class, 'recepcion'])->name('recepcion')->middleware('can:cnth.movimientos.recepcion');
    Route::put('enviar/{id}',[App\Http\Controllers\CnthMovimientosController::class, 'EnviarRecepcion'])->name('enviar');

    //UBICACIONES
    Route::resource('ubicaciones', 'App\Http\Controllers\CnthUbicacionesController')->middleware('can:cnth.ubicaciones.inicio');

    //ENTRADAS SALIDAS
    Route::resource('entradas','App\Http\Controllers\CnthEntradasController')->middleware('can:cnth.entradas.inicio');
    Route::resource('salidas','App\Http\Controllers\CnthSalidasController')->middleware('can:cnth.salidas.inicio');

    //INVENTARIO
    Route::resource('inventarios','App\Http\Controllers\CnthInventariosController')->middleware('can:cnth.inventario');  
    Route::resource('tiposajustes','App\Http\Controllers\CnthTipoAjusteController');
    Route::resource('trasladosalmacenes','App\Http\Controllers\CnthTrasladoAlmacenesController');
    Route::get('trasladoshistorico',[App\Http\Controllers\CnthTrasladoAlmacenesController::class, 'trasladoshistorico'])->name('trasladoshistorico');
    
    //ZONAS
    Route::resource('zonadespacho','App\Http\Controllers\CnthZonasController')->middleware('can:cnth.zonas.inicio');  

    //RESPONSABLES
    Route::resource('empleados','App\Http\Controllers\CnthEmpleadosController')->middleware('can:cnth.responsables.inicio');
    
    //GRUPOS
    Route::resource('cnthgrupos','App\Http\Controllers\CnthGruposController')->middleware('can:cnth.grupos.inicio');
    
    //SUBGRUPOS
    Route::resource('cnthsubgrupos','App\Http\Controllers\CnthSubgruposController')->middleware('can:cnth.subgrupos.inicio');
    
    //CATEGORIAS
    Route::resource('cnthcategorias','App\Http\Controllers\CnthCategoriasController')->middleware('can:cnth.categorias.inicio');
   
    
    //REVISAR
    // Route::resource('ajustesentradassalidas','App\Http\Controllers\CnthAjustesEntradasSalidasController');
    // Route::resource('solicitudes', 'App\Http\Controllers\CnthSolicitudesController');
    // Route::get('autocompletardespacho', [App\Http\Controllers\CnthMovimientosController::class, 'AutoCompletar'])->name('autocompletardespacho');
    // Route::delete('eliminardatrosdespacho/{id}',[App\Http\Controllers\CnthMovimientosContoller::class, 'eliminardatosdespacho'])->name('eliminardatosdespacho'); //revisar

    /*** FIN CONTROL DE HERRAMIENTAS ***/

    /*** CENTRO DE CORTE****/
    //RESPONSABLES
    Route::resource('cencresponsables','App\Http\Controllers\CencResponsablesController')->middleware('can:cenc.responsables.inicio');
    //CONSUMIBLES
    Route::resource('cencconsumibles','App\Http\Controllers\CencConsumiblesController')->middleware('can:cenc.consumibles.inicio');
    //TECNOLOGIAS
    Route::resource('cenctecnologia','App\Http\Controllers\CencTecnologiaController');
    Route::delete('EliminarTecnologias/{id}',[App\Http\Controllers\CencEquiposController::class, 'EliminarTecnologias'])->name('eliminartecnologias');
    //EQUIPOS
    Route::resource('cencequipos','App\Http\Controllers\CencEquiposController')->middleware('can:cenc.equipos.inicio');
    Route::get('cencequipos/obtener-tecnologias/{idEquipo}', [App\Http\Controllers\CencTablasConsumoController::class, 'TecnologiaEquipoC'])->name('cenctablasconsumo.obtener-tecnologias');
    Route::delete('cencequiposconsumibles/{id}', [App\Http\Controllers\CencConsumiblesController::class, 'EliminarEquipoConsumible'])->name('cencequiposconsumibles'); 
    //TABLAS DE CONSUMO
    Route::resource('cenctablasconsumo','App\Http\Controllers\CencTablasConsumoController')->middleware('can:cenc.tablaconsumo.inicio');
    Route::get('cenctablasconsumo/obtener-idequipotecnologia/{idEquipo}/{idTecnologia}', [App\Http\Controllers\CencTablasConsumoController::class, 'IdEquipoConsumible'])->name('cenctablasconsumo.obtener-idequipotecnologia');
    Route::get('cenctablasconsumo/obtener-idconsumibles/{idequipotecnologia}', [App\Http\Controllers\CencTablasConsumoController::class, 'IdConsumible'])->name('cenctablasconsumo.obtener-idconsumible'); 
    //FICHAS TECNICAS
    Route::resource('cencfichas','App\Http\Controllers\CencFichasController')->middleware('can:cenc.fichas.inicio');
    Route::resource('cencfichastipos','App\Http\Controllers\CencFichasTiposController')->middleware('can:cenc.fichas.tipos.inicio');
    Route::resource('cencfichascaracteristicas','App\Http\Controllers\CencFichasCaracteristicasController')->middleware('can:cenc.fichas.caracteristicas.inicio');
    Route::get('cencfichascaracteristicasp/{id}',[App\Http\Controllers\CencFichasCaracteristicasController::class, 'Caracteristicas'])->name('cencfichascaracteristicas');
    Route::get('cencfichasvalores/{id}',[App\Http\Controllers\CencFichasCaracteristicasController::class, 'FichaValores'])->name('cencfichascaracteristicas2');
    Route::delete('cenceliminarcaracteristica/{id}',[App\Http\Controllers\CencFichasController::class, 'EliminarCaracteristica'])->name('cenceliminarcaracteristica');
    Route::get('cenccaracteristicas/{id}',[App\Http\Controllers\CencFichasCaracteristicasController::class, 'Caracteristicas2'])->name('caracteristicas2');
    //CONAP
    Route::resource('cencconap','App\Http\Controllers\CencConapController')->middleware('can:cenc.conap.inicio');
    Route::delete('eliminardocumentoconap/{id}',[App\Http\Controllers\CencConapController::class, 'EliminarDocumentoConap'])->name('eliminardocumentoconap');
    //LISTA DE PARTES
    Route::resource('cenclistapartes','App\Http\Controllers\CencListaPartesController')->middleware('can:cenc.listapartes.inicio');
    Route::post('cenclistapartesAbrir/{lista}',[App\Http\Controllers\CencListaPartesController::class, 'activar'])->name('cenclistapartesAbrir')->middleware('can:cenc.listapartes.inicio');
    Route::get('listapartesresumenpdf/{idlistaparte}',[App\Http\Controllers\CencListaPartesController::class, 'ImprimirResumenListaPartes'])->name('listapartesresumenpdf')->middleware('can:cenc.listapartes.ver');
    Route::get('listapartesdetallepdf/{idlistaparte}',[App\Http\Controllers\CencListaPartesController::class, 'ImprimirDetalleListaPartes'])->name('listapartesdetallepdf');
    Route::delete('EliminarDetalleListaParte/{id}',[App\Http\Controllers\CencListaPartesController::class, 'EliminarDetalleListaParte'])->name('eliminardetallelistaparte')->middleware('can:cenc.listapartes.eliminar');
    //APROVECHAMIENTO
    Route::resource('cencaprovechamientos','App\Http\Controllers\CencAprovechamientosController')->middleware('can:cenc.aprovechamientos.inicio');
    Route::get('ListaParteConaps/{id}',[App\Http\Controllers\CencAprovechamientosController::class, 'ListaParteConaps'])->name('ListaParteConaps');
    Route::get('ListaParteEspesor/{IdConap}/{IdListaParte}/{IdEquipo}/{IdTecnologia}',[App\Http\Controllers\CencAprovechamientosController::class, 'ListaParteEspesor'])->name('ListaParteEspesor');
    Route::get('MaterialProcesado/{IdListaParte}/{espesor}',[App\Http\Controllers\CencAprovechamientosController::class, 'MaterialProcesado'])->name('MaterialProcesado');
    Route::post('cencaprovechamientosAbrir/{idAprov}',[App\Http\Controllers\CencAprovechamientosController::class, 'activar'])->name('cencaprovechamientosAbrir')->middleware('can:cenc.aprovechamientos.inicio');
    Route::get('cencaprovechamientos/obtener-tecnologias/{idEquipo}', [App\Http\Controllers\CencAprovechamientosController::class, 'TecnologiaEquipo'])->name('cencaprovechamientos.obtener-tecnologias');
    Route::delete('eliminardetallemateriaprima/{id}',[App\Http\Controllers\CencAprovechamientosController::class, 'eliminardetallemateriaprima'])->name('eliminardetallemateriaprima')->middleware('can:cenc.aprovechamientos.editar');
    Route::delete('eliminardetalleareacorte/{id}',[App\Http\Controllers\CencAprovechamientosController::class, 'eliminardetalleareacorte'])->name('eliminardetalleareacorte')->middleware('can:cenc.aprovechamientos.editar');
    Route::delete('eliminardocumentoaprovechamiento/{id}',[App\Http\Controllers\CencAprovechamientosController::class, 'eliminardocumentoaprovechamiento'])->name('eliminardocumentoaprovechamiento')->middleware('can:cenc.aprovechamientos.editar');
    Route::get('mostrarmateriaprima', [App\Http\Controllers\CencAprovechamientosController::class, 'MostrarMateriaPrima'])->name('mostrarmateriaprima');
    Route::post('aprovupdatestatus/{id}',[App\Http\Controllers\CencAprovechamientosController::class, 'UpdateStatus'])->name('aprovupdatestatus')->middleware('can:cenc.aprovechamientos.editar');
    Route::get('aprovechamientopdf/{idaprovechamiento}',[App\Http\Controllers\CencAprovechamientosController::class, 'ImprimirAprovechamiento'])->name('aprovechamientopdf');
    Route::post('aprovechamientovalidar/{idaprovechamiento}',[App\Http\Controllers\CencAprovechamientosController::class, 'ValidarAprovechamiento'])->name('aprovechamientovalidar');
    Route::post('aprovechamientoaprobar/{idaprovechamiento}',[App\Http\Controllers\CencAprovechamientosController::class, 'AprobarAprovechamiento'])->name('aprovechamientoaprobar');
    //ORDEN DE TRABAJO
    Route::resource('cencordentrabajo','App\Http\Controllers\CencOrdenTrabajoController');
    Route::get('cencordentrabajo/{IdOrdenTrabajo}',[App\Http\Controllers\CencOrdenTrabajoController::class,])->name('cencordentrabajo'); 
    Route::get('cencordentrabajopdf/{id}',[App\Http\Controllers\CencOrdenTrabajoController::class, 'ImprimirOrdenTrabajo'])->name('cencordentrabajopdf');
    Route::post('cencordentrabajofinalizar/{id}',[App\Http\Controllers\CencOrdenTrabajoController::class, 'FinalizarOrdenTrabajo'])->name('cencordentrabajofinalizar');
    Route::post('cencordentrabajoaceptar/{id}',[App\Http\Controllers\CencOrdenTrabajoController::class, 'AceptarOrdenTrabajo'])->name('cencordentrabajoaceptar');
    //SEGUIMIENTO
    Route::resource('cencseguimiento','App\Http\Controllers\CencSeguimientoController');
    Route::get('cencnumeroparte/{IdListaParte}/{IdListaPartePlancha}',[App\Http\Controllers\CencSeguimientoController::class, 'BuscarNumeroParte'])->name('cencnumeroparte'); 
    Route::get('cencseguimiento/{IdOrdenTrabajo}',[App\Http\Controllers\CencSeguimientoController::class,])->name('cencseguimiento'); 
    Route::delete('cenceliminardetallehorometro/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'EliminarDetalleHorometro'])->name('cenceliminardetallehorometro');
    Route::delete('cenceliminardetalleavance/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'EliminarDetalleAvance'])->name('cenceliminardetalleavance');
    Route::delete('cenceliminardetalleoxigeno/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'EliminarDetalleOxigeno'])->name('cenceliminardetalleoxigeno');
    Route::post('cencseguimientosfinalizar/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'FinalizarSeguimiento'])->name('cencseguimientosfinalizar');
    Route::get('cencseguimientopdf/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'ImprimirSeguimiento'])->name('cencseguimientopdf');
    Route::delete('cenceliminardetalleconsumible/{id}',[App\Http\Controllers\CencSeguimientoController::class, 'EliminarDetalleConsumible'])->name('cenceliminardetalleconsumible');

    //CIERRE
    Route::resource('cenccierre','App\Http\Controllers\CencCierreController');
    Route::get('cenccierrepdf/{id}',[App\Http\Controllers\CencCierreController::class, 'ImprimirCierre'])->name('cenccierrepdf');
    Route::delete('cenceliminardetallecortes/{id}',[App\Http\Controllers\CencCierreController::class, 'EliminarDetalleCortes'])->name('cenceliminardetallecortes');
    Route::delete('cenceliminardetallesobrante/{id}',[App\Http\Controllers\CencCierreController::class, 'EliminarDetalleSobrante'])->name('cenceliminardetallesobrante');
    /*** FIN DE CENTRO DE CORTE***/

    /*** RESGUARDO ***/
    
    //SOLICITUDES DE RESGUARDO
    Route::resource('resgsolicitudes','App\Http\Controllers\ResgSolicitudesController')->middleware('can:resg.solresguardo.inicio'); 
    Route::delete('resgeliminararticuloresguardo/{id_resguardo}',[App\Http\Controllers\ResgSolicitudesController::class, 'EliminarArticuloResguardo'])->name('resgeliminararticuloresguardo');
    Route::post('resgaprobarsolicitudresguardo/{id_solicitud_resguardo}',[App\Http\Controllers\ResgSolicitudesController::class, 'AprobarSolicitudResguardo'])->name('resgaprobarsolicitudresguardo');
    Route::post('resgprocesarsolicitudresguardo/{id_solicitud_resguardo}',[App\Http\Controllers\ResgSolicitudesController::class, 'ProcesarSolicitudResguardo'])->name('resgprocesarsolicitudresguardo');
    Route::get('resgbuscararticulos/{articulo}', [App\Http\Controllers\ResgSolicitudesController::class, 'BuscarArticulos'])->name('resgbuscararticulos');
    Route::get('resgimprimirsolicitudresguardo/{id_solicitud_resguardo}', [App\Http\Controllers\ResgSolicitudesController::class, 'ImprimirSolicitudResguardo'])->name('resgimprimirsolicitudresguardo');
    Route::post('resgimprimiretiquetasresguardo/{id_solicitud_resguardo}', [App\Http\Controllers\ResgSolicitudesController::class, 'ImprimirEtiquetasResguardo'])->name('resgimprimiretiquetasresguardo');

    //ARTICULOS EN RESGUARDO
    Route::resource('resgresguardos','App\Http\Controllers\ResgResguardosController')->middleware('can:resg.resguardos.inicio');
     
    //SOLICITUDES DE DESPACHO
    Route::resource('resgdespachos','App\Http\Controllers\ResgDespachosController')->middleware('can:resg.soldespacho.inicio'); 
    Route::delete('resgeliminararticulodespacho/{id_solicitud_despacho_detalle}',[App\Http\Controllers\ResgDespachosController::class, 'EliminarArticuloDespacho'])->name('resgeliminararticulodespacho');
    Route::get('resgarticulosalmacen/{id_almacen}', [App\Http\Controllers\ResgDespachosController::class, 'ArticulosAlmacen'])->name('resgarticulosalmacen');
    Route::post('resgaprobarsolicituddespacho/{id_solicitud_despacho}',[App\Http\Controllers\ResgDespachosController::class, 'AprobarSolicitudDespacho'])->name('resgaprobarsolicituddespacho');
    Route::post('resgprocesarsolicituddespacho/{id_solicitud_despacho}',[App\Http\Controllers\ResgDespachosController::class, 'ProcesarSolicitudDespacho'])->name('resgprocesarsolicituddespacho');
    Route::get('resgimprimirsolicituddespacho/{id_solicitud_despacho}', [App\Http\Controllers\ResgDespachosController::class, 'ImprimirSolicitudDespacho'])->name('resgimprimirsolicituddespacho');
    
    //SOLICITUDES DE DESINCORPORACION
    Route::resource('resgdesincorporaciones','App\Http\Controllers\ResgDesincorporacionController')->middleware('can:resg.soldesincorporacion.inicio'); 
    Route::delete('resgeliminararticulodesincorporacion/{id_sol_desinc_detalle}',[App\Http\Controllers\ResgDesincorporacionController::class, 'EliminarArticuloDesincorporacion'])->name('resgeliminararticulodesincorporacion');
    Route::get('resgarticulosdesincoporaralmacen/{id_almacen}', [App\Http\Controllers\ResgDesincorporacionController::class, 'ArticulosDesincorporarAlmacen'])->name('resgarticulosdesincoporaralmacen');
    Route::post('resgaprobarsolicituddesincorporacion/{id_solicitud_desincorporacion}',[App\Http\Controllers\ResgDesincorporacionController::class, 'AprobarSolicitudDesincorporacion'])->name('resgaprobarsolicituddesincorporacion');
    Route::post('resgprocesarsolicituddesincorporacion/{id_solicitud_desincorporacion}',[App\Http\Controllers\ResgDesincorporacionController::class, 'ProcesarSolicitudDesincorporacion'])->name('resgprocesarsolicituddesincorporacion');
    Route::get('resgimprimirsolicituddesincorporacion/{id_solicitud_desincorporacion}', [App\Http\Controllers\ResgDesincorporacionController::class, 'ImprimirSolicitudDesincorporacion'])->name('resgimprimirsolicituddesincorporacion');

    //CLASIFICACIONES 
    Route::resource('resgclasificaciones','App\Http\Controllers\ResgClasificacionesController')->middleware('can:resg.clasificaciones.inicio'); 
    
    //UBICACIONES
    Route::resource('resgubicaciones','App\Http\Controllers\ResgUbicacionesController')->middleware('can:resg.ubicaciones.inicio'); 

    /*** FIN RESGUARDO ***/

    /*** GESTION DE ASISTENCIA ***/
    // DASHBOARD
    Route::get('gstadashboard',[App\Http\Controllers\InicioController::class, 'DashboardGestionAsistencia'])->name('gstadashboard');
    //HORARIOS
    Route::resource('gstahorarios','App\Http\Controllers\GstaHorarioController')->middleware('can:gsta.horarios.inicio'); 
    //EMPLEADOS
    Route::resource('gstaempleados','App\Http\Controllers\GstaEmpleadosController')->middleware('can:gsta.empleados.inicio');; 
    Route::get('gstaempleadosasignar/{id_empleado}',[App\Http\Controllers\GstaEmpleadosController::class, 'Asignar'])->name('gstaempleadosasignar'); 
    //NOVEDADES
    Route::resource('gstanovedades','App\Http\Controllers\GstaNovedadesController')->middleware('can:gsta.novedades.inicio');; 
    //ASISTENCIA GENERAL
    Route::resource('gstaasistencias','App\Http\Controllers\GstaAsistenciaController')->middleware('can:gsta.asistencias.inicio'); 

    //VALIDACION ASISTENCIA
    Route::resource('gstaasistenciasvalidaciones','App\Http\Controllers\GstaAsistenciaValidacionController')->middleware('can:gsta.validacionasistencias.crear'); 
    Route::get('gstalistadovalidaciones',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ListadoValidacionEditar'])->name('gstalistadovalidacioneseditar')->middleware('can:gsta.validacionasistencias.editar'); 
    Route::post('gstaeditarvalidaciones',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'EditarValidacion'])->name('gstaeditarvalidacion'); 
    Route::get('gstareportevalidacionfinal',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ImprimirValidacionesFinal'])->name('gstareportevalidacionfinal'); 
    Route::get('gstareportevalidacioninicial',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ImprimirValidacionesInicial'])->name('gstareportevalidacioninicial'); 
    Route::get('gstareportevalidaciondiaria',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ImprimirValidacionesDiaria'])->name('gstareportevalidaciondiaria'); 
    Route::get('gstareportehoras',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ImprimirHorasTrabajadas'])->name('gstareportehoras'); 
    Route::get('gstareportehorasrango',[App\Http\Controllers\GstaAsistenciaValidacionController::class, 'ImprimirHorasTrabajadasRango'])->name('gstareportehorasrango'); 
    /*** FIN GESTION DE ASISTENCIA ***/
    
    /*** AUDITORIA ***/

    //AUDITORIA INVENTARIO
    Route::resource('audiauditoriainventario','App\Http\Controllers\AudiAuditoriaInventarioController')->middleware('can:audi.auditoriainventario.inicio'); 
    /*** FIN AUDITORIA ***/

    /*** CONTROL DE COMBUSTIBLE ***/

    // SOLICITUD DE DESPACHO
    Route::resource('cntcdespachos','App\Http\Controllers\CntcDespachosController')->middleware('can:cntc.despachos.inicio'); 
    Route::get('cntcaceptarsolicituddespacho/{id_solicitud_despacho}',[App\Http\Controllers\CntcDespachosController::class, 'AceptarSolicitudDespacho'])->name('cntcaceptarsolicituddespacho')->middleware('can:cntc.despachos.aceptar');
    Route::get('cntcdespacharsolicituddespacho/{id_solicitud_despacho}',[App\Http\Controllers\CntcDespachosController::class, 'Despachar'])->name('cntcdespacharsolicituddespacho')->middleware('can:cntc.despachos.despachar');
    Route::post('cntcprocesarsolicituddespachos/{id_solicitud_despacho}',[App\Http\Controllers\CntcDespachosController::class, 'ProcesarSolicitudDespacho'])->name('cntcprocesarsolicituddespachos')->middleware('can:cntc.despachos.despachar');
    //INGRESOS
    Route::resource('cntcingresos','App\Http\Controllers\CntcIngresosController')->middleware('can:cntc.ingresos.inicio'); 
    //TIPOS INGRESOS
    Route::resource('cntctiposingresos','App\Http\Controllers\CntcTiposIngresosController')->middleware('can:cntc.tiposingresos.inicio');
    //TIPOS COMBUSTIBLES
    Route::resource('cntctiposcombustible','App\Http\Controllers\CntcTiposCombustiblesController')->middleware('can:cntc.tiposcombustibles.inicio'); 
    //DASHBOARD
    Route::get('cntcdashboard',[App\Http\Controllers\InicioController::class, 'DashboardControlCombustible'])->name('cntcdashboard')->middleware('can:cntc.dashboard');
    //REPORTES DESPACHOS
    Route::get('cntcreportecombustibledetallevehiculos',[App\Http\Controllers\ReportesController::class, 'CntcReporteDespachosVehiculos'])->name('cntcreportecombustibledetallevehiculos')->middleware('can:repo.cntc.despacho.detalle.vehiculos');
    Route::get('cntcreportecombustibledetalledepartamentos',[App\Http\Controllers\ReportesController::class, 'CntcReporteDespachosDepartamentos'])->name('cntcreportecombustibledetalledepartamentos')->middleware('can:repo.cntc.despacho.detalle.departamentos');
    Route::get('cntcreportecombustibledespachoanual',[App\Http\Controllers\ReportesController::class, 'CntcReporteAnualDespachos'])->name('cntcreportecombustibledespachoanual')->middleware('can:repo.cntc.despacho.anual.vehiculos');
    Route::get('cntcreportecombustibledespachoanualequipos',[App\Http\Controllers\ReportesController::class, 'CntcReporteAnualDespachosEquipos'])->name('cntcreportecombustibledespachoanualequipos')->middleware('can:repo.cntc.despacho.anual.departamentos');  
    //REPORTES INGRESOS
    Route::get('cntcreportecombustibleingreso',[App\Http\Controllers\ReportesController::class, 'CntcReporteIngresos'])->name('cntcreportecombustibleingreso')->middleware('can:repo.cntc.ingreso.detalle');  
    Route::get('cntcreportecombustibleingresoanual',[App\Http\Controllers\ReportesController::class, 'CntcReporteAnualIngresos'])->name('cntcreportecombustibleingresoanual')->middleware('can:repo.cntc.ingreso.anual');   

    /*** FIN CONTROL DE COMBUSTIBLE ***/

    /*** CONTROL DE TONER ***/
    Route::resource('cnttcontroltoner','App\Http\Controllers\CnttControlTonerController')->middleware('can:cntt.controltoner.inicio');
    Route::get('cnttimpresoras',[App\Http\Controllers\CnttControlTonerController::class, 'getImpresoras'])->name('cnttimpresoras');
    Route::get('cnttultimoservicio',[App\Http\Controllers\CnttControlTonerController::class, 'getUltimoServicio'])->name('cnttultimoservicio');
    //REPORTES
    Route::get('cnttdashboard',[App\Http\Controllers\InicioController::class, 'DashboardControlToner'])->name('cnttdashboard')->middleware('can:cntt.dashboard');
    Route::get('cnttreporte',[App\Http\Controllers\ReportesController::class, 'CnttReporteToner'])->name('cnttreporte');
    /*** FIN CONTROL DE TONER ***/

    /*** EMBARCACIONES ***/
    //UNIDADES
    Route::resource('embaunidades','App\Http\Controllers\EmbaUnidadesController')->middleware('can:emba.unidades.inicio');
    //PARAMETROS
    Route::resource('embaparametros', 'App\Http\Controllers\EmbaParametrosController')->middleware('can:emba.parametros.inicio');
    //EMBARCACIONES
      Route::resource('embaembarcaciones','App\Http\Controllers\EmbaEmbarcacionesController')->middleware('can:emba.embarcaciones.inicio');
    //NOVEDADES
    Route::resource('embanovedades', 'App\Http\Controllers\EmbaNovedadesController')->middleware('can:emba.novedades.inicio');
    //MAQUINAS
    Route::resource('embamaquinas', 'App\Http\Controllers\EmbaMaquinasController')->middleware('can:emba.maquinas.inicio');
    Route::delete('embaeliminarmaquinaparametro/{id_maquina_parametro}',[App\Http\Controllers\EmbaMaquinasController::class, 'EliminarParametros'])->name('embaeliminarmaquinaparametro');
    Route::get('embamaquinaparametros/{id_maquina}',[App\Http\Controllers\EmbaMaquinasController::class, 'MaquinaParametros'])->name('embamaquinaparametros');
    //REGISTRO PARAMETROS
    Route::resource('embaregistrosparametros', 'App\Http\Controllers\EmbaRegistrosParametrosController')->middleware('can:emba.registroparametros.inicio');
    Route::get('embadatoscrearregistroparametros/{id_maquina}/{fecha}',[App\Http\Controllers\EmbaRegistrosParametrosController::class, 'DatosCrearRegistroParametros'])->name('embadatoscrearregistroparametros');
    Route::get('embabuscarregistroparametros/{id_maquina}/{fecha}',[App\Http\Controllers\EmbaRegistrosParametrosController::class, 'BuscarRegistroParametros'])->name('embadatoseditarregistroparametros');
    Route::get('embabuscarobservacionesregistroparametros/{id_maquina}/{fecha}',[App\Http\Controllers\EmbaRegistrosParametrosController::class, 'BuscarObservacionesRegistroParametros'])->name('embabuscarobservacionesregistroparametros');
    Route::get('embaregistroparametrospdf/{id_maquina}/{fecha}',[App\Http\Controllers\EmbaRegistrosParametrosController::class, 'RegistroParametrosPDF'])->name('embaregistroparametrospdf');
    //DASHBOARD
    Route::get('embadashboard',[App\Http\Controllers\InicioController::class, 'DashboardEmbarcaciones'])->name('embadashboard')->middleware('can:emba.dashboard');
    
    /*** FIN EMBARCACIONES ***/

    /*** REPORTES ****/

    //FICHATECNICA
    Route::get('fichatecnica/{id}',[App\Http\Controllers\FictArticulosController::class, 'pdf'])->name('fichatecnica');
    Route::get('replistadoarticuloubicaciones',[App\Http\Controllers\ReportesController::class, 'FictArticuloUbicacion'])->name('replistadoarticuloubicaciones')->middleware('can:repo.fict.listadoarticuloubicaciones');
    Route::get('repofechasfichastecnicas',[App\Http\Controllers\ReportesController::class, 'FictFechasFichasTecnicas'])->name('repofechasfichastecnicas')->middleware('can:repo.fict.fechasfichastecnicas');
    Route::get('repcatalogacion',[App\Http\Controllers\ReportesController::class, 'FictCatalogacion'])->name('repcatalogacion')->middleware('can:repo.fict.catalogacion');

    //CONTROL DE HERRAMIENTAS
    Route::get('repestatusdespacho',[App\Http\Controllers\ReportesController::class, 'CnthEstatusDespacho'])->name('repestatusdespacho')->middleware('can:repo.cnth.listadoestatusdespacho');
    Route::get('repestatusdespachopdf',[App\Http\Controllers\ReportesController::class, 'CnthEstatusDespacho'])->name('repestatusdespachopdf')->middleware('can:repo.cnth.listadoestatusdespacho.pdf');
    //Reporte de stock de herramientas
    Route::get('repherramientastock',[App\Http\Controllers\ReportesController::class, 'CnthHerramientasStock'])->name('repherramientastock')->middleware('can:repo.cnth.listadoherramientas');
    Route::get('repherramientasalmacen/{id}',[App\Http\Controllers\CnthHerramientasController::class, 'HerramientasAlmacen'])->name('repherramientasalmacen');//buscar las herramientas de ese almacen
    Route::get('repherramientastockpdf',[App\Http\Controllers\ReportesController::class, 'CnthHerramientasStock'])->name('repherramientastockpdf')->middleware('can:repo.cnth.listadoherramientas.pdf');
    Route::get('repoplantillasalmacen',[App\Http\Controllers\ReportesController::class, 'CnthPlantillasAlmacen'])->name('repoplantillasalmacen')->middleware('can:repo.cnth.plantillasalmacenes');

    //AUTORIZACION DE SALIDAS
    Route::get('imprimirautorizacionsalidas/{idsalida}',[App\Http\Controllers\AsalSalidasController::class, 'imprimir'])->name('imprimirautorizacionsalidas');//imprimir
    Route::get('imprimirautorizacionsalidas2/{idsalida}',[App\Http\Controllers\AsalSalidasController::class, 'ImprimirLargo'])->name('imprimirautorizacionsalidas2');//imprimir
    Route::get('replistadosalidas',[App\Http\Controllers\ReportesController::class, 'AsalListadoSalidas'])->name('replistadosalidas')->middleware('can:repo.asal.listadosalidas');
    Route::get('replistadosalidasauditoria',[App\Http\Controllers\ReportesController::class, 'AsalListadoAuditoria'])->name('replistadosalidasauditoria')->middleware('can:repo.asal.listadosalidasauditoria');
    Route::get('replistadosalidasauditoriapdf',[App\Http\Controllers\ReportesController::class, 'AsalListadoAuditoria'])->name('replistadosalidasauditoriapdf')->middleware('can:repo.asal.listadosalidasauditoria.pdf');
    

    // GESTION ASISTENCIA
    Route::get('gstareportevalidaciones',[App\Http\Controllers\ReportesController::class, 'ListadoValidaciones'])->name('gstareportevalidaciones')->middleware('can:repo.gestionasistencia.validaciones'); 
    Route::get('repohorasvalidaciones',[App\Http\Controllers\ReportesController::class, 'ListadoHoras'])->name('repohorasvalidaciones')->middleware('can:repo.gestionasistencia.horasextras'); 
   

    //SOLICITUDES SERVICIOS
    Route::get('solicitudes/imprimir/solicitud/{idsolicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'ImprimirSolicitud'])->name('solicitudes/imprimir/solicitud');//imprimir solicitud
    Route::get('solsimprimirot/{idsolicitud}',[App\Http\Controllers\SolsSolicitudesController::class, 'ImprimirSolicitudOt'])->name('solsimprimirot');//imprimir ot
    Route::get('reposolicitudeslogistica',[App\Http\Controllers\ReportesController::class, 'SolsLogistica'])->name('reposolicitudeslogistica')->middleware('can:repo.solicitudes');
    Route::get('reposolicitudesdepartamentos',[App\Http\Controllers\ReportesController::class, 'SolsDepartamentos'])->name('reposolicitudesdepartamentos')->middleware('can:repo.solicitudes');
  
    //ACTIVOS 
    Route::get('repolistadoactivos',[App\Http\Controllers\ReportesController::class, 'ActvListadoActivos'])->name('repolistadoactivos')->middleware('can:repo.activos.listadoactivos');
    
    //COMPRAS
    Route::get('reposolpestadoaprobacion',[App\Http\Controllers\ReportesController::class, 'CompSolpEstadoAprobacion'])->name('reposolpestadoaprobacion')->middleware('can:repo.compras.solpestadosaprobacion');
    Route::get('reposolpasignadacomprador',[App\Http\Controllers\ReportesController::class, 'CompSolpAsignadaComprador'])->name('reposolpasignadacomprador')->middleware('can:repo.compras.solpasignadacomprador');
    Route::get('reposolpdepartamentos',[App\Http\Controllers\ReportesController::class, 'CompSolpDepartamentos'])->name('reposolpdepartamentos')->middleware('can:repo.compras.solpdepartamentos');
    Route::get('reposolpestatus',[App\Http\Controllers\ReportesController::class, 'CompSolpEstatus'])->name('reposolpestatus')->middleware('can:repo.compras.solpestatus');
    Route::get('repoproductividadcomprador',[App\Http\Controllers\ReportesController::class, 'CompProductividadComprador'])->name('repoproductividadcomprador')->middleware('can:repo.compras.productividadcomprador');
    Route::get('reposeguimientosolpocndr',[App\Http\Controllers\ReportesController::class, 'CompSeguimientoSolpOcNdr'])->name('reposeguimientosolpocndr')->middleware('can:repo.compras.seguimientosolpndroc');
    Route::get('repohistorialcompras',[App\Http\Controllers\ReportesController::class, 'CompHistorialCompras'])->name('repohistorialcompras')->middleware('can:repo.compras.historialcompras');
    
    //SOLP
    Route::get('reposolpdetalle/{empresa}/{solp}',[App\Http\Controllers\ReportesController::class, 'CompSolpDetalle'])->name('reposolpdetalle')->middleware('can:repo.compras.solpestadosaprobacion');
    Route::post('compguardaraprobacionsolp',[App\Http\Controllers\ReportesController::class, 'CompAprobacionSolp'])->name('compguardaraprobacionsolp') ;
    Route::post('compasignarcompradorsolp',[App\Http\Controllers\ReportesController::class, 'CompAsignarCompradorSolp'])->name('compasignarcompradorsolp') ;
    
    //SALIDAS PROFIT
    Route::get('reposalidasarticulodepartamento',[App\Http\Controllers\ReportesController::class, 'SalidasArticulosDepartamentoAño'])->name('reposalidasarticulodepartamento'); //->middleware('can:repo.compras.solpestadosaprobacion');
    
    //RESGUARDO
    Route::get('repoarticulosresguardo',[App\Http\Controllers\ReportesController::class, 'ResgArticulosResguardo'])->name('repoarticulosresguardo')->middleware('can:repo.resg.articulosresguardo');
     
    //AUDITORIA
    /*** FIN REPORTES ***/
    
    /*** CONFIGURACION ***/

    //PAISES
    Route::resource('paises','App\Http\Controllers\PaisesController')->middleware('can:conf.paises.inicio');

    //EMPRESAS
    Route::resource('empresas','App\Http\Controllers\EmpresasController')->middleware('can:conf.empresas.inicio');
    
    //DEPARTAMENTOS
    Route::resource('departamentos','App\Http\Controllers\FictDepartamentosController')->middleware('can:conf.departamentos.inicio');
    
    //PERMISOS
    Route::resource('permisos','App\Http\Controllers\PermisosController')->middleware('can:conf.permisos.inicio');
    Route::resource('perfiles','App\Http\Controllers\RolesController')->middleware('can:conf.perfiles.inicio');
    
    //CORREOS
    Route::resource('correos','App\Http\Controllers\CorreosController')->middleware('can:conf.usuarioscorreos.inicio');

    //ALMACENES
    Route::resource('almacenes','App\Http\Controllers\FictAlmacenesController')->middleware('can:conf.almacenes.inicio');

    //SUBALMACENES
    Route::resource('subalmacenes','App\Http\Controllers\FictSubalmacenesController')->middleware('can:conf.subalmacenes.inicio');
    
    //USUARIOS
    Route::resource('usuarios','App\Http\Controllers\UsuariosController')->middleware('can:conf.usuarios.inicio');
    Route::delete('eliminaralmacenes/{id}',[App\Http\Controllers\UsuariosController::class, 'EliminarAlmacenes'])->name('eliminaralmacenes');
    Route::delete('eliminarembarcaciones/{id}',[App\Http\Controllers\UsuariosController::class, 'EliminarEmbarcaciones'])->name('eliminarembarcaciones');
    Route::get('almacenesempresa/{id}',[App\Http\Controllers\UsuariosController::class, 'AlmacenesEmpresa'])->name('almacenesempresa');

    Route::get('perfil',[App\Http\Controllers\UsuariosController::class, 'perfil'])->name('perfil');
    Route::post('perfilupdate',[App\Http\Controllers\UsuariosController::class, 'perfilupdate'])->name('perfilupdate');
    
    /*** FIN CONFIGURACION  ***/
});
    //RUTAS SIN LOGUEO
    Route::resource('auth','App\Http\Controllers\AuthController');
    Route::get('login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

