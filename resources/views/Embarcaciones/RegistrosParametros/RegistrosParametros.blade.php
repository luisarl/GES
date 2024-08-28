@extends('layouts.master')

@section('titulo', 'Registros de Parametros')

@section('titulo_pagina', 'Registros de Parametros')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('embaregistrosparametros.index') }}">Registros de Parametros</a></li>
    </ul>

@endsection
<style>
th:first-child, td:first-child
{
    position:sticky;
    left:0px;
    background-color: #FFF;
    opacity: 1;
    text-align: left;
    font-weight: bold;
}

</style>

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Buscar Registros de Parametros</h5>
            
            <div class="float-right">
                @can('emba.registroparametros.crear') 
                <a class="btn btn-primary" title="Nuevo" href="{!! route('embaregistrosparametros.create') !!}">
                    <i class="fa fa-plus"></i> Nuevo</a>
                @endcan
            </div>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Maquina</label>
                    <div class="col-sm-4">
                        <div class="@error('id_maquina') is-invalid @enderror">
                            <select name="id_maquina" id="id_maquina"
                                data-old="{{ old('id_maquina') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione la Maquina</option>
                                @foreach ($maquinas as $maquina)
                                    <option value="{{$maquina->id_maquina}}">{{$maquina->nombre_maquina}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="col-sm-1 col-form-label">Fecha</label>
                    <div class="col-sm-3">
                        <input type="date" value="" max="{{date("Y-m-d")}}" class="form-control" name="fecha" id="fecha">
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-sm btn-primary form-control" name="buscar" onClick="CargarTablaBuscar();"><i class="fa fa-search"></i> </button>
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-sm btn-primary form-control" title="Imprimir" href="#" onclick="window.location.href='embaregistroparametrospdf/'+document.getElementById('id_maquina').value+'/'+document.getElementById('fecha').value, '_blank'" >
                            <i class="fa fa-print"></i></a>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="10" cols="10" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" 
                        id="observaciones" readonly>{{ old('observaciones') }}</textarea>
                    </div>
                </div>
                <h5 class="sub-title">Tabla de Parametros</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" id="tabla_parametros" style="width:100%">
                        <thead>
                            <th>Parametros</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                            <th>20</th>
                            <th>21</th>
                            <th>22</th>
                            <th>23</th>       
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <hr>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- personalizado -->
<script>
    var BuscarRegistroParametros = "{{ url('embabuscarregistroparametros') }}";
    var BuscarObservacionesRegistroParametros = "{{ url('embabuscarobservacionesregistroparametros') }}";
</script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\Embaregistrosparametros.js') }}"></script>

@endsection
