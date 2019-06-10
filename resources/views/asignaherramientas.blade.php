@extends('layout.app')

@section('content')

<h3 class="page-title">
Configuración <small> Asignación de Herramientas</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Asignación Herramientas</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet-body">
            <h4>Listado de usuarios</h4>
            
            <div class="form-group">
                
                <select id="users_select" class="form-control">
                    <option value="0"> ----- </option>
                    @foreach($users as $user)
                        <option value='{{$user->email}}'>{{$user->name}} - ({{$user->email}})</option>
                    @endforeach
                </select>
            </div>
            
            <hr>
            <h4>Nivel principal</h4>
            <div class="row">
                <div class="col-md-3">
                    <select id="principal_level" class="form-control">
                        <option>Consultas</option>
                        <option>Operación</option>
                        <option>Administración</option>
                        <option>Reportes</option>
                        <option>Indicadores</option>
                    </select>
                </div>
                <div class="col-md-3">
                    Disponibles:
                    <select multiple id="secondary_level" class="form-control">
                        <option>Reporte 1</option>
                        <option>Reporte 2</option>
                        <option>Reporte 3</option>
                        <option>Reporte 4</option>
                        <option>Reporte 5</option>
                    </select>
                </div>
                <div class="col-md-3">
                    
                    <div class="btn-toolbar">
                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10 center-block">
                            <button type="button" class="btn red"> << </button>
                            <button type="button" class="btn green"> >> </button>
                        </div>
                    </div>
                
                </div>
                <div class="col-md-3">
                    Agregadas:
                    <select multiple id="secondary_level" class="form-control">
                        
                    </select>
                </div>
            </div>
            <hr>
            <h4>Nivel secundario</h4>
            <div class="row">
                <div class="col-md-3">
                    <select id="principal_level" class="form-control">
                        <option>Consultas</option>
                        <option>Operación</option>
                        <option>Administración</option>
                        <option>Reportes</option>
                        <option>Indicadores</option>
                    </select>
                </div>
                <div class="col-md-3">
                    Disponibles:
                    <select multiple id="secondary_level" class="form-control">
                        <option>Reporte 1</option>
                        <option>Reporte 2</option>
                        <option>Reporte 3</option>
                        <option>Reporte 4</option>
                        <option>Reporte 5</option>
                    </select>
                </div>
                <div class="col-md-3">
                    
                    <div class="btn-toolbar">
                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10 center-block">
                            <button type="button" class="btn red"> << </button>
                            <button type="button" class="btn green"> >> </button>
                        </div>
                    </div>
                
                </div>
                <div class="col-md-3">
                    Agregadas:
                    <select multiple id="secondary_level" class="form-control">
                        
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="first_level" name="first_level" value="{{ $first_level }}" >
<input type="hidden" id="second_level" name="second_level" value="{{ $second_level }}" >
<input type="hidden" id="third_level" name="third_level" value="{{ $third_level }}" >


@endsection



@section('scripts')

<script type="text/javascript">


    $( document ).ready(function() {
        var elements = $.parseJSON($("#first_level").val());

        //clean the principal level
        $('#principal_level').empty();

        $.each(elements,function(i, item){

           $('#principal_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 

        });

    });
    
</script>
@endsection
