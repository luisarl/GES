<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UsuariosCreateRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use App\Http\Requests\UsuariosPerfilUpdateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\DepartamentosModel;
use App\Models\EmpresasModel;
use App\Models\Emba_EmbarcacionesModel;
use App\Models\Embarcaciones_UsuariosModel;
use App\Models\User;
use DB;
use Exception;
use PhpParser\Node\Stmt\Return_;
use Redirect;
use Session;



class UsuariosController extends Controller
{

    public function index()
    {
        $usuarios = User::with(['departamento', 'roles'])->get();

        return view('Configuracion.Usuarios.Usuarios.Usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::All();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        $permisos = Permission::select('id', 'name')->orderBy('name')->get();
        $departamentos = DepartamentosModel::all();
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();

        return view('Configuracion.Usuarios.Usuarios.UsuariosCreate', compact( 'roles', 'permisos', 'departamentos', 'empresas','embarcaciones'));
    }


    public function store(UsuariosCreateRequest $request)
    {   
       
        $usuario = new User();
        $usuario->name = strtoupper($request['name']);
        $usuario->email = $request['email'];
        $usuario->password = Hash::make($request['password']);
        $usuario->username = strtoupper($request['username']);
        $usuario->id_departamento = $request['id_departamento'];
        $usuario->activo = $request['activo'];
        $usuario->responsable_servicios = $request['responsable_servicios'];
       
        $roles = $request->input('roles');
        $usuario->assignRole($roles);// Asignacion de rol
        $usuario->givePermissionTo($request->input('permisos', []));// agregar los permisos 
        
        $almacenes = json_decode($request['datosalmacen']); //arreglo de datos almacenes
        $embarcaciones = json_decode($request['datosembarcacion']); //arreglo de datos adicionales   
        
        try
        {    
            DB::transaction(function () use ($almacenes, $usuario,$embarcaciones) 
            {
                $usuario->save(); // GUARDAR USUARIO
                $filas = count($almacenes);
                    
                for($i=0; $i < $filas; $i++)
                {
                    $IdUsuarioAlmacen = Almacen_UsuarioModel::max('id_almacen_usuario') + 1;
                    //Inserta datos de la tabla 
                    Almacen_UsuarioModel::create([
                        'id_almacen_usuario' => $IdUsuarioAlmacen,
                        'id_almacen'  => $almacenes[$i][0],
                        'id_empresa' =>  $almacenes[$i][1],
                        'id'=> $usuario->id,
                    ]);
                }

                foreach($embarcaciones as $embarcacion)
                {
                    $IdEmbarcacionUsuario = Embarcaciones_UsuariosModel::max('id_embarcaciones_usuario') + 1;

                    Embarcaciones_UsuariosModel::create([
                        'id_embarcaciones_usuario' =>  $IdEmbarcacionUsuario,
                        'id_embarcaciones' => $embarcacion->id_embarcacion,
                        'id_usuario'=> Auth::user()->id,

                    ]);
                }



            });
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Usuario '. $ex->getMessage());
            }

        return redirect("usuarios")->withSuccess('El Usuario Ha sido Creado Exitosamente');
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $roles = Role::select('id', 'name')->get(); //trae los roles para el usuario
       // $rol = User::with('roles')->find($id); //trae los roles encontrados en el usuario
        $permisos = Permission::select('id', 'name')->orderBy('name')->get(); //trae todo el listado de permiso
        $usuario = User::with('roles')->find($id);
        $departamentos = DepartamentosModel::all();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario($id);
        $embarcaciones_usuarios = Embarcaciones_UsuariosModel::EmbarcacionesUsuario($id);
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();
        
        return view('Configuracion.Usuarios.Usuarios.UsuariosEdit', compact('usuario',  'roles',  'permisos', 'departamentos', 'empresas', 'almacenes','embarcaciones','embarcaciones_usuarios'));
    }


    public function update(UsuariosUpdateRequest $request, $id)
    {
      
        try
        {
            $usuario = User::find($id);
            $usuario->fill([
                'name' => strtoupper($request['name']),
                'email' => $request['email'],
                'username' => strtoupper($request['username']),
                'id_departamento'=> $request['id_departamento'],  
                'activo' => $request['activo'], 
                'responsable_servicios' => $request['responsable_servicios'],
              
            ]);
            
            $usuario->syncRoles($request->input('roles'));  //Sinronizacion de rol
            $usuario->syncPermissions($request->input('permisos', [])); // agregar los permisos 

            if (!empty($request->input('password'))) //enviar vacio la contraseña y no la actualice
            {
                $usuario->password = Hash::make($request->input('password'));
            }

    
            $DatosAlmacenes = json_decode($request['datosalmacen']); //arreglo de datos adicionales
            $DatosEmbarcaciones = json_decode($request['datosembarcacion']); //arreglo de datos adicionales

            DB::transaction(function () use ($DatosAlmacenes, $usuario, $DatosEmbarcaciones)
            {
                $usuario->save();

                if($DatosAlmacenes != "") //verifica si el arreglo no esta vacio
                {
                    $filas = count($DatosAlmacenes); //obtiene la cantidad de filas del arreglo

                    for($i=0; $i < $filas; $i++)
                    {
                        if($DatosAlmacenes[$i][0] == "") //si la primera columna de la tabla esta vacia busca el maximo id de la base de datos y le suma 1
                        {
                            $IdUsuarioAlmacen = Almacen_UsuarioModel::max('id_almacen_usuario') + 1;
                        }
                        else //si no captura el valor de la primera columna de la tabla
                            {
                                $IdUsuarioAlmacen = $DatosAlmacenes[$i][0];
                            }

                            Almacen_UsuarioModel::updateOrInsert(
                            [ 'id_almacen_usuario' => $IdUsuarioAlmacen],
                            [
                            'id'=> $usuario->id,
                            'id_almacen'  => $DatosAlmacenes[$i][1],
                            'id_empresa' =>  $DatosAlmacenes[$i][2],
                            ]);
                    }
                }
               
                if ($DatosEmbarcaciones != NULL)  //verifica si el arreglo no esta vacio
                {
                   // Eliminar los detalles de solicitud existentes
                   Embarcaciones_UsuariosModel::where('id_usuario', $usuario->id)->delete();

                  // Insertar los nuevos detalles de solicitud
                    foreach ($DatosEmbarcaciones as $DatosEmbarcacion) {
                        $IdEmbarcacionUsuario=  Embarcaciones_UsuariosModel::max('id_embarcaciones_usuario') + 1;
                        Embarcaciones_UsuariosModel::create([

                            'id_embarcaciones_usuario' =>  $IdEmbarcacionUsuario,
                            'id_embarcaciones' => $DatosEmbarcacion->id_embarcacion,
                            'id_usuario'=> Auth::user()->id,
                        ]);
                    }
                }        
            });
        
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar El Usuario '.$ex->getMessage());
            }

        return redirect("usuarios")->withSuccess('El Usuario Se Ha Actualizado Exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        
    public function EliminarAlmacenes($IdAlmacenUsuario)
    {
         try
         {
             Almacen_UsuarioModel::destroy($IdAlmacenUsuario);
         }
         catch (Exception $e)
         {
             return back()->withError('Error Al Eliminar');
         }
 
         return back()->with('');
    }

    public function EliminarEmbarcaciones($IdEmbarcacionUsuario)
    {
         try
         {
            Embarcaciones_UsuariosModel::destroy($IdEmbarcacionUsuario);
         }
         catch (Exception $e)
         {
             return back()->withError('Error Al Eliminar');
         }
 
         return back()->with('');
    }

    public function AlmacenesEmpresa(Request $request)
    {
        $almacenes = AlmacenesModel::where('id_empresa', '=', $request->id)->get();
        return with(["almacenes" => $almacenes]);
    }

    public function destroy($id)
    {
        try
        {
            User::destroy($id);
        }
        catch (Exception $ex)
            {
                return redirect("usuarios")->withError('No Se Puede Eliminar El Usuario '.$ex->getMessage());
            }
        
        return redirect("usuarios")->withSuccess('El Usuarios Ha Sido Eliminado Exitosamente');
    }

    public function perfil()
    {
        $usuario = User::find(Auth::user()->id);
        return view('Configuracion.Usuarios.Usuarios.UsuariosPerfil', compact('usuario'));
    }

    public function perfilupdate(UsuariosPerfilUpdateRequest $request)
    {
        try
        {
            $usuario = User::find(Auth::user()->id);
            
            User::where('id', '=', Auth::user()->id)
                ->update([
                    'name' => strtoupper($request['name']),
                    'email' => $request['email']
                ]);

                if (!empty($request->input('password'))) //enviar vacio la contraseña y no la actualice
                {
                    $usuario->password = Hash::make($request->input('password'));
                }
                $usuario->save();
           
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('No Se Pudo Actualizar El Perfil', $ex->getMessage());
            }
        
        return redirect("perfil")->withSuccess('El Usuario se ha Actualizado Exitosamente');   
    }
}
