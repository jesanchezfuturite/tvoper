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
                    <option>Jose Enrique Sanchez Villanueva</option>
                    <option>Francisco Cerda Duran</option>
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



@endsection



@section('scripts')

<script type="text/javascript">

    
</script>
@endsection
