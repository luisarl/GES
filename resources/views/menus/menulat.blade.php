<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Menu</div>
        <ul class="pcoded-item pcoded-left-item">
          <!-- Dashboard principal  -->
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <span class="pcoded-micon"><i class="fa fa-home"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
            </li>
            <!-- Inicio de Ficha Tecnica  -->
            {{-- @can('menu.fichatecnica')
                <li class="pcoded-hasmenu {{ request()->is('dashboardfict','articulos' , 'ubicacionesarticulos' , 'articulosubicaciones/create' , 'grupos' , 'subgrupos', 'categorias', 'clasificaciones', 'unidades', 'subclasificaciones') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                        <span class="pcoded-mtext">Ficha Tecnica</span>
                    </a>
                    <ul class="pcoded-submenu">
                      
                        <li class="{{ request()->is('dashboardfict') ? 'active' : '' }}">
                            <a href="{{ route('dashboardfict') }}">
                                <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i> Dashboard</span>
                            </a>
                        </li>
                        
                        @can('fict.articulos.inicio')
                            <li class="{{ request()->is('articulos') ? 'active' : '' }}">
                                <a href="{{ route('articulos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-shopping-bag">&nbsp;</i> Articulos</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('fict.ubicaciones.inicio')
                        <li class="{{ request()->is('ubicacionesarticulos') ? 'active' : '' }}">
                            <a href="{{ route('ubicacionesarticulos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-map-marker">&nbsp;</i> Zonas</span>
                            </a>
                        </li>
                        @endcan
                        @can('fict.articulos.ubicacion')
                        <li class="{{ request()->is('articulosubicaciones/create') ? 'active' : '' }}">
                            <a href="{{ route('articulosubicaciones.create') }}">
                                <span class="pcoded-mtext"><i class="fa fa-map">&nbsp;</i> Articulo Por ubicacion</span>
                            </a>
                        </li>
                        @endcan
                        
                        @can('fict.grupos.inicio')
                            <li class="{{ request()->is('grupos') ? 'active' : '' }}">
                                <a href="{{ route('grupos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-th-large">&nbsp;</i> Grupos</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('fict.subgrupos.inicio')
                            <li class="{{ request()->is('subgrupos') ? 'active' : '' }}">
                                <a href="{{ route('subgrupos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-th">&nbsp;</i> Sub Grupos</span>
                                </a>
                            </li>
                        @endcan
                       
                        @can('fict.categorias.inicio')
                            <li class="{{ request()->is('categorias') ? 'active' : '' }}">
                                <a href="{{ route('categorias.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-list-ol">&nbsp;</i> Categorias</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('fict.clasificaciones.inicio')
                            <li class="{{ request()->is('clasificaciones') ? 'active' : '' }}">
                                <a href="{{ route('clasificaciones.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-cube">&nbsp;</i> Clasificaciones</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('fict.subclasificaciones.inicio')
                            <li class="{{ request()->is('subclasificaciones') ? 'active' : '' }}">
                                <a href="{{ route('subclasificaciones.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-cubes">&nbsp;</i> Sub Clasificaciones</span>
                                </a>
                            </li>
                        @endcan
                       
                        @can('fict.unidades.inicio')
                            <li class="{{ request()->is('unidades') ? 'active' : '' }}">
                                <a href="{{ route('unidades.index') }}">

                                    <span class="pcoded-mtext"><i class="ti-ruler-alt">&nbsp;</i>Unidades de Medida</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}
            <!-- Fin de Ficha Tecnica  -->

            <!-- Inicio de Activos  -->
            @can('menu.activos')
                <li class="pcoded-hasmenu {{ request()->is('activos', 'tiposactivos', 'subtiposactivos', 'caracteristicasactivos', 'estadosactivos') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-archive"></i></span>
                        <span class="pcoded-mtext">GESActivos</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('actv.activos.inicio')
                            <li class="{{ request()->is('activos') ? 'active' : '' }}">
                                <a href="{{ route('activos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-bookmark">&nbsp;</i> Activos</span>
                                </a>
                            </li>
                        @endcan 
                        @can('actv.tipos.inicio')
                            <li class="{{ request()->is('tiposactivos') ? 'active' : '' }}">
                                <a href="{{ route('tiposactivos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-tag">&nbsp;</i> Tipos de Activos</span>
                                </a>
                            </li>
                        @endcan
                        @can('actv.subtipos.inicio')
                            <li class="{{ request()->is('subtiposactivos') ? 'active' : '' }}">
                                <a href="{{ route('subtiposactivos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-cubes">&nbsp;</i> Subtipos de Activos</span>
                                </a>
                            </li>
                        @endcan
                        @can('actv.caracteristicas.inicio')
                            <li class="{{ request()->is('caracteristicasactivos') ? 'active' : '' }}">
                                <a href="{{ route('caracteristicasactivos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-tags">&nbsp;</i> Caracteristicas</span>
                                </a>
                            </li>
                        @endcan
                        @can('actv.estados.inicio')
                        <li class="{{ request()->is('estadosactivos') ? 'active' : '' }}">
                            <a href="{{ route('estadosactivos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-tags">&nbsp;</i> Estados</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <!-- Fin de Activos  -->

            <!-- Inicio de Compras  -->
            {{-- @can('menu.compras')
                <li class="pcoded-hasmenu {{ request()->is('proveedores', 'zonas', 'tiposproveedor', 'segmentos', 'compactualizarpreciosoc/create') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-cart-arrow-down"></i></span>
                        <span class="pcoded-mtext">Compras</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('comp.proveedores.inicio')
                            <li class="{{ request()->is('proveedores') ? 'active' : '' }}">
                                <a href="{{ route('proveedores.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-group">&nbsp;</i> Proveedores</span>
                                </a>
                            </li>
                        @endcan
                        @can('comp.zonas.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('zonas') ? 'active' : '' }}">
                                <a href="{{ route('zonas.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-map">&nbsp;</i> Zonas</span>
                                </a>
                            </li>
                        @endcan
                        @can('comp.tiposproveedor.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('tiposproveedor') ? 'active' : '' }}">
                                <a href="{{ route('tiposproveedor.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-tags">&nbsp;</i> Tipo Proveedor</span>
                                </a>
                            </li>
                        @endcan
                        @can('comp.segmentos.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('segmentos') ? 'active' : '' }}">
                                <a href="{{ route('segmentos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-sort-amount-desc">&nbsp;</i> Segmento</span>
                                </a>
                            </li>
                        @endcan
                        @can('comp.actualizarpreciosoc')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('compactualizarpreciosoc/create') ? 'active' : '' }}">
                                <a href="{{ route('compactualizarpreciosoc.create') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-cur-dollar-true">&nbsp;</i> Actualizar Precios OC</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}
            <!-- Fin de Compras  -->
            
            {{-- @can('menu.autorizacionsalidas')
                <!-- Inicio de Salidas de Materiales  -->
                <li class="pcoded-hasmenu {{ request()->is('vehiculos' , 'autorizacionsalidas', 'asaltipos', 'asalsubtipos') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="icofont icofont-truck-loaded"></i></span>
                        <span class="pcoded-mtext">Salidas Materiales</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('asal.salidamateriales.inicio')
                        <li class="{{ request()->is('autorizacionsalidas') ? 'active' : '' }}">
                            <a href="{{route('autorizacionsalidas.index')}}">
                                <span class="pcoded-mtext"><i class="fa fa-sort-alpha-asc">&nbsp;</i> Autorización de Salida</span>
                            </a>
                        </li>
                        @endcan
                        @can('asal.vehiculos.inicio')
                        <li class="{{ request()->is('vehiculos') ? 'active' : '' }}">
                            <a href="{{ route('vehiculos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-bus">&nbsp;</i> Vehiculos</span>
                            </a>
                        </li>
                        @endcan
                        @can('asal.tipos.inicio')
                        <li class="{{ request()->is('asaltipos') ? 'active' : '' }}">
                            <a href="{{ route('asaltipos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-tag">&nbsp;</i> Tipos</span>
                            </a>
                        </li>
                        @endcan
                        @can('asal.subtipos.inicio')
                        <li class="{{ request()->is('asalsubtipos') ? 'active' : '' }}">
                            <a href="{{ route('asalsubtipos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-tags">&nbsp;</i> SubTipos</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <!-- Fin de Salidas de Materiales  -->
            @endcan --}}
            <!-- Inicio de Control de Herramientas -->
            @can('menu.controlherramientas')
                <li class="pcoded-hasmenu {{ request()->is('inventarios', 'dashboardcnth' ,'herramientas', 'plantillas','despachos', 'entradas', 'salidas') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="icofont icofont-tools-alt-2"></i></span>
                        <span class="pcoded-mtext">GESHerramientas </span>
                    </a>
                    <ul class="pcoded-submenu">
                        <!--Dashboard modulo Control Herramienta-->
                        <li class="{{ request()->is('dashboardcnth') ? 'active' : '' }}">
                            <a href="{{ route('dashboardcnth') }}">
                                <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i> Dashboard</span>
                            </a>
                        </li>
                        @can('cnth.herramientas.inicio')
                        <!--Herramienta modulo Control Herramienta-->
                        <li class="{{ request()->is('herramientas') ? 'active' : '' }}">
                            <a href="{{ route('herramientas.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-wrench">&nbsp;</i> Herramientas</span>
                            </a>
                        </li>                            
                        @endcan
                        
                        @can('cnth.plantillas.inicio')   
                        <!-- Plantillas Modulo Control Herramientas -->
                        <li class="{{ request()->is('plantillas') ? 'active' : '' }}">
                            <a href="{{ route('plantillas.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-list-alt">&nbsp;</i> Plantillas </span>
                            </a>
                        </li>
                        @endcan 

                        @can('cnth.movimientos.inicio')
                        <!--Despacho modulo Control Herramienta-->
                        <li class="{{ request()->is('despachos') ? 'active' : '' }}">
                            <a href="{{ route('despachos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-exchange">&nbsp;</i> Despacho / Recepcion</span>
                            </a>
                        </li>
                        @endcan

                        <!--Ajustes de Entrada y Salida modulo Control Herramienta-->
                        @can('cnth.entradas.inicio')
                            <li class="{{ request()->is('entradas') ? 'active' : '' }}">
                                <a href="{{ route('entradas.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-download-alt">&nbsp;</i> Entradas </span>
                                </a>
                            </li>
                        @endcan

                        @can('cnth.salidas.inicio')   
                            <li class="{{ request()->is('salidas') ? 'active' : '' }}">
                                <a href="{{ route('salidas.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-upload-alt">&nbsp;</i> Salidas </span>
                                </a>
                            </li>
                        @endcan 
                        @can('cnth.inventario.inicio')
                            <li class="pcoded-hasmenu {{ request()->is('inventarios', 'ubicaciones', 'empleados', 'solicitudes','zonadespacho', 'cnthgrupos', 'cnthsubgrupos', 'cnthcategorias') ? 'pcoded-trigger' : '' }}">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="fa fa-bar-chart-o"></i></span>
                                    <span class="pcoded-mtext"> Opciones Inventario</span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <!--Grupos modulo Control Herramienta-->
                                @can('cnth.grupos.inicio') 
                                    <li class="{{ request()->is('cnthgrupos') ? 'active' : '' }}">
                                        <a href="{{ route('cnthgrupos.index') }}">
                                            <span class="pcoded-mtext"><i class="fa fa-th-large">&nbsp;</i> Grupos</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- @endcan --}}
                                <!--Subgrupos modulo Control Herramienta-->
                                @can('cnth.subgrupos.inicio')
                                    <li class="{{ request()->is('cnthsubgrupos') ? 'active' : '' }}">
                                        <a href="{{ route('cnthsubgrupos.index') }}">
                                            <span class="pcoded-mtext"><i class="fa fa-th">&nbsp;</i> Sub Grupos</span>
                                        </a>
                                    </li>
                                @endcan
                                <!--Categorias modulo Control Herramienta-->
                                
                                @can('cnth.categorias.inicio')
                                    <li class="{{ request()->is('cnthcategorias') ? 'active' : '' }}">
                                        <a href="{{ route('cnthcategorias.index') }}">
                                            <span class="pcoded-mtext"><i class="fa fa-list-ol">&nbsp;</i> Categorias</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('cnth.ubicaciones.inicio')
                                <!--Ubicaciones modulo Control Herramienta-->
                                <li class="{{ request()->is('ubicaciones') ? 'active' : '' }}">
                                    <a href="{{ route('ubicaciones.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-map-marker">&nbsp;</i> Ubicaciones</span>
                                    </a>
                                </li>
                                @endcan
        
                                @can('cnth.zonas.inicio')
                                <!--Zonas modulo Control Herramienta-->
                                <li class="{{ request()->is('zonadespacho') ? 'active' : '' }}">
                                    <a href="{{ route('zonadespacho.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-map">&nbsp;</i> Zonas Despacho</span>
                                    </a>
                                </li>    
                                @endcan
                                
                                @can('cnth.responsables.inicio')
                                <!--Ubicaciones modulo Control Herramienta-->
                                <li class="{{ request()->is('empleados') ? 'active' : '' }}">
                                    <a href="{{ route('empleados.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-user">&nbsp;</i> Empleados</span>
                                    </a>
                                </li>
                                @endcan

                                <!--Inventario modulo Control Herramienta-->
                                    {{-- @can('herramientas') 
                                        <li class="{{ request()->is('inventarios') ? 'active' : '' }}">
                                            <a href="{{ route('inventarios.index') }}">
                                                <span class="pcoded-mtext"><i class="fa fa-bar-chart-o">&nbsp;</i> Inventario</span>
                                            </a>
                                        </li>--}}
                                    {{-- @endcan 
                                    <!--Traslado de Almacenes modulo Control Herramienta-->
                                    @can('cnth.inventario.traslado')
                                        <li class="{{ request()->is('trasladosalmacenes') ? 'active' : '' }}">
                                            <a href="{{ route('trasladosalmacenes.index') }}">
                                                <span class="pcoded-mtext"><i class="fa fa-random">&nbsp;</i> Traslado entre
                                                    Alms</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <!--Tipo Ajustes modulo Control Herramienta-->
                                    {{-- @can('herramientas')
                                        <li class="{{ request()->is('tiposajustes') ? 'active' : '' }}">
                                            <a href="{{ route('tiposajustes.index') }}">
                                                <span class="pcoded-mtext"><i class="fa fa-envelope">&nbsp;</i> Tipo Ajuste</span>
                                            </a>
                                        </li>
                                    {{-- @endcan --}}

                                </ul>
                            </li>
                        @endcan
                        
                        {{-- @endcan --}}
                    </ul>
                </li>
            @endcan
            <!-- Fin de Control de herramientas -->

            <!-- Inicio de Solicitudes de Servicio  -->
            @can('menu.solicitudesservicios')
                <li class="pcoded-hasmenu {{ request()->is('dashboardsols', 'solicitudes', 'servicios', 'subservicios', 'responsables') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-clip-board"></i></span>
                        <span class="pcoded-mtext">GESServicios</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <!--Dashboard modulo Solicitudes Servicios-->
                        @can('sols.dashboard')
                            <li class="{{ request()->is('dashboardsols') ? 'active' : '' }}">
                                <a href="{{ route('dashboardsols') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i> Dashboard</span>
                                </a>
                            </li>
                        @endcan
                        @can('sols.solicitudes.inicio')
                            <li class="{{ request()->is('solicitudes') ? 'active' : '' }}">
                                <a href="{{ route('solicitudes.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Solicitudes</span>
                                </a>
                            </li>
                        @endcan
                        @can('sols.servicios.inicio')
                            <li class="{{ request()->is('servicios') ? 'active' : '' }}">
                                <a href="{{ route('servicios.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-tools"></i>&nbsp;</i> Servicios</span>
                                </a>
                            </li>
                        @endcan
                        @can('sols.subservicios.inicio')
                            <li class="{{ request()->is('subservicios') ? 'active' : '' }}">
                                <a href="{{ route('subservicios.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-tools-bag"></i>&nbsp;</i> Sub Servicios</span>
                                </a>
                            </li>
                        @endcan
                        @can('sols.responsables.inicio')
                        <!--Ubicaciones modulo Control Herramienta-->
                        <li class="{{ request()->is('responsables') ? 'active' : '' }}">
                            <a href="{{ route('responsables.index') }}"> <!--MODIFICAR RUTA-->
                                <span class="pcoded-mtext"><i class="fa fa-users">&nbsp;</i> Responsables</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <!-- Fin Solicitudes de Servicio  -->

            <!-- Inicio de Centro de Corte  -->
            {{-- @can('menu.centrocorte')
                <li class="pcoded-hasmenu {{ request()->is('dashboardceco', 'cencfichas', 'cencequipos','cencequipos', 'cencresponsables','cencaprovechamientos','cencconap','cenclistapartes','cencconsumibles', 'cencordentrabajo','cenctablasconsumo','cenctiposfichas','cenccaracteristicastiposfichas') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-object-ungroup"></i></span>
                        <span class="pcoded-mtext">Centro de Corte</span>
                    </a>
                    <ul class="pcoded-submenu">
                       
                        @can('cenc.conap.inicio')
                        <li class="{{ request()->is('cencconap') ? 'active' : '' }}">
                            <a href="{{ route('cencconap.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Conap </span>
                            </a>
                        </li>
                        @endcan
                        @can('cenc.listapartes.inicio')
                        <li class="{{ request()->is('cenclistapartes') ? 'active' : '' }}">
                            <a href="{{ route('cenclistapartes.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-tools">&nbsp;</i> Lista de Partes</span>
                            </a>
                        </li>
                        @endcan 
                        @can('cenc.aprovechamientos.inicio')
                        <li class="{{ request()->is('cencaprovechamientos') ? 'active' : '' }}">
                            <a href="{{ route('cencaprovechamientos.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-stock-search">&nbsp;</i> Aprovechamiento</span>
                            </a>
                        </li>
                        @endcan
                        @can('cenc.ordentrabajo.inicio') 
                        <li class="pcoded-hasmenu {{ request()->is('cencordentrabajo','cencseguimiento','cenccierre') ? 'active' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Orden de trabajo </span>
                            </a>
                            <ul class="pcoded-submenu">
                                
                               <li class="{{ request()->is('cencordentrabajo') ? 'active' : '' }}">
                                   <a href="{{ route('cencordentrabajo.index') }}">
                                       <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Orden</span>
                                   </a>
                               </li>
                               <li class="{{ request()->is('cencseguimiento') ? 'active' : '' }}">
                                   <a href="{{ route('cencseguimiento.index') }}">
                                       <span class="pcoded-mtext"><i class="fa fa-check-square-o">&nbsp;</i> Seguimiento</span>
                                   </a>
                               </li>
                               <li class="{{ request()->is('cenccierre') ? 'active' : '' }}">
                                <a href="{{ route('cenccierre.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-stop-circle-o">&nbsp;</i> Cierre</span>
                                </a>
                            </li>
                           </ul>
                        </li>
                        @endcan 
                        @can('cenc.fichas.inicio')
                        <li class="pcoded-hasmenu {{ request()->is('cencfichas', 'cencfichastipos', 'cencfichascaracteristicas') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fa fa-file-text-o"></i></span>
                                <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Fichas Tecnicas</span>
                            </a>
                            <ul class="pcoded-submenu">
                               
                                <li class="{{ request()->is('cencfichas') ? 'active' : '' }}">
                                    <a href="{{ route('cencfichas.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Fichas</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('cencfichastipos') ? 'active' : '' }}">
                                    <a href="{{ route('cencfichastipos.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-tag">&nbsp;</i> Tipos</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('cencfichascaracteristicas') ? 'active' : '' }}">
                                    <a href="{{ route('cencfichascaracteristicas.index') }}">
                                        <span class="pcoded-mtext"><i class="fa fa-tags"></i>&nbsp;</i> Caracteristicas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>    
                        @endcan
                        @can('cenc.tablaconsumo.inicio') 
                        <li class="{{ request()->is('cenctablasconsumo') ? 'active' : '' }}">
                            <a href="{{ route('cenctablasconsumo.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-pollution">&nbsp;</i>Tablas consumo</span>
                            </a>
                        </li>
                        @endcan
                        @can('cenc.equipos.inicio') 
                            <li class="{{ request()->is('cencequipos') ? 'active' : '' }}">
                                <a href="{{ route('cencequipos.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-help-robot">&nbsp;</i> Equipos</span>
                                </a>
                            </li>
                        @endcan
                        @can('cenc.tecnologia.inicio') 
                        <li class="{{ request()->is('cenctecnologia') ? 'active' : '' }}">
                            <a href="{{ route('cenctecnologia.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-atom">&nbsp;</i> Tecnologia</span>
                            </a>
                        </li>
                        @endcan 
                        @can('cenc.consumibles.inicio') 
                        <li class="{{ request()->is('cencconsumibles') ? 'active' : '' }}">
                            <a href="{{ route('cencconsumibles.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-energy-oil">&nbsp;</i> Consumibles</span>
                            </a>
                        </li>
                        @endcan 
                        {{-- @can('cenc.responsables.inicio') 
                        <li class="{{ request()->is('cencresponsables') ? 'active' : '' }}">
                            <a href="{{ route('cencresponsables.index') }}"> 
                                <span class="pcoded-mtext"><i class="fa fa-users">&nbsp;</i> Responsables</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}
            <!-- Fin Centro de Corte -->

            {{-- Inicio Resguardo --}}
            {{-- @can('menu.resguardo')
                <li class="pcoded-hasmenu {{ request()->is('resgresguardos','resgsolicitudes', 'resgdespachos', 'resgdesincorporaciones', 'resgclasificaciones', 'resgubicaciones') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-briefcase"></i></span>
                        <span class="pcoded-mtext">Resguardo</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('resg.resguardos.inicio')
                            <li class="{{ request()->is('resgresguardos') ? 'active' : '' }}">
                                <a href="{{ route('resgresguardos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-briefcase">&nbsp;</i>Articulos en Resguardos</span>
                                </a>
                            </li>
                        @endcan 
                        @can('resg.solresguardo.inicio')
                            <li class="{{ request()->is('resgsolicitudes') ? 'active' : '' }}">
                                <a href="{{ route('resgsolicitudes.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-ui-clip-board">&nbsp;</i> Solicitud Resguardo</span>
                                </a>
                            </li>
                        @endcan
                        @can('resg.soldespacho.inicio')
                            <li class="{{ request()->is('resgdespachos') ? 'active' : '' }}">
                                <a href="{{ route('resgdespachos.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-ui-clip-board">&nbsp;</i>Solicitud Despacho</span>
                                </a>
                            </li>
                        @endcan
                        @can('resg.soldesincorporacion.inicio')
                            <li class="{{ request()->is('resgdesincorporaciones') ? 'active' : '' }}">
                                <a href="{{ route('resgdesincorporaciones.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-ui-delete">&nbsp;</i>Solicitud Desincorporacion</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('resg.clasificaciones.inicio')
                            <li class="{{ request()->is('resgclasificaciones') ? 'active' : '' }}">
                                <a href="{{ route('resgclasificaciones.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-cube">&nbsp;</i> Clasificaciones</span>
                                </a>
                            </li>
                        @endcan
                        @can('resg.ubicaciones.inicio')
                        <li class="{{ request()->is('resgubicaciones') ? 'active' : '' }}">
                            <a href="{{ route('resgubicaciones.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-map">&nbsp;</i> Ubicaciones</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan     --}}
            {{-- Fin Resguardo --}}

            {{-- Inicio Gestion Asistencia --}}
             @can('menu.gestionasistencia')
            <li class="pcoded-hasmenu {{ request()->is('gstadashboard', 'gstahorarios', 'gstaempleados', 'gstanovedades', 'gstaasistencias',
            'gstaasistenciasvalidaciones/create', 'gstalistadovalidaciones') ? 'pcoded-trigger' : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-calendar-check-o"></i></span>
                    <span class="pcoded-mtext">GESAsistencia</span>
                </a>
                <ul class="pcoded-submenu">
                    {{-- @can('resg.resguardos.inicio') --}}
                    <li class="{{ request()->is('gstadashboard') ? 'active' : '' }}">
                        <a href="{{ route('gstadashboard') }}">
                            <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i> Dashboard</span>
                        </a>
                    </li>
                    {{-- @endcan --}}
                    @can('gsta.horarios.inicio')
                        <li class="{{ request()->is('gstahorarios') ? 'active' : '' }}">
                            <a href="{{ route('gstahorarios.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-clock-o">&nbsp;</i> Horarios</span>
                            </a>
                        </li>
                     @endcan
                     @can('gsta.empleados.inicio')
                        <li class="{{ request()->is('gstaempleados') ? 'active' : '' }}">
                            <a href="{{ route('gstaempleados.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-group">&nbsp;</i> Empleados</span>
                            </a>
                        </li>
                    @endcan
                    @can('gsta.novedades.inicio')
                        <li class="{{ request()->is('gstanovedades') ? 'active' : '' }}">
                            <a href="{{ route('gstanovedades.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-exclamation-triangle">&nbsp;</i> Novedades</span>
                            </a>
                        </li>
                    @endcan 
                    @can('gsta.asistencias.inicio')
                        <li class="{{ request()->is('gstaasistencias') ? 'active' : '' }}">
                            <a href="{{ route('gstaasistencias.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-ui-clip-board">&nbsp;</i>Asistencias</span>
                            </a>
                        </li>
                    @endcan

                  
                    @can('gsta.validacionasistencias.crear')
                        <li class="{{ request()->is('gstaasistenciasvalidaciones/create') ? 'active' : '' }}">
                            <a href="{{ route('gstaasistenciasvalidaciones.create') }}">
                                <span class="pcoded-mtext"><i class="fa fa-calendar-check-o">&nbsp;</i>Validacion Asistencias</span>
                            </a>
                        </li>
                    @endcan

                    @can('gsta.validacionasistencias.editar')
                        <li class="{{ request()->is('gstalistadovalidaciones') ? 'active' : '' }}">
                            <a href="{{ route('gstalistadovalidacioneseditar') }}">
                                <span class="pcoded-mtext"><i class="fa fa-edit">&nbsp;</i>Editar Validaciones</span>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
            @endcan
                
            {{-- Fin Gestion Asistencia --}}
            {{-- Inicio Auditoria --}}
            {{-- @can('menu.auditoria')
                <li class="pcoded-hasmenu {{ request()->is('audiauditoriainventario') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="icofont icofont-document-search"></i></span>
                        <span class="pcoded-mtext">Auditoria</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('audi.auditoriainventario.inicio')
                            <li class="{{ request()->is('audiauditoriainventario') ? 'active' : '' }}">
                                <a href="{{ route('audiauditoriainventario.index') }}">
                                    <span class="pcoded-mtext"><i class="icofont icofont-numbered">&nbsp;</i>Auditoria Inventario</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan     --}}
            {{-- Fin Auditoria --}}

            {{-- Inicio Control Combustible --}}
            @can('menu.controlcombustible')
            <li class="pcoded-hasmenu {{ request()->is('cntcdashboard', 'cntcdespachos', 'cntcingresos', 'cntctiposingresos', 'cntctiposcombustible') ? 'pcoded-trigger' : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="zmdi zmdi-local-gas-station"></i></span>
                    <span class="pcoded-mtext">GESCombustible</span>
                </a>
                <ul class="pcoded-submenu">
                    @can('cntc.dashboard')
                        <li class="{{ request()->is('cntcdashboard') ? 'active' : '' }}">
                            <a href="{{ route('cntcdashboard') }}">
                                <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i>Dashboard</span>
                            </a>
                        </li>
                    @endcan 
                    @can('cntc.despachos.inicio')
                        <li class="{{ request()->is('cntcdespachos') ? 'active' : '' }}">
                            <a href="{{ route('cntcdespachos.index') }}">
                                <span class="pcoded-mtext"><i class="zmdi zmdi-local-gas-station">&nbsp;</i> Despachos</span>
                            </a>
                        </li>
                     @endcan
                     @can('cntc.ingresos.inicio')
                        <li class="{{ request()->is('cntcingresos') ? 'active' : '' }}">
                            <a href="{{ route('cntcingresos.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-plus-square">&nbsp;</i> Ingresos</span>
                            </a>
                        </li>
                    @endcan
                    @can('cntc.tiposingresos.inicio')
                        <li class="{{ request()->is('cntctiposingresos') ? 'active' : '' }}">
                            <a href="{{ route('cntctiposingresos.index') }}">
                                <span class="pcoded-mtext"><i class="zmdi zmdi-format-list-bulleted">&nbsp;</i>Tipos de Ingreso</span>
                            </a>
                        </li>
                    @endcan 
                    @can('cntc.tiposcombustibles.inicio')
                        <li class="{{ request()->is('cntctiposcombustible') ? 'active' : '' }}">
                            <a href="{{ route('cntctiposcombustible.index') }}">
                                <span class="pcoded-mtext"><i class="zmdi zmdi-format-list-bulleted">&nbsp;</i>Tipos de Combustible</span>
                            </a>
                        </li>
                    @endcan 

                </ul>
            </li>
            @endcan
                
            {{-- Fin Control Combustible --}}
            {{-- Inicio Control Toner --}}
            {{-- @can('menu.controltoner')
            <li class="pcoded-hasmenu {{ request()->is('cnttcontroltoner','cnttdashboard') ? 'pcoded-trigger' : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="zmdi zmdi-print"></i></span>
                    <span class="pcoded-mtext">Control Toner</span>
                </a>
                <ul class="pcoded-submenu">
                    @can('cntt.controltoner.inicio')
                        <li class="{{ request()->is('cnttcontroltoner') ? 'active' : '' }}">
                            <a href="{{ route('cnttcontroltoner.index') }}">
                                <span class="pcoded-mtext"><i class="zmdi zmdi-print">&nbsp;</i>Control</span>
                            </a>
                        </li>
                    @endcan 
                      @can('cntt.dashboard')
                      <li class="{{ request()->is('cnttdashboard') ? 'active' : '' }}">
                        <a href="{{ route('cnttdashboard') }}">
                            <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i>Dashboard</span>
                        </a>
                    </li>
                @endcan 
                </ul>
            </li>
            @endcan --}}
                
            {{-- Fin Control Toner --}}
            {{-- Inicio Embarcaciones --}}
            {{-- @can('menu.embarcaciones')
            <li class="pcoded-hasmenu {{ request()->is('emba.dashboard','embaregistrosparametros','embanovedades','embamaquinas','embaembarcaciones','embaparametros','embaunidades') ? 'pcoded-trigger' : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="zmdi zmdi-boat"></i></i></span>
                    <span class="pcoded-mtext">Embarcaciones</span>
                </a>
                <ul class="pcoded-submenu">
                    @can('emba.dashboard')
                    <li class="{{ request()->is('embadashboard') ? 'active' : '' }}">
                        <a href="{{ route('embadashboard') }}">
                            <span class="pcoded-mtext"><i class="fa fa-dashboard">&nbsp;</i>Dashboard</span>
                        </a>
                    </li>
                    @endcan
                    @can('emba.registroparametros.inicio')
                    <li class="{{ request()->is('embaregistrosparametros') ? 'active' : '' }}">
                        <a href="{{ route('embaregistrosparametros.index') }}">
                            <span class="pcoded-mtext"><i class="icofont icofont-ui-clip-board">&nbsp;</i>Registros Parametros</span>
                        </a>
                    </li>
                    @endcan
                    @can('emba.novedades.inicio')
                    <li class="{{ request()->is('embanovedades') ? 'active' : '' }}">
                        <a href="{{ route('embanovedades.index') }}">
                            <span class="pcoded-mtext"><i class="icofont icofont-megaphone-alt">&nbsp;</i>Novedades</span>
                        </a>
                    </li>
                    @endcan
                    @can('emba.maquinas.inicio')
                    <li class="{{ request()->is('embamaquinas') ? 'active' : '' }}">
                        <a href="{{ route('embamaquinas.index') }}">
                            <span class="pcoded-mtext"><i class="icofont icofont-ui-settings">&nbsp;</i>Maquinas</span>
                        </a>
                    </li>
                    @endcan
                    @can('emba.embarcaciones.inicio')
                    <li class="{{ request()->is('embaembarcaciones') ? 'active' : '' }}">
                        <a href="{{ route('embaembarcaciones.index') }}">
                            <span class="pcoded-mtext"><i class="zmdi zmdi-boat">&nbsp;</i>Embarcaciones</span>
                        </a>
                    </li>
                    @endcan
                    @can('emba.parametros.inicio')
                        <li class="{{ request()->is('embaparametros') ? 'active' : '' }}">
                            <a href="{{ route('embaparametros.index') }}">
                                <span class="pcoded-mtext"><i class="icofont icofont-energy-oil">&nbsp;</i>Parametros</span>
                            </a>
                        </li>
                    @endcan
                    @can('emba.unidades.inicio')
                        <li class="{{ request()->is('embaunidades') ? 'active' : '' }}">
                            <a href="{{ route('embaunidades.index') }}">
                                <span class="pcoded-mtext"><i class="ti-ruler-alt">&nbsp;</i>Unidades de Medida</span>
                            </a>
                        </li>
                    @endcan 
                </ul>
            </li>
            @endcan --}}
            {{-- Fin Embarcaciones --}}

            <!-- Inicio de Reportes  -->
            @can('menu.reportes')                                                                                                   
            <li class="pcoded-hasmenu">
                <li class="pcoded-hasmenu {{ request()->is('replistadosalidas','replistadoarticuloubicaciones', 'reposolicitudeslogistica','repolistadoactivos', 'reposolpestadoaprobacion', 
                'reposolpasignadacomprador', 'reposolpdepartamentos', 'reposolpestatus', 'repoproductividadcomprador', 'reposalidasarticulodepartamento', 'repofechasfichastecnicas', 'reposeguimientosolpocndr',
                'repcatalogacion', 'repoarticulosresguardo', 'repoplantillasalmacen', 'repohistorialcompras' ) ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                        <span class="pcoded-mtext">Reportes</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('repo.fichatecnica')
                        <li class="pcoded-hasmenu {{ request()->is('replistadoarticuloubicaciones', 'repofechasfichastecnicas', 'repcatalogacion') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-paste">&nbsp;</i> Ficha Tecnica</span>
                            </a>
                            @can('repo.fict.listadoarticuloubicaciones')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('replistadoarticuloubicaciones') ? 'active' : '' }}">
                                    <a href="{{ route('replistadoarticuloubicaciones') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Listado Articulos por Zona</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.fict.fechasfichastecnicas')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repofechasfichastecnicas') ? 'active' : '' }}">
                                    <a href="{{ route('repofechasfichastecnicas') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Fechas Fichas Tecnicas</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.fict.catalogacion')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repcatalogacion') ? 'active' : '' }}">
                                    <a href="{{ route('repcatalogacion') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Catalogacion Articulos</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                        @can('repo.compras')
                        <li class="pcoded-hasmenu {{ request()->is('reposolpestadoaprobacion', 'reposolpasignadacomprador', 'reposolpdepartamentos', 'reposolpestatus','repoproductividadcomprador', 'reposeguimientosolpocndr', 'repohistorialcompras') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-cart-arrow-down">&nbsp;</i> Compras</span>
                            </a>
                            @can('repo.compras.solpestadosaprobacion')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolpestadoaprobacion') ? 'active' : '' }}">
                                    <a href="{{ route('reposolpestadoaprobacion') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitud De Compra Estados Aprobacion</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.solpasignadacomprador')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolpasignadacomprador') ? 'active' : '' }}">
                                    <a href="{{ route('reposolpasignadacomprador') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitudes de Compra Asignadas por Comprador</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.solpdepartamentos')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolpdepartamentos') ? 'active' : '' }}">
                                    <a href="{{ route('reposolpdepartamentos') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitudes de Compra por Departamentos</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.solpestatus')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolpestatus') ? 'active' : '' }}">
                                    <a href="{{ route('reposolpestatus') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitudes de Compra por Estatus</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.productividadcomprador')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repoproductividadcomprador') ? 'active' : '' }}">
                                    <a href="{{ route('repoproductividadcomprador') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Productividad Compradores</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.seguimientosolpndroc')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposeguimientosolpocndr') ? 'active' : '' }}">
                                    <a href="{{ route('reposeguimientosolpocndr') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Seguimiento SOLP OC NDR</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.compras.historialcompras')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repohistorialcompras') ? 'active' : '' }}">
                                    <a href="{{ route('repohistorialcompras') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Historial de Compras</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                        @can('repo.controlherramientas')
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-wrench">&nbsp;</i>Control Herramientas</span>
                            </a>
                           
                            <ul class="pcoded-submenu">
                                @can('repo.cnth.listadoherramientas')
                                <li class="{{ request()->is('repherramientastock') ? 'active' : '' }}">
                                    <a href="{{ route('repherramientastock') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Stock Herramientas</span>
                                    </a>
                                </li>
                                @endcan
                                @can('repo.cnth.listadoestatusdespacho')
                                <li class="{{ request()->is('repestatusdespacho') ? 'active' : '' }}">
                                    <a href="{{ route('repestatusdespacho') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Estatus de Despacho</span>
                                    </a>
                                </li>
                                @endcan
                                @can('repo.cnth.plantillasalmacenes')
                                <li class="{{ request()->is('repoplantillasalmacen') ? 'active' : '' }}">
                                    <a href="{{ route('repoplantillasalmacen') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Plantillas Almacenes</span>
                                    </a>
                                </li>
                                @endcan
                                {{-- <li class="">
                                    <a href="{{ url('#') }}">
                                        <span class="pcoded-mtext"><i class="">&nbsp;</i> Listado Herramienta</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        @endcan
                        @can('repo.gestionasistencia')
                        <li class="pcoded-hasmenu {{ request()->is('gstareportevalidaciones') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-calendar-check-o">&nbsp;</i> Gestion Asistencia</span>
                            </a>
                            @can('repo.gestionasistencia.validaciones')
                                <ul class="pcoded-submenu">
                                    <li class="{{ request()->is('gstareportevalidaciones') ? 'active' : '' }}">
                                        <a href="{{ route('gstareportevalidaciones') }}">
                                            <span class="pcoded-mtext"><i class="e">&nbsp;</i> Reporte Validaciones</span>
                                        </a>
                                    </li>
                                </ul>
                            @endcan

                            @can('repo.gestionasistencia.horasextras')
                                <ul class="pcoded-submenu">
                                    <li class="{{ request()->is('repohorasvalidaciones') ? 'active' : '' }}">
                                        <a href="{{ route('repohorasvalidaciones') }}">
                                            <span class="pcoded-mtext"><i class="e">&nbsp;</i> Reporte Horas Extras</span>
                                        </a>
                                    </li>
                                </ul>   
                            @endcan
                         </li>
                        @endcan    
                        @can('repo.autorizacionsalidas')
                        <li class="pcoded-hasmenu {{ request()->is('replistadosalidas') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="icofont icofont-truck-loaded">&nbsp;</i> Salida Materiales</span>
                            </a>
                            @can('repo.asal.listadosalidas')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('replistadosalidas') ? 'active' : '' }}">
                                    <a href="{{ route('replistadosalidas') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Listado de Salidas</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('repo.asal.listadosalidasauditoria')
                            <ul class="pcoded-submenu"> 
                                <li class="{{ request()->is('replistadosalidasauditoria') ? 'active' : '' }}">
                                    <a href="{{ route('replistadosalidasauditoria') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Listado de Salidas Auditoria</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan                           
                        </li>
                        @endcan
                        @can('repo.solicitudes')
                        <li class="pcoded-hasmenu {{ request()->is('reposolicitudeslogistica') ? 'pcoded-trigger' : '' }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-file-text-o">&nbsp;</i> Solicitudes Servicio</span>
                            </a>
                            @can('repo.solicitudes.logistica')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolicitudeslogistica') ? 'active' : '' }}">
                                    <a href="{{ route('reposolicitudeslogistica') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitudes de logistica</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan

                            @can('repo.solicitudes.departamentos')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposolicitudesdepartamentos') ? 'active' : '' }}">
                                    <a href="{{ route('reposolicitudesdepartamentos') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Solicitudes por Departamentos</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                        @can('repo.activos')
                        <li class="pcoded-hasmenu {{ request()->is('repolistadoactivos') ? 'pcoded-trigger' : '' }}">
                            <a  href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-archive">&nbsp;</i> Activos</span>
                            </a>
                            @can('repo.activos.listadoactivos')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repolistadoactivos') ? 'active' : '' }}">
                                    <a href="{{ route('repolistadoactivos') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Listado Activos</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                        @can('repo.salidasarticulos')
                        <li class="pcoded-hasmenu {{ request()->is('reposalidasarticulodepartamento') ? 'pcoded-trigger' : '' }}">
                            <a  href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-shopping-bag">&nbsp;</i> Salida de Articulos</span>
                            </a>
                            @can('repo.salidasarticulos.departamentomes')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('reposalidasarticulodepartamento') ? 'active' : '' }}">
                                    <a href="{{ route('reposalidasarticulodepartamento') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Salida de Articulos por Departamento</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                        @can('repo.resguardo')
                        <li class="pcoded-hasmenu {{ request()->is('repoarticulosresguardo') ? 'pcoded-trigger' : '' }}">
                            <a  href="javascript:void(0)">
                                <span class="pcoded-mtext"><i class="fa fa-briefcase">&nbsp;</i> Resguardo</span>
                            </a>
                            @can('repo.resg.articulosresguardo')
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->is('repoarticulosresguardo') ? 'active' : '' }}">
                                    <a href="{{ route('repoarticulosresguardo') }}">
                                        <span class="pcoded-mtext"><i class="e">&nbsp;</i> Articulos en Resguardo</span>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <!-- Fin de Reportes  -->

            <!-- Inicio de Usuarios  -->

            @can('menu.configuracion')
                <li class="pcoded-hasmenu {{ request()->is('paises', 'empresas', 'almacenes', 'departamentos', 'usuarios', 'perfiles', 'usuarioscorreos', 'permisos') ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-gear"></i></span>
                        <span class="pcoded-mtext">Configuracion</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('conf.paises.inicio')
                        <li class="pcoded-submenu">
                        <li class="{{ request()->is('paises') ? 'active' : '' }}">
                            <a href="{{ route('paises.index') }}">
                                <span class="pcoded-mtext"><i class="fa fa-globe">&nbsp;</i> Paises</span>
                            </a>
                        </li>
                        @endcan
                        @can('conf.empresas.inicio')
                            <li class="{{ request()->is('empresas') ? 'active' : '' }}">
                                <a href="{{ route('empresas.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-industry">&nbsp;</i> Empresas</span>
                                </a>
                            </li>
                        @endcan
                        <!--Almacenes modulo Ficha Configuracion-->
                        @can('conf.almacenes.inicio')
                            <li class="{{ request()->is('almacenes') ? 'active' : '' }}">
                                <a href="{{ route('almacenes.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-building-o">&nbsp;</i> Almacenes</span>
                                </a>
                            </li>
                        @endcan
                        
                         <!--SubAlmacenes modulo Ficha Configuracion-->
                        @can('conf.subalmacenes.inicio')
                            <li class="{{ request()->is('subalmacenes') ? 'active' : '' }}">
                                <a href="{{ route('subalmacenes.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-building-o">&nbsp;</i> Sub Almacenes</span>
                                </a>
                            </li>
                        @endcan

                        <!--departamentos modulo Configuracion-->
                        @can('conf.departamentos.inicio')
                        <li class="{{ request()->is('departamentos') ? 'active' : '' }}">
                                <a href="{{ route('departamentos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-dedent">&nbsp;</i> Departamentos</span>
                                </a>
                            </li>
                        @endcan
                        @can('conf.usuarios.inicio')
                            <li class="{{ request()->is('usuarios') ? 'active' : '' }}">
                                <a href="{{ route('usuarios.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-user-plus">&nbsp;</i> Usuarios</span>
                                </a>
                            </li>
                        @endcan
                        @can('conf.perfiles.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('perfiles') ? 'active' : '' }}">
                                <a href="{{ route('perfiles.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-users">&nbsp;</i> Perfiles </span>
                                </a>
                            </li>
                        @endcan
                        @can('conf.permisos.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('permisos') ? 'active' : '' }}">
                                <a href="{{ route('permisos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-lock">&nbsp;</i> Permisos </span>
                                </a>
                            </li>
                        @endcan
                        @can('conf.usuarioscorreos.inicio')
                            <li class="pcoded-submenu">
                            <li class="{{ request()->is('correos') ? 'active' : '' }}">
                                <a href="{{ route('correos.index') }}">
                                    <span class="pcoded-mtext"><i class="fa fa-envelope">&nbsp;</i> Mensajeria</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <!-- Fin de Usuarios  -->
        </ul>
    </div>
</nav>
