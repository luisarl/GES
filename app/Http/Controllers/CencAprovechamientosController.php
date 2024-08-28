<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencAprovechamientosCreateRequest;
use App\Http\Requests\CencAprovechamientosUpdateRequest;
use App\Models\Cenc_Conap_DocumentosModel;
use App\Models\Cenc_Aprovechamiento_PlanchasModel;
use App\Models\Cenc_Aprovechamiento_Plancha_Materia_PrimaModel;
use App\Models\Cenc_Aprovechamiento_Plancha_Area_CorteModel;
use App\Models\Cenc_AprovechamientoModel;
use App\Models\Cenc_EquiposTecnologiaModel;
use App\Models\Cenc_TablasConsumoModel;
use App\Models\Cenc_Aprovechamiento_DocumentosModel;
use App\Models\Cenc_OrdenTrabajoModel;
use App\Models\Cenc_OrdenTrabajo_PlanchasModel;
use App\Models\Cenc_SeguimientoModel;
use Illuminate\Http\Request;
use App\Models\Cenc_ConapModel;
use App\Models\Cenc_EquiposModel;
use App\Models\Cenc_ListaPartesModel;
use App\Models\Cenc_TecnologiaModel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use DateTime;


class CencAprovechamientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conaps  = Cenc_ConapModel::ListaConaps();
        $aprovechamiento = Cenc_AprovechamientoModel::Aprovechamientos();
        return view('CentroCorte.Aprovechamientos.Aprovechamientos', compact('conaps', 'aprovechamiento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conaps = Cenc_ConapModel::ListaConaps();
        $ListaPartes = Cenc_ListaPartesModel::ListaPartes();
        $equipos = Cenc_EquiposModel::ListaEquipos();
        $tecnologias = Cenc_TecnologiaModel::ListaTecnologias();
        $materias = Cenc_Aprovechamiento_PlanchasModel::ListaMateriaPrima();
        return view('CentroCorte.Aprovechamientos.AprovechamientosCreate', compact('conaps', 'ListaPartes', 'equipos', 'tecnologias', 'materias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencAprovechamientosCreateRequest $request)
    {
        $data = json_decode($request['_caracteristicas']);
        $MateriaPrima = $data->materia_prima;
        $AreaCorte = $data->area_corte;
        $id_aprovechamiento = Cenc_AprovechamientoModel::max('id_aprovechamiento') + 1;

        if ($MateriaPrima  == NULL || $AreaCorte  == NULL) 
        {
            return back()->withErrors(['caracteristicas' => 'Para registrar un aprovechamiento debe ingresar materia prima y area de corte'])->withInput();
        }
        try {
            DB::transaction(function () use ($request) 
            {
                $IdUsuario = Auth::user()->id;
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
                $data = json_decode($request['_caracteristicas']);
                $lista_datos = $data->lista_datos;
                $materias_prima = $data->materia_prima;
                $area_cortes = $data->area_corte;
                $observacion = $data->observaciones;
                $antorcha = 0;
                $boquilla = 0;

                foreach ($observacion as $text) 
                {
                    $observaciones = $text->observaciones_aprov;
                }
                // 1. tabla aprovechamientos $lista_datos[0]->IdListaParte
                $id_aprovechamiento = Cenc_AprovechamientoModel::max('id_aprovechamiento') + 1;
                Cenc_AprovechamientoModel::create([
                    'id_aprovechamiento'    => $id_aprovechamiento,
                    'id_lista_parte'        => intval($lista_datos[0]->IdListaParte),
                    'estatus'               => 'POR VALIDAR',
                    'creado_por'            => $IdUsuario,
                    'fecha_creado'          => $FechaActual
                ]);

                // 2. tabla aprovechamiento_plancha 
                if ($lista_datos[0]->antorcha == "Seleccione Antorcha") 
                {
                    $antorcha = NULL;
                } 
                else 
                {
                    $antorcha = $lista_datos[0]->antorcha;
                }

                $boquilla = NULL;
                if ($lista_datos[0]->numero_boquilla != "Seleccione Boquilla") 
                {
                    $boquilla = $lista_datos[0]->numero_boquilla;
                } 
                elseif ($lista_datos[0]->numero_boquilla2 != "Seleccione Boquilla") 
                {
                    $boquilla = $lista_datos[0]->numero_boquilla2;
                }

                $id_aprovechamiento_placha = Cenc_Aprovechamiento_PlanchasModel::max('id_aprovechamiento_plancha') + 1;
                Cenc_Aprovechamiento_PlanchasModel::create([
                    'id_aprovechamiento_plancha' => $id_aprovechamiento_placha,
                    'id_aprovechamiento'         => $id_aprovechamiento,
                    'nombre_equipo'              => $lista_datos[0]->equipocorte,
                    'nombre_tecnologia'          => $lista_datos[0]->tecnologia,
                    'espesor'                    => $lista_datos[0]->espesor,
                    'longitud_corte'             => $lista_datos[0]->longitud_corte,
                    'numero_piercing'            => $lista_datos[0]->numero_piercing,
                    'tiempo_estimado'            => $lista_datos[0]->tiempo_estimado_corte,
                    'juego_antorcha'             => $antorcha,
                    'numero_boquilla'            => $boquilla,
                    'precalentamiento'           => $lista_datos[0]->precalentamiento,
                    'tiempo_precalentamiento'    => (int)$lista_datos[0]->tiempo_precalentamiento,
                    'observaciones'              => $observaciones,
                ]);

                // 3. tabla aprovechamiento_plancha_materia prima
                foreach ($materias_prima as $materia_prima) 
                {
                    $id_materia_prima = Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::max('id_materia_prima') + 1;
                    Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::create([
                        'id_materia_prima'      =>  $id_materia_prima,
                        'codigo_materia'        =>  $materia_prima->codigo_materia,
                        'dimensiones'           =>  $materia_prima->dimensiones_materia,
                        'cantidad'              =>  $materia_prima->cantidad_materia,
                        'peso_unit'             =>  $materia_prima->pesounitario_materia,
                        'peso_total'            =>  $materia_prima->pesototal_materia,
                        'id_aprovechamiento_plancha'    =>  $id_aprovechamiento_placha
                    ]);
                }

                foreach ($area_cortes as $area_corte) 
                {
                    $id_area_corte = Cenc_Aprovechamiento_Plancha_Area_CorteModel::max('id_area_corte') + 1;
                    Cenc_Aprovechamiento_Plancha_Area_CorteModel::create([
                        'id_area_corte'     =>  $id_area_corte, //pk
                        'dimensiones'       =>  $area_corte->dimensiones_corte,
                        'cantidad'          =>  $area_corte->cantidad_corte,
                        'peso_unit'         =>  $area_corte->pesounitario_corte,
                        'peso_total'        =>  $area_corte->pesototal_corte,
                        'id_aprovechamiento_plancha' =>  $id_aprovechamiento_placha //fk
                    ]);
                }

                //CREA LA CARPETA DONDE SE GUARDARAN LOS ARCHIVOS DE LA SOLICITUD 
                $destino = "documents/Aprovechamientos/";
                $NombreCarpeta = $id_aprovechamiento;
                $Ruta = public_path($destino . $NombreCarpeta);

                if (!File::exists($Ruta)) 
                {
                    File::makeDirectory($Ruta, 0777, true);
                }

                if ($request->hasFile('documentos')) 
                {
                    $PosseDocumentos = 'SI';
                } 
                else 
                {
                    $PosseDocumentos = 'NO';
                }

                //INSERTA EN APROVECHAMIENTO DOCUMENTOS
                if ($PosseDocumentos == 'SI') 
                {
                    $documentos = $request->file('documentos');
                    foreach ($documentos as $documento) 
                    {
                        $destino = "documents/Aprovechamientos/" . $id_aprovechamiento . "/";
                        $NombreDocumento = $documento->getClientOriginalName();
                        $TipoDocumento = $documento->getClientOriginalExtension();
                        $documento->move($destino, $NombreDocumento);

                        $IdDocumento =  Cenc_Aprovechamiento_DocumentosModel::max('id_aprovechamiento_documento') + 1;
                        //GUARDA EN LA TABLA SOLICITUDES DOCUMENTOS
                        Cenc_Aprovechamiento_DocumentosModel::create([
                            'id_aprovechamiento_documento' => $IdDocumento,
                            'id_aprovechamiento' => $id_aprovechamiento,
                            'nombre_documento' => $NombreDocumento,
                            'ubicacion_documento' => $destino . $NombreDocumento,
                            'tipo_documento' => $TipoDocumento,
                        ]);
                    }
                }
            });
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al crear el Aprovechamiento ' . $ex->getMessage())->withInput();
        }
        return redirect()->route('cencaprovechamientos.show', $id_aprovechamiento)->withSuccess('Se Ha Creado Exitosamente');
    }

    public function buscarEspesor($aprov)
    {
        $espesorBD = number_format($aprov->espesor, 2, '.', '');
        $separador = ".";
        $divido = explode($separador, $espesorBD);

        if ($divido[1] == 0) 
        {
            $espesor = $divido[0];
        } 
        else 
        {
            $espesor = floatval($espesorBD);
        }

        return $espesor;
    }

    public function calcularOxicorte($aprov)
    {
        $espesor = $this->buscarEspesor($aprov);
        $numero_piercing = $aprov->numero_piercing;
        $tiempo_precalentamiento = $aprov->tiempo_precalentamiento;
        $longitud = $aprov->longitud_corte;
        $tecnologia = $aprov->nombre_tecnologia;
        $equipo = $aprov->nombre_equipo;
        $precalentamiento = $aprov->precalentamiento;

        $Velocidad = Cenc_TablasConsumoModel::buscarVelocidadCorte($espesor, $tecnologia);

        $VelocidadCorte = $Velocidad->valor;

        // 1- TIEMPO EFECTIVO DE CORTE 
        $TiempoEfectivoCorteMinutos = floatval($longitud) / floatval($VelocidadCorte);
        $TiempoEfectivoCorteHoras = $TiempoEfectivoCorteMinutos * 1 / 60;

        // 2- TIEMPO DE PRECALENTAMIENTO POR ENTRADAS (Numero de Piercing y Nro de Entradas es lo mismo)
        $TiempoPrecalentamientoEntradasSegundos = $numero_piercing * $tiempo_precalentamiento;
        $TiempoPrecalentamientoEntradasMinutos = $TiempoPrecalentamientoEntradasSegundos / 60;

        // 3- CONSUMO DE OXIGENO PRECALENTAMIENTO POR ENTRADAS O NUMERO DE PIERCING
        $ConsumoOxigenoPreca = Cenc_TablasConsumoModel::buscarConsumoOxigenoPrecalentando($espesor, $tecnologia);
        $ConsumoOxigenoPrecalentando = $ConsumoOxigenoPreca->valor;
        $ConsumoOxigenoPorEntradas = $TiempoPrecalentamientoEntradasMinutos * $ConsumoOxigenoPrecalentando; //𝑚3
        $ConsumoOxigenoPorEntradasLitros = $ConsumoOxigenoPorEntradas * 1000;

        // 4- CONSUMO DE OXIGENO PRECALENTAMIENTO CONTINUO
        if ($precalentamiento == 'Si') 
        {
            $ConsumoOxigenoContinuo = $TiempoEfectivoCorteMinutos * $ConsumoOxigenoPrecalentando; //𝑚3
            $ConsumoOxigenoContinuoLitros = $ConsumoOxigenoContinuo * 1000;
        } 
        else 
        {
            $ConsumoOxigenoContinuo = 0;
            $ConsumoOxigenoContinuoLitros = 0;
        }

        // 5- CONSUMO DE OXIGENO DE CORTE 
        $ConsumoOxigenoCort = Cenc_TablasConsumoModel::buscarConsumoOxigenoCortando($espesor, $tecnologia);
        $ConsumoOxigenoCortando = $ConsumoOxigenoCort->valor;
        $ConsumoOxigenoCorte = $TiempoEfectivoCorteMinutos * $ConsumoOxigenoCortando;
        $ConsumoOxigenoCorteLitros = $ConsumoOxigenoCorte * 1000;

        // 6- CONSUMO DE GAS BUTANO O PROPANO (utilizan la misma formula para los 2)
        $ConsumoGases = Cenc_TablasConsumoModel::buscarConsumoGas($espesor, $tecnologia);
        $ConsumoGasButano = $ConsumoGases->valor;
        $ConsumoGasCorte = $TiempoEfectivoCorteMinutos *  $ConsumoGasButano;
        $ConsumoGasCorteLitros = $ConsumoGasCorte * 1000;

        // 7- CONSUMOS TOTALES DE OXIGENO Y GASES
        $ConsumoTotalOxigeno = $ConsumoOxigenoPorEntradas + $ConsumoOxigenoContinuo + $ConsumoOxigenoCorte;
        $ConsumoTotalOxigenoLitros = $ConsumoTotalOxigeno * 1000;
        //El total consumo de gas es el mismo de Consumo de Gas Corte
        // 8- Kilos de Gas Butano (Litros de gas butano/447,73)
        $KilosGasButano = $ConsumoGasCorteLitros / 447.73;
        // 9- NUMERO DE CILINDROS DE OXIGENO
        $NumeroCilidrosOxigeno = $ConsumoTotalOxigenoLitros / 6000;
        // 10- NUMERO DE CILINDRO DE GAS
        $NumeroCilidrosGas = $ConsumoGasCorteLitros / 8059.14;
        return compact(
            'VelocidadCorte',
            'TiempoEfectivoCorteMinutos',
            'TiempoEfectivoCorteHoras',
            'TiempoPrecalentamientoEntradasSegundos',
            'TiempoPrecalentamientoEntradasMinutos',
            'ConsumoOxigenoPorEntradas',
            'ConsumoOxigenoPorEntradasLitros',
            'ConsumoOxigenoContinuo',
            'ConsumoOxigenoContinuoLitros',
            'ConsumoOxigenoCorte',
            'ConsumoOxigenoCorteLitros',
            'ConsumoGasCorte',
            'ConsumoGasCorteLitros',
            'ConsumoTotalOxigeno',
            'ConsumoTotalOxigenoLitros',
            'KilosGasButano',
            'NumeroCilidrosOxigeno',
            'NumeroCilidrosGas',
        );
    }

    public function calcularPlasma($aprov)
    {
        $espesor = $this->buscarEspesor($aprov);
        $longitud = $aprov->longitud_corte;
        $idrango = Cenc_TablasConsumoModel::idTablafiltroAntorcha($espesor, $aprov->juego_antorcha);
        $VelocidadCorte = Cenc_TablasConsumoModel::rangodevalores($idrango->id_tabla_consumo);

        // 1- TIEMPO EFECTIVO DE CORTE 
        $TiempoEfectivoCorteMinutos = floatval($longitud) / floatval($VelocidadCorte[0]->valor);
        $TiempoEfectivoCorteHoras = $TiempoEfectivoCorteMinutos * 1 / 60;

        // 2- CONSUMO DE OXIGENO DE CORTE 
        $rangoFlujo = Cenc_TablasConsumoModel::buscarRangoFlujo($idrango->id_tabla_consumo);
        $ConsumoOxigenoPlasmaLitros = (int)$rangoFlujo[1]->valor * $TiempoEfectivoCorteMinutos;
        $ConsumoOxigenoPlasmaM3 = $ConsumoOxigenoPlasmaLitros * 0.0001;

        // 3- PORCENTAJE DE DESPERDICIO
        $PorcentajeDesperdicioLitros = (0.2 * $ConsumoOxigenoPlasmaLitros) + $ConsumoOxigenoPlasmaLitros;
        $PorcentajeDesperdicioM3 = $PorcentajeDesperdicioLitros * 0.0001;

        // 4- NUMERO DE CILINDROS DE OXIGENO
        $NumeroCilidrosOxigeno = $PorcentajeDesperdicioM3 / 6;

        return view(
            'CentroCorte.Aprovechamientos.AprovechamientosShow',
            compact(
                'VelocidadCorte',
                'TiempoEfectivoCorteMinutos',
                'TiempoEfectivoCorteHoras',
                'ConsumoOxigenoPlasmaLitros',
                'ConsumoOxigenoPlasmaM3',
                'PorcentajeDesperdicioLitros',
                'PorcentajeDesperdicioM3',
                'NumeroCilidrosOxigeno',
            )
        );
    }

    public function buscarInserto($DiametrosInserto)
    {
        $diametrosValidos = $DiametrosInserto->filter(function ($diametro) 
        {
            return $diametro->diametro_perforacion > 0;
        });
        $Inserto = $diametrosValidos->isNotEmpty() ? $diametrosValidos->toArray() : [];

        return $Inserto;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aprov = Cenc_AprovechamientoModel::AprovechamientosEditar($id);

        $AprovUsuarioValidado = Cenc_AprovechamientoModel::UsuarioAprovechamientoValidado($id);
        $AprovUsuarioAprobado = Cenc_AprovechamientoModel::UsuarioAprovechamientoAprobado($id);
        $AprovUsuarioEnProceso = Cenc_AprovechamientoModel::UsuarioAprovechamientoEnProceso($id);
        $AprovUsuarioAnulado = Cenc_AprovechamientoModel::UsuarioAprovechamientoAnulado($id);
        $AprovUsuarioFinalizado = Cenc_AprovechamientoModel::UsuarioAprovechamientoFinalizado($id);

        $MateriaPrima = Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::EditarMateriaPrimaAprovechamiento($id);
        $AreaCorte = Cenc_Aprovechamiento_Plancha_Area_CorteModel::EditarAreaCorteAprovechamiento($id);
        if (isset($aprov->idconap)) 
        {
            $IdConap = (int)$aprov->idconap;
            $IdListaParte = (int)$aprov->id_lista_parte;
        } 
        else 
        {
            $IdConap = NULL;
            $IdListaParte = NULL;
        }
        $espesor = $this->buscarEspesor($aprov);
        
        $DocumentosAprovechamientos = Cenc_Aprovechamiento_DocumentosModel::obtenerAprovechamientoDocumentos($aprov->id_aprovechamiento);
        $SumaCiclosTaladros = 0;
        $CicloTaladro = Cenc_Aprovechamiento_PlanchasModel::CiclosDeTaladrosPlancha($aprov->id_lista_parte, $espesor);

        foreach ($CicloTaladro as $CiclosTaladros) 
        {
            $SumaCiclosTaladros = $SumaCiclosTaladros + (int)$CiclosTaladros->cantidad_total;
        }

        $MetrosPerforacionPlancha = Cenc_Aprovechamiento_PlanchasModel::MetrosPerforacionPlancha($aprov->id_lista_parte, $espesor);

        $tecnologia = $aprov->nombre_tecnologia;
        $equipo = $aprov->nombre_equipo;
        $precalentamiento = $aprov->precalentamiento;
        $longitud = $aprov->longitud_corte;
        $observaciones = $aprov->observaciones;

        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($IdListaParte, $espesor);
        foreach ($MaterialProcesado as $MaterialProcesados) 
        {
            $CantidadTotalPiezas = $MaterialProcesados->cantidad;
        }

        $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($IdListaParte, $espesor);
        $Inserto = $this->buscarInserto($DiametrosInserto);
        
        $TotalMetrosPerforacionPlanchas = Cenc_Aprovechamiento_PlanchasModel::TotalMetrosPerforacionesAprovListaPartesPlanchas($IdListaParte, $espesor);
        if (isset($TotalMetrosPerforacionPlanchas)) 
        {
            foreach ($TotalMetrosPerforacionPlanchas as $TotalMetrosPerforacionPlas) 
            {
                $TotalMetrosPerforacionPla = $TotalMetrosPerforacionPlas;
            }
        } 
        else 
        {
            $TotalMetrosPerforacionPla = 0;
        }

        $numero_piercing = $aprov->numero_piercing;
        $tiempo_precalentamiento = $aprov->tiempo_precalentamiento;
        $FechaInicio = new DateTime(Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $aprov->id_aprovechamiento)->value('created_at'));
        $FechaActual = Carbon::now(); // Obtiene La fecha Actual
        $TiempoTranscurrido = $FechaInicio->diff($FechaActual); //COMPARA DOS FECHAS Y MUESTRA TIEMPO TRANSCURRIDO

        $BuscarEspesor = Cenc_TablasConsumoModel::buscarEspesorTablaConsumo($espesor, $tecnologia, $equipo);

        if (isset($BuscarEspesor))
        {
            if ($tecnologia == '1') //OXICORTE
            {
                $calculosOxicorte = $this->calcularOxicorte($aprov);

                $VelocidadCorte = $calculosOxicorte["VelocidadCorte"];

                $TiempoEfectivoCorteMinutos = $calculosOxicorte["TiempoEfectivoCorteMinutos"];
                $TiempoEfectivoCorteHoras = $calculosOxicorte["TiempoEfectivoCorteHoras"];

                $TiempoPrecalentamientoEntradasSegundos = $calculosOxicorte["TiempoPrecalentamientoEntradasSegundos"];
                $TiempoPrecalentamientoEntradasMinutos = $calculosOxicorte["TiempoPrecalentamientoEntradasMinutos"];

                $ConsumoOxigenoCorte = $calculosOxicorte["ConsumoOxigenoCorte"];
                $ConsumoOxigenoCorteLitros = $calculosOxicorte["ConsumoOxigenoCorteLitros"];
                $ConsumoOxigenoPorEntradas = $calculosOxicorte["ConsumoOxigenoPorEntradas"];
                $ConsumoOxigenoPorEntradasLitros = $calculosOxicorte["ConsumoOxigenoPorEntradasLitros"];

                $ConsumoOxigenoContinuo = $calculosOxicorte["ConsumoOxigenoContinuo"];
                $ConsumoOxigenoContinuoLitros = $calculosOxicorte["ConsumoOxigenoContinuoLitros"];

                $ConsumoGasCorte = $calculosOxicorte["ConsumoGasCorte"];
                $ConsumoGasCorteLitros = $calculosOxicorte["ConsumoGasCorteLitros"];

                $ConsumoTotalOxigeno = $calculosOxicorte["ConsumoTotalOxigeno"];
                $ConsumoTotalOxigenoLitros = $calculosOxicorte["ConsumoTotalOxigenoLitros"];
                $KilosGasButano = $calculosOxicorte["KilosGasButano"];
                $NumeroCilidrosOxigeno = $calculosOxicorte["NumeroCilidrosOxigeno"];
                $NumeroCilidrosGas = $calculosOxicorte["NumeroCilidrosGas"];
                return view(
                    'CentroCorte.Aprovechamientos.AprovechamientosShow',
                    compact(
                        'aprov',
                        'espesor',
                        'Inserto',
                        'CantidadTotalPiezas',
                        'SumaCiclosTaladros',
                        'TotalMetrosPerforacionPla',
                        'MetrosPerforacionPlancha',

                        'MateriaPrima',
                        'AreaCorte',
                        'MaterialProcesado',
                        'TiempoTranscurrido',
                        'observaciones',

                        'VelocidadCorte',
                        'TiempoEfectivoCorteMinutos',
                        'TiempoEfectivoCorteHoras',
                        'TiempoPrecalentamientoEntradasSegundos',
                        'TiempoPrecalentamientoEntradasMinutos',
                        'ConsumoOxigenoPorEntradas',
                        'ConsumoOxigenoPorEntradasLitros',
                        'ConsumoOxigenoContinuo',
                        'ConsumoOxigenoContinuoLitros',
                        'ConsumoOxigenoCorte',
                        'ConsumoOxigenoCorteLitros',
                        'ConsumoGasCorte',
                        'ConsumoGasCorteLitros',
                        'ConsumoTotalOxigeno',
                        'ConsumoTotalOxigenoLitros',
                        'KilosGasButano',
                        'NumeroCilidrosOxigeno',
                        'NumeroCilidrosGas',
                        'DocumentosAprovechamientos',
                        'AprovUsuarioValidado',
                        'AprovUsuarioAprobado',
                        'AprovUsuarioEnProceso',
                        'AprovUsuarioAnulado',
                        'AprovUsuarioFinalizado',
                    )
                );
            } 
            else 
            {
                $calculosPlasma = $this->calcularPlasma($aprov);
                //PLASMA
                $VelocidadCorte = $calculosPlasma["VelocidadCorte"];

                $TiempoEfectivoCorteMinutos = $calculosPlasma["TiempoEfectivoCorteMinutos"];
                $TiempoEfectivoCorteHoras = $calculosPlasma["TiempoEfectivoCorteHoras"];

                $ConsumoOxigenoPlasmaLitros = $calculosPlasma["ConsumoOxigenoPlasmaLitros"];
                $ConsumoOxigenoPlasmaM3 = $calculosPlasma["ConsumoOxigenoPlasmaM3"];

                $PorcentajeDesperdicioLitros = $calculosPlasma["PorcentajeDesperdicioLitros"];
                $PorcentajeDesperdicioM3 = $calculosPlasma["PorcentajeDesperdicioM3"];

                $NumeroCilidrosOxigeno = $calculosPlasma["NumeroCilidrosOxigeno"];

                return view(
                    'CentroCorte.Aprovechamientos.AprovechamientosShow',
                    compact(
                        'aprov',
                        'espesor',
                        'Inserto',
                        'CantidadTotalPiezas',
                        'SumaCiclosTaladros',
                        'TotalMetrosPerforacionPla',
                        'MetrosPerforacionPlancha',

                        'MateriaPrima',
                        'AreaCorte',
                        'MaterialProcesado',
                        'TiempoTranscurrido',
                        'observaciones',

                        'VelocidadCorte',
                        'TiempoEfectivoCorteMinutos',
                        'TiempoEfectivoCorteHoras',
                        'ConsumoOxigenoPlasmaLitros',
                        'ConsumoOxigenoPlasmaM3',
                        'PorcentajeDesperdicioLitros',
                        'PorcentajeDesperdicioM3',
                        'NumeroCilidrosOxigeno',
                        'DocumentosAprovechamientos',
                        'AprovUsuarioValidado',
                        'AprovUsuarioAprobado',
                        'AprovUsuarioEnProceso',
                        'AprovUsuarioAnulado',
                        'AprovUsuarioFinalizado',
                    )
                );
            }
        } 
        else
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error, revise los valores en Tabla Consumo')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aprov = Cenc_AprovechamientoModel::AprovechamientosEditar($id);
        $espesor = $this->buscarEspesor($aprov);
        $equipos = Cenc_EquiposModel::ListaEquipos();
        $tecnologias = Cenc_TecnologiaModel::ListaTecnologias();
        $MateriaPrima = Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::EditarMateriaPrimaAprovechamiento($id);
        $materias = Cenc_Aprovechamiento_PlanchasModel::ListaMateriaPrima();
        $AreaCorte = Cenc_Aprovechamiento_Plancha_Area_CorteModel::EditarAreaCorteAprovechamiento($id);
        $conaps = Cenc_ConapModel::ListaConaps();
        $ListaPartes = Cenc_ListaPartesModel::ListaPartes();

        if (isset($aprov->idconap)) 
        {
            $IdConap = (int)$aprov->idconap;
            $IdListaParte = (int)$aprov->id_lista_parte;
        } 
        else 
        {
            $IdConap = NULL;
            $IdListaParte = NULL;
        }

        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($IdListaParte, $espesor);
        $documentos = Cenc_Aprovechamiento_DocumentosModel::all()->where('id_aprovechamiento', '=', $id);

        return view(
            'CentroCorte.Aprovechamientos.AprovechamientosEdit',
            compact(
                'aprov',
                'conaps',
                'ListaPartes',
                'equipos',
                'tecnologias',
                'MateriaPrima',
                'materias',
                'AreaCorte',
                'MaterialProcesado',
                'documentos'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencAprovechamientosUpdateRequest $request, $IdAprovechamiento)
    {
        $data = json_decode($request['_caracteristicas']);
        $MateriaPrima = $data->materia_prima;
        $AreaCorte = $data->area_corte;

        if ($MateriaPrima  == NULL || $AreaCorte  == NULL) 
        {
            return back()->withErrors(['caracteristicas' => 'Para registrar un aprovechamiento debe ingresar materia prima y area de corte'])->withInput();
        }
        try
        {
            DB::transaction(function () use ($request, $IdAprovechamiento) 
            {
                $IdUsuario = Auth::user()->id;
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
                $data = json_decode($request['_caracteristicas']);
                $ListaDatos = $data->lista_datos;
                $MateriaPrima = $data->materia_prima;
                $AreaCorte = $data->area_corte;
                $observacion = $data->observaciones;
                $antorcha = 0;
                $boquilla = 0;

                foreach ($observacion as $text) 
                {
                    $observaciones = $text->observaciones_aprov;
                }

                if ($IdAprovechamiento == '') 
                {
                    $id_aprovechamiento = Cenc_AprovechamientoModel::max('id_aprovechamiento') + 1;
                } 
                else 
                {
                    $id_aprovechamiento = $IdAprovechamiento;
                }

                Cenc_AprovechamientoModel::updateOrCreate(
                    [
                        'id_aprovechamiento'    => $id_aprovechamiento,
                    ],
                    [
                        'id_aprovechamiento'    => $id_aprovechamiento,
                        'id_lista_parte'        => intval($ListaDatos[0]->IdListaParte),
                        //'estatus'               => 'POR VALIDAR',
                        'creado_por'            => $IdUsuario,
                        'fecha_creado'          => $FechaActual
                    ]
                );


                if ($ListaDatos[0]->antorcha == "Seleccione Juego de Antorcha") 
                {
                    $antorcha = NULL;
                } 
                else 
                {
                    $antorcha = $ListaDatos[0]->antorcha;
                }

                $boquilla = NULL;
                if ($ListaDatos[0]->numero_boquilla != "Seleccione Boquilla") 
                {
                    $boquilla = $ListaDatos[0]->numero_boquilla;
                } 
                elseif ($ListaDatos[0]->numero_boquilla2 != "Seleccione Boquilla") 
                {
                    $boquilla = $ListaDatos[0]->numero_boquilla2;
                }

                Cenc_Aprovechamiento_PlanchasModel::updateOrCreate(
                    [
                        'id_aprovechamiento_plancha' =>  $IdAprovechamiento,
                    ],
                    [
                        'id_aprovechamiento_plancha' => $IdAprovechamiento,
                        'id_aprovechamiento'         => $id_aprovechamiento,
                        'nombre_equipo'              => $ListaDatos[0]->equipocorte,
                        'nombre_tecnologia'          => $ListaDatos[0]->tecnologia,
                        'espesor'                    => $ListaDatos[0]->espesor,
                        'longitud_corte'             => $ListaDatos[0]->longitud_corte,
                        'numero_piercing'            => $ListaDatos[0]->numero_piercing,
                        'tiempo_estimado'            => $ListaDatos[0]->tiempo_estimado_corte,
                        'juego_antorcha'             => $antorcha,
                        'numero_boquilla'            => $boquilla,
                        'precalentamiento'           => $ListaDatos[0]->precalentamiento,
                        'tiempo_precalentamiento'    => (int)$ListaDatos[0]->tiempo_precalentamiento,
                        'observaciones'              => $observaciones,
                    ]
                );

                $ordenTrabajo = Cenc_AprovechamientoModel::BuscarSiTieneSeguimiento($IdAprovechamiento);

                if ($ordenTrabajo) 
                {
                    $aprov = Cenc_AprovechamientoModel::AprovechamientosEditar($id_aprovechamiento);

                    if ($aprov->nombre_tecnologia == '1') 
                    {
                        $calculosOxicorte = $this->calcularOxicorte($aprov);

                        Cenc_OrdenTrabajo_PlanchasModel::where('id_orden_trabajo_plancha', '=', $ordenTrabajo->id_orden_trabajo_plancha)->update([
                            'equipo'                   => $ListaDatos[0]->equipocorte,
                            'tecnologia'               => $ListaDatos[0]->tecnologia,
                            'tiempo_estimado'          => $ListaDatos[0]->tiempo_estimado_corte,
                            'consumo_oxigeno'          => $calculosOxicorte["ConsumoTotalOxigenoLitros"],
                            'consumo_gas'              => $calculosOxicorte["ConsumoGasCorteLitros"],
                        ]);
                    } 
                    else 
                    {
                        $calculosPlasma = $this->calcularPlasma($aprov);

                        Cenc_OrdenTrabajo_PlanchasModel::where('id_orden_trabajo_plancha', '=', $ordenTrabajo->id_orden_trabajo_plancha)->update([
                            'equipo'                   => $ListaDatos[0]->equipocorte,
                            'tecnologia'               => $ListaDatos[0]->tecnologia,
                            'tiempo_estimado'          => $ListaDatos[0]->tiempo_estimado_corte,
                            'consumo_oxigeno'          => $calculosPlasma["ConsumoOxigenoPlasmaLitros"]
                        ]);
                    }
                }

                foreach ($AreaCorte as $AreaCortes) 
                {
                    if ($AreaCortes->id_area_corte == '') 
                    {
                        $IdAreaCorte = Cenc_Aprovechamiento_Plancha_Area_CorteModel::max('id_area_corte') + 1;
                    }
                    else 
                    {
                        $IdAreaCorte = $AreaCortes->id_area_corte;
                    }

                    Cenc_Aprovechamiento_Plancha_Area_CorteModel::updateOrCreate(
                        [
                            'id_area_corte'             =>  $IdAreaCorte,
                        ],
                        [
                            'id_area_corte'                 =>  $IdAreaCorte,
                            'dimensiones'                   =>  $AreaCortes->dimensiones_corte,
                            'cantidad'                      =>  $AreaCortes->cantidad_corte,
                            'peso_unit'                     =>  $AreaCortes->pesounitario_corte,
                            'peso_total'                    =>  $AreaCortes->pesototal_corte,
                            'id_aprovechamiento_plancha'    =>  $IdAprovechamiento
                        ]
                    );
                }

                foreach ($MateriaPrima as $MateriasPrima) 
                {
                    if ($MateriasPrima->id_materia_prima == '') 
                    {
                        $IdMateriaPrima = Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::max('id_materia_prima') + 1;
                    } 
                    else 
                    {
                        $IdMateriaPrima = $MateriasPrima->id_materia_prima;
                    }

                    Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::updateOrCreate(
                        [
                            'id_materia_prima'             =>  $IdMateriaPrima,
                        ],
                        [
                            'id_materia_prima'                 =>  $IdMateriaPrima,
                            'codigo_materia'                   =>  $MateriasPrima->codigo_materia,
                            'dimensiones'                      =>  $MateriasPrima->dimensiones_materia,
                            'cantidad'                         =>  $MateriasPrima->cantidad_materia,
                            'peso_unit'                        =>  $MateriasPrima->pesounitario_materia,
                            'peso_total'                       =>  $MateriasPrima->pesototal_materia,
                            'id_aprovechamiento_plancha'       =>  $IdAprovechamiento
                        ]
                    );
                }

                $existe = Cenc_Aprovechamiento_DocumentosModel::obtenerIdaprovechamientoDocumento($IdAprovechamiento);

                if ($existe) 
                {
                    $documentos = $request->file('documentos');
                    if ($documentos == null) 
                    {
                        return;
                    } 
                    else 
                    {
                        foreach ($documentos as $documento) 
                        {
                            $destino = "documents/Aprovechamientos/" . $IdAprovechamiento . "/";
                            $NombreDocumento = $documento->getClientOriginalName();
                            $TipoDocumento = $documento->getClientOriginalExtension();
                            $documento->move($destino, $NombreDocumento);

                            $IdDocumento =  Cenc_Aprovechamiento_DocumentosModel::max('id_aprovechamiento_documento') + 1;
                            Cenc_Aprovechamiento_DocumentosModel::create([
                                'id_aprovechamiento_documento'  => $IdDocumento,
                                'id_aprovechamiento'            => $IdAprovechamiento,
                                'nombre_documento'              => $NombreDocumento,
                                'ubicacion_documento'           => $destino . $NombreDocumento,
                                'tipo_documento'                => $TipoDocumento,
                            ]);
                        }
                    }
                } 
                else 
                {
                    $documentos = $request->file('documentos');

                    if ($documentos == null)
                    {
                        return;
                    } 
                    else
                    {
                        $destino = "documents/Aprovechamientos/";
                        $NombreCarpeta = $IdAprovechamiento;
                        $Ruta = public_path($destino . $NombreCarpeta);

                        if (!File::exists($Ruta)) 
                        {
                            File::makeDirectory($Ruta, 0777, true);
                        }

                        foreach ($documentos as $documento) 
                        {
                            $destino = "documents/Aprovechamientos/" . $IdAprovechamiento . "/";
                            $NombreDocumento = $documento->getClientOriginalName();
                            $TipoDocumento = $documento->getClientOriginalExtension();
                            $documento->move($destino, $NombreDocumento);

                            $IdDocumento =  Cenc_Aprovechamiento_DocumentosModel::max('id_aprovechamiento_documento') + 1;
                            Cenc_Aprovechamiento_DocumentosModel::create([
                                'id_aprovechamiento_documento'  => $IdDocumento,
                                'id_aprovechamiento'            => $IdAprovechamiento,
                                'nombre_documento'              => $NombreDocumento,
                                'ubicacion_documento'           => $destino . $NombreDocumento,
                                'tipo_documento'                => $TipoDocumento,
                            ]);
                        }
                    }
                }
            });
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al editar el Aprovechamiento ' . $ex->getMessage())->withInput();
        }
        return redirect()->route('cencaprovechamientos.edit', $IdAprovechamiento)->withSuccess('Se Ha Editado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAprovechamiento)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try 
        {
            $salida = Cenc_AprovechamientoModel::find($idAprovechamiento);

            $salida->fill([
                'id_aprovechamiento' => $idAprovechamiento,
                'fecha_anulado' => $FechaActual,
                'estatus' => 'ANULADO',
                'anulado_por' => Auth::user()->id

            ]);
            $salida->save();
        } 
        catch (Exception $ex) 
        {
            return redirect()->route('cencaprovechamientos.index')->withError('Error Al Anular el aprovechamiento ' . $ex->getMessage());
        }
        return redirect()->route('cencaprovechamientos.index')->withSuccess('El aprovechamiento ha sido anulada exitosamente');
    }

    public function activar($idAprovechamiento)
    {
        try 
        {
            $salida = Cenc_AprovechamientoModel::find($idAprovechamiento);

            $salida->fill([
                'id_aprovechamiento' => $idAprovechamiento,
                'estatus' => 'POR VALIDAR'
            ]);
            $salida->save();
        } 
        catch (Exception $ex) 
        {
            return redirect()->route('cencaprovechamientos.index')->withError('Error Al Activar el Aprovechamiento ' . $ex->getMessage());
        }
        return redirect()->route('cencaprovechamientos.index')->withSuccess('El aprovechamiento ha sido activada exitosamente');
    }

    public function TecnologiaEquipo($idEquipo)
    {
        $tecnologia = Cenc_EquiposTecnologiaModel::TecnologiaEquipo($idEquipo);
        return with(["caracteristicas" => $tecnologia]);
    }

    public function ListaParteConaps(Request $request)
    {
        $ListaPartes = Cenc_Aprovechamiento_PlanchasModel::ListaParteConap($request->id);
        return with(["ListaPartes" => $ListaPartes]);
    }

    public function ListaParteEspesor($IdConap, $IdListaParte, $IdEquipo, $IdTecnologia)
    {
        $ListaParteEspesor = Cenc_Aprovechamiento_PlanchasModel::ListaParteEspesor($IdConap, $IdListaParte);
        foreach ($ListaParteEspesor as $valores) 
        {
            $EspesorLp[] = number_format($valores->espesor, 2, '.', '');
        }
        //Todos los espesores en array
        $iteracion = count($EspesorLp);
        for ($i = 0; $i < $iteracion; $i++) 
        {
            //Buscar cuales espesores que estan en el array, estan en tabla consumo 
            $resultadoBusqueda[] = Cenc_TablasConsumoModel::buscarEspesorTablaConsumoE($EspesorLp[$i], $IdTecnologia, $IdEquipo);
        }
        return $resultadoBusqueda;
    }

    public function MaterialProcesado($IdListaParte, $espesor)
    {
        $material = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($IdListaParte, $espesor);
        return with(["espesor" => $material]);
    }

    public function MostrarMateriaPrima()
    {
        $materia = Cenc_Aprovechamiento_PlanchasModel::ListaMateriaPrima();
        return $materia;
    }

    //Eliminar detalle de materia prima
    public function EliminarDetalleMateriaPrima($IdMateriaPrima)
    {
        try 
        {
            Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::destroy($IdMateriaPrima);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    //Eliminar detalle de area corte
    public function EliminarDetalleAreaCorte($IdAreaCorte)
    {
        try
        {
            Cenc_Aprovechamiento_Plancha_Area_CorteModel::destroy($IdAreaCorte);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    //Eliminar documento aprovechamiento
    public function EliminarDocumentoAprovechamiento($IdAprovechamientoDocumento)
    {
        try 
        {
            Cenc_Aprovechamiento_DocumentosModel::destroy($IdAprovechamientoDocumento);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    public function ValidarAprovechamiento($IdAprovechamiento)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $estatus = 'VALIDADO';

        try 
        {
            Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $IdAprovechamiento)->update(
                [
                    'validado_por'      => Auth::user()->id,
                    'fecha_validado'    => $FechaActual,
                    'estatus'           => $estatus
                ]
            );
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Validar El Aprovechamiento. ' . $ex->getMessage())->withInput();
        }
        return redirect()->route("cencaprovechamientos.show", $IdAprovechamiento)->withSuccess("El aprovechamiento Ha Sido Validado.");
    }

    public function AprobarAprovechamiento(Request $request, $IdAprovechamiento)
    {
        $data = json_decode($request['datos']);
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $estatus = 'APROBADO';
        $IdUsuario = Auth::user()->id;
        $Id_Aprovechamiento = (int)$IdAprovechamiento;

        $aprovechamiento = Cenc_AprovechamientoModel::AprovechamientosEditar($Id_Aprovechamiento);
        $BuscarConapOrdenTrabajo = Cenc_OrdenTrabajoModel::BuscarConapOrdenTrabajo((int)$aprovechamiento->idconap);

        if ($BuscarConapOrdenTrabajo) 
        {
            if ($BuscarConapOrdenTrabajo->estatus == 'FINALIZADO') 
            {
                return redirect()->route("cencaprovechamientos.show", $Id_Aprovechamiento)->withError("Este Conap Ya Tiene Orden de Trabajo Finalizada.");
            }
            else
            {
                Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $Id_Aprovechamiento)->update(
                    [
                        'aprobado_por'      => Auth::user()->id,
                        'fecha_aprobado'    => $FechaActual,
                        'estatus'           => $estatus
                    ]
                );
                // 2. Creación de Orden de Trabajo Plancha
                $id_orden_trabajo_plancha = Cenc_OrdenTrabajo_PlanchasModel::max('id_orden_trabajo_plancha') + 1;
                Cenc_OrdenTrabajo_PlanchasModel::create([
                    'id_orden_trabajo_plancha' => $id_orden_trabajo_plancha,
                    'id_orden_trabajo'         => (int)$BuscarConapOrdenTrabajo->id_orden_trabajo,
                    'id_aprovechamiento'       => (int)$aprovechamiento->id_aprovechamiento,
                    'id_lista_parte'           => (int)$aprovechamiento->id_lista_parte,
                    'equipo'                   => $aprovechamiento->nombre_equipo,
                    'tecnologia'               => $aprovechamiento->nombre_tecnologia,
                    'tiempo_estimado'          => $aprovechamiento->tiempo_estimado,
                    'consumo_oxigeno'          => $data->ConsumoOxigeno,
                    'consumo_gas'              => $data->ConsumoGas,
                ]);
                // 3. Creación de Seguimiento
                $id_seguimiento = Cenc_SeguimientoModel::max('id_seguimiento') + 1;
                Cenc_SeguimientoModel::create([
                    'id_seguimiento'           => $id_seguimiento,
                    'id_orden_trabajo_plancha' => (int)$id_orden_trabajo_plancha,
                    'estatus'                  => 'POR ACEPTAR',
                    'fecha_creado'             => $FechaActual,
                    'creado_por'               => $IdUsuario,
                ]);
                return redirect()->route("cencaprovechamientos.show", $Id_Aprovechamiento)->withSuccess("El Aprovechamiento Ha Sido Aprobado.");
            }
        }
        else
        {
            Cenc_ConapModel::updateStatus((int)$aprovechamiento->idconap, $estatus);

            Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $Id_Aprovechamiento)->update(
                [
                    'aprobado_por'      => Auth::user()->id,
                    'fecha_aprobado'    => $FechaActual,
                    'estatus'           => $estatus
                ]
            );
             // 1. Creación de Orden de Trabajo
             $id_orden_trabajo = Cenc_OrdenTrabajoModel::max('id_orden_trabajo') + 1;
             Cenc_OrdenTrabajoModel::create([
                 'id_orden_trabajo'    => $id_orden_trabajo,
                 'id_conap'            => (int)$aprovechamiento->idconap,
                 'estatus'             => 'POR ACEPTAR',
                 'fecha_creado'        => $FechaActual,
                 'creado_por'          => $IdUsuario,
             ]);
             // 2. Creación de Orden de Trabajo Plancha
             $id_orden_trabajo_plancha = Cenc_OrdenTrabajo_PlanchasModel::max('id_orden_trabajo_plancha') + 1;
             Cenc_OrdenTrabajo_PlanchasModel::create([
                 'id_orden_trabajo_plancha' => $id_orden_trabajo_plancha,
                 'id_orden_trabajo'         => (int)$id_orden_trabajo,
                 'id_aprovechamiento'       => (int)$aprovechamiento->id_aprovechamiento,
                 'id_lista_parte'           => (int)$aprovechamiento->id_lista_parte,
                 'equipo'                   => $aprovechamiento->nombre_equipo,
                 'tecnologia'               => $aprovechamiento->nombre_tecnologia,
                 'tiempo_estimado'          => $aprovechamiento->tiempo_estimado,
                 'consumo_oxigeno'          => $data->ConsumoOxigeno,
                 'consumo_gas'              => $data->ConsumoGas,
             ]);
             // 3. Creación de Seguimiento
             $id_seguimiento = Cenc_SeguimientoModel::max('id_seguimiento') + 1;
             Cenc_SeguimientoModel::create([
                 'id_seguimiento'           => $id_seguimiento,
                 'id_orden_trabajo_plancha' => (int)$id_orden_trabajo_plancha,
                 'estatus'                  => 'POR ACEPTAR',
                 'fecha_creado'             => $FechaActual,
                 'creado_por'               => $IdUsuario,
             ]);
             return redirect()->route("cencaprovechamientos.show", $Id_Aprovechamiento)->withSuccess("El Aprovechamiento Ha Sido Aprobado y Se Ha Creado La Orden de Trabajo.");
        }
    }

    public function ImprimirAprovechamiento($id)
    {
        $aprov = Cenc_AprovechamientoModel::AprovechamientosEditar($id);
        $MateriaPrima = Cenc_Aprovechamiento_Plancha_Materia_PrimaModel::EditarMateriaPrimaAprovechamiento($id);
        $AreaCorte = Cenc_Aprovechamiento_Plancha_Area_CorteModel::EditarAreaCorteAprovechamiento($id);
        if (isset($aprov->idconap)) 
        {
            $IdConap = (int)$aprov->idconap;
            $IdListaParte = (int)$aprov->id_lista_parte;
        } 
        else 
        {
            $IdConap = NULL;
            $IdListaParte = NULL;
        }
        
        $espesor = $this->buscarEspesor($aprov);
        $CicloTaladro = Cenc_Aprovechamiento_PlanchasModel::CiclosDeTaladrosPlancha($aprov->id_lista_parte, $espesor);
        foreach ($CicloTaladro as $CiclosTaladros)
        {
            $CiclosTaladros = $CiclosTaladros->cantidad_total;
        }

        $tecnologia = $aprov->nombre_tecnologia;
        $precalentamiento = $aprov->precalentamiento;
        $longitud = $aprov->longitud_corte;
        $observaciones = $aprov->observaciones;

        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($IdListaParte, $espesor);
        foreach ($MaterialProcesado as $MaterialProcesados) {
            $CantidadTotalPiezas = $MaterialProcesados->cantidad;
        }

        $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($IdListaParte, $espesor);
        foreach ($DiametrosInserto as $DiametrosInsertos) 
        {
            if ($DiametrosInsertos->diametro_perforacion <> 0) 
            {
                $Inserto[] = $DiametrosInsertos->diametro_perforacion;
            } 
            else 
            {
                $Inserto[] = '';
            }
        }

        $TotalMetrosPerforacionPlanchas = Cenc_Aprovechamiento_PlanchasModel::TotalMetrosPerforacionesAprovListaPartesPlanchas($IdListaParte, $espesor);
        if (isset($TotalMetrosPerforacionPlanchas)) 
        {
            foreach ($TotalMetrosPerforacionPlanchas as $TotalMetrosPerforacionPlas) 
            {
                $TotalMetrosPerforacionPla = $TotalMetrosPerforacionPlas;
            }
        } 
        else 
        {
            $TotalMetrosPerforacionPla = 0;
        }

        $numero_piercing = $aprov->numero_piercing;
        $tiempo_precalentamiento = $aprov->tiempo_precalentamiento;

        $FechaInicio = new DateTime(Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $aprov->id_aprovechamiento)->value('created_at'));
        $FechaActual = Carbon::now(); // Obtiene La fecha Actual
        $TiempoTranscurrido = $FechaInicio->diff($FechaActual); //COMPARA DOS FECHAS Y MUESTRA TIEMPO TRANSCURRIDO

        if ($tecnologia == '1') //OXICORTE
        { 
            $calculosOxicorte = $this->calcularOxicorte($aprov);

            $VelocidadCorte = $calculosOxicorte["VelocidadCorte"];

            $TiempoEfectivoCorteMinutos = $calculosOxicorte["TiempoEfectivoCorteMinutos"];
            $TiempoEfectivoCorteHoras = $calculosOxicorte["TiempoEfectivoCorteHoras"];

            $TiempoPrecalentamientoEntradasSegundos = $calculosOxicorte["TiempoPrecalentamientoEntradasSegundos"];
            $TiempoPrecalentamientoEntradasMinutos = $calculosOxicorte["TiempoPrecalentamientoEntradasMinutos"];

            $ConsumoOxigenoCorte = $calculosOxicorte["ConsumoOxigenoCorte"];
            $ConsumoOxigenoCorteLitros = $calculosOxicorte["ConsumoOxigenoCorteLitros"];
            $ConsumoOxigenoPorEntradas = $calculosOxicorte["ConsumoOxigenoPorEntradas"];
            $ConsumoOxigenoPorEntradasLitros = $calculosOxicorte["ConsumoOxigenoPorEntradasLitros"];

            $ConsumoOxigenoContinuo = $calculosOxicorte["ConsumoOxigenoContinuo"];
            $ConsumoOxigenoContinuoLitros = $calculosOxicorte["ConsumoOxigenoContinuoLitros"];

            $ConsumoGasCorte = $calculosOxicorte["ConsumoGasCorte"];
            $ConsumoGasCorteLitros = $calculosOxicorte["ConsumoGasCorteLitros"];

            $ConsumoTotalOxigeno = $calculosOxicorte["ConsumoTotalOxigeno"];
            $ConsumoTotalOxigenoLitros = $calculosOxicorte["ConsumoTotalOxigenoLitros"];
            $KilosGasButano = $calculosOxicorte["KilosGasButano"];
            $NumeroCilidrosOxigeno = $calculosOxicorte["NumeroCilidrosOxigeno"];
            $NumeroCilidrosGas = $calculosOxicorte["NumeroCilidrosGas"];
        
            
            $pdf = PDF::loadView(
                'CentroCorte.Aprovechamientos.AprovechamientosPDF',
                compact(
                    'aprov',
                    'espesor',
                    'Inserto',
                    'CantidadTotalPiezas',
                    'CiclosTaladros',
                    'TotalMetrosPerforacionPla',

                    'MateriaPrima',
                    'AreaCorte',
                    'MaterialProcesado',
                    'TiempoTranscurrido',
                    'observaciones',

                    'VelocidadCorte',
                    'TiempoEfectivoCorteMinutos',
                    'TiempoEfectivoCorteHoras',
                    'TiempoPrecalentamientoEntradasSegundos',
                    'TiempoPrecalentamientoEntradasMinutos',
                    'ConsumoOxigenoPorEntradas',
                    'ConsumoOxigenoPorEntradasLitros',
                    'ConsumoOxigenoContinuo',
                    'ConsumoOxigenoContinuoLitros',
                    'ConsumoOxigenoCorte',
                    'ConsumoOxigenoCorteLitros',
                    'ConsumoGasCorte',
                    'ConsumoGasCorteLitros',
                    'ConsumoTotalOxigeno',
                    'ConsumoTotalOxigenoLitros',
                    'KilosGasButano',
                    'NumeroCilidrosOxigeno',
                    'NumeroCilidrosGas'
                )
            )->setPaper('letter');

            return $pdf->stream('AprovechamientoOxicorte_' . $id . '_' . $FechaActual . '.pdf');
        } 
        else 
        {
            //PLASMA
            $calculosPlasma = $this->calcularPlasma($aprov);
            
            $VelocidadCorte = $calculosPlasma["VelocidadCorte"];

            $TiempoEfectivoCorteMinutos = $calculosPlasma["TiempoEfectivoCorteMinutos"];
            $TiempoEfectivoCorteHoras = $calculosPlasma["TiempoEfectivoCorteHoras"];

            $ConsumoOxigenoPlasmaLitros = $calculosPlasma["ConsumoOxigenoPlasmaLitros"];
            $ConsumoOxigenoPlasmaM3 = $calculosPlasma["ConsumoOxigenoPlasmaM3"];

            $PorcentajeDesperdicioLitros = $calculosPlasma["PorcentajeDesperdicioLitros"];
            $PorcentajeDesperdicioM3 = $calculosPlasma["PorcentajeDesperdicioM3"];

            $NumeroCilidrosOxigeno = $calculosPlasma["NumeroCilidrosOxigeno"];

            $pdf = PDF::loadView(
                'CentroCorte.Aprovechamientos.AprovechamientosPDF',
                compact(
                    'aprov',
                    'espesor',
                    'Inserto',
                    'CantidadTotalPiezas',
                    'CiclosTaladros',
                    'TotalMetrosPerforacionPla',

                    'MateriaPrima',
                    'AreaCorte',
                    'MaterialProcesado',
                    'TiempoTranscurrido',
                    'observaciones',

                    'VelocidadCorte',
                    'TiempoEfectivoCorteMinutos',
                    'TiempoEfectivoCorteHoras',
                    'ConsumoOxigenoPlasmaLitros',
                    'ConsumoOxigenoPlasmaM3',
                    'PorcentajeDesperdicioLitros',
                    'PorcentajeDesperdicioM3',
                    'NumeroCilidrosOxigeno'
                )
            )->setPaper('letter');
            return $pdf->stream('AprovechamientoPlasma_' . $id . '_' . $FechaActual . '.pdf');
        }
    }
}