@extends('layout.app')

@section('content')
<h3 class="page-title"> Conciliación <small>Resultados de conciliación</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Operación - Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Resultados</a>
        </li>
    </ul>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta herramienta muestra los resultados de la conciliación realizada por fecha específica.
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Consultar resultados conciliación</label>
            <div class="col-md-3">
                <input id="fecha" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha">
                <span class="help-block">
                 </span>
                <button class="btn blue" id="busqueda" type="submit">
                    Buscar
                </button>
            </div>
        </div>
    </div>
</div>
<div id="bancos_tabs" class="row">
    <hr> 
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_0" data-toggle="tab">Operaciones</a>
                </li>
                <li>
                    <a href="#tab_1" data-toggle="tab">Egobierno</a>
                </li>                            
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet-body" id="table_1"> 
                        <table class="table table-hover" id="sample_3">
                            <thead>
                                <tr>
                                    <th></th> 
                                    <th colspan="5">Internet</th>
                                    <th colspan="5" style="background-color: #E9E9E9">Modulo de operaciones</th>
                                </tr>
                                <tr>
                                    <th>Cuenta</th> 
                                    <th>Trámites</th>
                                    <th>Conciliados</th>
                                    <th>No conciliados</th>
                                    <th>Monto conciliado</th>
                                    <th>Monto no conciliado</th> 
                                    <th style="background-color: #E9E9E9">Trámites</th>
                                    <th style="background-color: #E9E9E9">Conciliados</th>
                                    <th style="background-color: #E9E9E9">No conciliados</th>
                                    <th style="background-color: #E9E9E9">Monto conciliado</th>
                                    <th style="background-color: #E9E9E9">Monto no conciliado</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                       
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>                                   
                            </tbody>
                        </table>                          
                    </div>      
                </div>            
                <div class="tab-pane" id="tab_1">
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
    }); 

    $("#busqueda").click(function(){

        var fecha = $("#fecha").val();
        console.log(fecha);

    });
</script>
@endsection
