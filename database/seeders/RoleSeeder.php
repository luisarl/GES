<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // this can be done as separate statements
        $administrador = Role::create(['name' => 'administrador']);
        $catalogador = Role::create(['name' => 'catalogador']);
        $solicitante = Role::create(['name' => 'solicitante']);
        $visitante = Role::create(['name' => 'visitante']);
        
        
        //Permissions Especiales de botones
        Permission::create(['name' => 'fict.unidades.migracion'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.grupos.migracion'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subgrupos.migracion'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.categorias.migracion'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.articulo.generar.codigo'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.articulo.migrar.profit'])->syncRoles([$catalogador]);

        //Permissions Menu Ficha tenica
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'fichatecnica'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fichatecnica.articulos'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fichatecnica.grupos'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.subgrupos'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.categorias'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.clasificaciones'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.subclasificaciones'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.almacenes'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fichatecnica.unidades'])->syncRoles([$catalogador]);
        //Permissions Menu general
        Permission::create(['name' => 'reportes'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'usuarios']);

        //permissions articulos 
        Permission::create(['name' => 'fict.articulos.inicio'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fict.articulos.crear'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fict.articulos.editar'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fict.articulos.ver'])->syncRoles([$catalogador, $solicitante]);
        Permission::create(['name' => 'fict.articulos.eliminar'])->syncRoles([$catalogador]);
        //permissions categorias
        Permission::create(['name' => 'fict.categorias.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.categorias.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.categorias.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.categorias.eliminar'])->syncRoles([$catalogador]);
        //permissions grupos
        Permission::create(['name' => 'fict.grupos.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.grupos.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.grupos.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.grupos.eliminar'])->syncRoles([$catalogador]);
        //permissions subgrupos 
        Permission::create(['name' => 'fict.subgrupos.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subgrupos.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subgrupos.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subgrupos.eliminar'])->syncRoles([$catalogador]);
        //permissions clasificacion 
        Permission::create(['name' => 'fict.clasificaciones.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.clasificaciones.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.clasificaciones.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.clasificaciones.eliminar'])->syncRoles([$catalogador]);
        //permissions subclasificacion
        Permission::create(['name' => 'fict.subclasificaciones.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subclasificaciones.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subclasificaciones.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.subclasificaciones.eliminar'])->syncRoles([$catalogador]);
        //permissions almacenes
        Permission::create(['name' => 'fict.almacenes.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.almacenes.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.almacenes.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.almacenes.eliminar'])->syncRoles([$catalogador]);
        //permissions unidades de medidas
        Permission::create(['name' => 'fict.unidades.inicio'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.unidades.crear'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.unidades.editar'])->syncRoles([$catalogador]);
        Permission::create(['name' => 'fict.unidades.eliminar'])->syncRoles([$catalogador]);
        //permissions usuarios
        Permission::create(['name' => 'usuarios.inicio']);
        Permission::create(['name' => 'usuarios.crear']);
        Permission::create(['name' => 'usuarios.editar']);
        Permission::create(['name' => 'usuarios.eliminar']);
        //permissions perfiles
        Permission::create(['name' => 'perfiles.inicio']);
        Permission::create(['name' => 'perfiles.crear']);
        Permission::create(['name' => 'perfiles.editar']);
        Permission::create(['name' => 'perfiles.eliminar']);
        //permissions of permissions
        Permission::create(['name' => 'permisos.inicio']);
        Permission::create(['name' => 'permisos.crear']);
        Permission::create(['name' => 'permisos.editar']);
        Permission::create(['name' => 'permisos.eliminar']);
        //permissions correos de usuarios
        Permission::create(['name' => 'usuarioscorreos.inicio']);
        Permission::create(['name' => 'usuarioscorreos.crear']);
        Permission::create(['name' => 'usuarioscorreos.editar']);
        Permission::create(['name' => 'usuarioscorreos.eliminar']);

        $administrador->givePermissionTo(Permission::all());
        // or may be done by chaining
    }
}
