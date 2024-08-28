<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencConapUpdateRequest;
use App\Models\Cenc_ConapModel;  
use App\Models\Cenc_Conap_DocumentosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CencConapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conaps = Cenc_ConapModel::ListaConaps();
        return view('CentroCorte.Conap.Conap', compact('conaps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idconap = Cenc_ConapModel::max('id_conap') + 1;
        return view('CentroCorte.Conap.ConapCreate',compact('idconap'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $IdUsuario = Auth::user()->id;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $IdConap = Cenc_ConapModel::max('id_conap') + 1;
        $destino = "documents/Conaps/";
        $NombreCarpeta = $IdConap;
        $Ruta = public_path($destino . $NombreCarpeta);

        if (!File::exists($Ruta)) 
        {
            File::makeDirectory($Ruta, 0777, true);
        }
        try 
        {
            if ($request->hasFile('documentos'))
            {   
                $PosseDocumentos = 'SI';
            }
            else
                {
                    $PosseDocumentos = 'NO';
                }

            $IdConap = Cenc_ConapModel::max('id_conap') + 1; 
            Cenc_ConapModel::create([
                'id_conap'              => $IdConap,
                'nro_conap'             => strtoupper($request['nro_conap']),
                'nombre_conap'          => strtoupper($request['nombre_conap']),
                'descripcion_conap'     => strtoupper($request['descripcion_conap']),
                'estatus_conap'         => 'EN PROCESO',
                'creado_por'            => $IdUsuario,
                'fecha_creado'          => $FechaActual
            ]);

            if($PosseDocumentos == 'SI')
            {
                $documentos = $request->file('documentos');
                foreach ($documentos as $documento ) 
                {
                    $destino = "documents/Conaps/".$IdConap."/";
                    $NombreDocumento = $documento->getClientOriginalName();
                    $TipoDocumento = $documento->getClientOriginalExtension();
                    $documento->move($destino,$NombreDocumento);

                    $IdSolicitudDocumento =  Cenc_Conap_DocumentosModel::max('id_conap_documento') + 1;
                    Cenc_Conap_DocumentosModel::create([
                        'id_conap_documento'    => $IdSolicitudDocumento,
                        'id_conap'              => $IdConap,
                        'nombre_documento'      => $NombreDocumento,
                        'ubicacion_documento'   => $destino .$NombreDocumento,
                        'tipo_documento'        => $TipoDocumento,
                    ]);
                }    
            }

            return redirect("cencconap")->withSuccess('El Conap Ha Sido Creado Exitosamente');
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear El Conap: '.$ex->getMessage())->withInput();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdConap)
    {
        $conap = Cenc_ConapModel::ListaConapsVer($IdConap);
        $ConapUsuarioAprobado = Cenc_ConapModel::UsuarioConapAprobado($IdConap);
        $ConapUsuarioAnulado = Cenc_ConapModel::UsuarioConapAnulado($IdConap);
        $ConapUsuarioFinalizado = Cenc_ConapModel::UsuarioConapFinalizado($IdConap);
        $documentos = Cenc_Conap_DocumentosModel::all()->where('id_conap', '=', $IdConap);
        return view('CentroCorte.Conap.ConapShow', compact(
            'conap',
            'ConapUsuarioAprobado',
            'ConapUsuarioAnulado',
            'ConapUsuarioFinalizado',
            'documentos'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdConap)
    {
        $conap = Cenc_ConapModel::find($IdConap);
        $documentos = Cenc_Conap_DocumentosModel::all()->where('id_conap', '=', $IdConap);
        return view('CentroCorte.Conap.ConapEdit', compact('conap','documentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencConapUpdateRequest $request, $IdConap)
    {
        try 
        {
            DB::transaction(function () use ($request, $IdConap) 
            {
            $conap = Cenc_ConapModel::find($IdConap);

            $conap->fill([
                'id_conap'          => $IdConap,
                'nombre_conap'      => strtoupper($request['nombre_conap']),
                'descripcion_conap' => strtoupper($request['descripcion_conap'])
            ]);
            $conap->save();

            $existe = Cenc_Conap_DocumentosModel::obtenerIdConapDocumento($IdConap);
          
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
                            $destino = "documents/Conaps/" . $IdConap . "/";
                            $NombreDocumento = $documento->getClientOriginalName();
                            $TipoDocumento = $documento->getClientOriginalExtension();
                            $documento->move($destino, $NombreDocumento);
                        
                            $IdSolicitudDocumento =  Cenc_Conap_DocumentosModel::max('id_conap_documento') + 1;

                        Cenc_Conap_DocumentosModel::create([
                            'id_conap_documento'    => $IdSolicitudDocumento,
                            'id_conap'              => $IdConap,
                            'nombre_documento'      => $NombreDocumento,
                            'ubicacion_documento'   => $destino .$NombreDocumento,
                            'tipo_documento'        => $TipoDocumento ,
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
                        $destino = "documents/Conaps/";
                        $NombreCarpeta = $IdConap;
                        $Ruta = public_path($destino . $NombreCarpeta);

                        if (!File::exists($Ruta)) 
                        {
                            File::makeDirectory($Ruta, 0777, true);
                        }

                        foreach ($documentos as $documento) 
                        {
                            $destino = "documents/Conaps/" . $IdConap . "/";
                            $NombreDocumento = $documento->getClientOriginalName();
                            $TipoDocumento = $documento->getClientOriginalExtension();
                            $documento->move($destino, $NombreDocumento);

                            $IdSolicitudDocumento =  Cenc_Conap_DocumentosModel::max('id_conap_documento') + 1;
                       
                            Cenc_Conap_DocumentosModel::create([
                                'id_conap_documento'    => $IdSolicitudDocumento,
                                'id_conap'              => $IdConap,
                                'nombre_documento'      => $NombreDocumento,
                                'ubicacion_documento'   => $destino .$NombreDocumento,
                                'tipo_documento'        => $TipoDocumento ,

                            ]);
                        }
                    }
                }
            });
        } 
        catch (Exception $ex) 
        {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar El conap: '.$ex->getMessage())->withInput();
        }
        return redirect()->route('cencconap.edit', $IdConap)->withSuccess('El Conap Ha Sido Actualizado Exitosamente');
    }

    public function EliminarDocumentoConap($IdConap)
    {
        $IdDocumento = Cenc_Conap_DocumentosModel::find($IdConap);
        try
        {
            if($IdDocumento->nombre_documento != NULL)
            {
                storage::disk('local')->delete($IdDocumento->ubicacion_documento);
            }
            Cenc_Conap_DocumentosModel::destroy($IdDocumento->id_conap_documento);
        }
        catch(Exception)
        {
            return back()->withError('Se Produjo Un Error Al Eliminar El Documento');
        }
       return back()->withSuccess('El Documento Ha Sido Eliminado Exisosamente');
    } 
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdConap)
    {
        try 
        {
            $IdDocumentosConap = Cenc_Conap_DocumentosModel::obtenerConapDocumentos($IdConap);

            foreach ($IdDocumentosConap as $data) 
            {
                Cenc_Conap_DocumentosModel::destroy((int)$data->id_conap_documento);
            }
            Cenc_ConapModel::destroy($IdConap);

        }
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar El Conap: ' . $ex->getMessage())->withInput();
        }
        return redirect('cencconap')->withSuccess('El Conap Ha Sido Eliminado Exitosamente');
    }
}