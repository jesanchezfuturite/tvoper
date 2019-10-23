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
                <input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha">
                <span class="help-block">
                 </span>
                <button class="btn blue" onclick="guardar()" type="submit">
                    Agregar
                </button>
            </div>
        </div>
    </div>
</div>
<br /><br />
<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption" id="headerTabla">
              <div id="borraheader">  Resultados de conciliación &nbsp;
                
                <span class="label label-sm label-danger">Sin resultados </span>

            </div>
        </div>
            
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-hover" id="table">
                <thead>
                <tr>
                    <th>Banco</th>
                    <th colspan="4" align="center">Internet</th>
                    <th colspan="4" align="center">Medios de pagos</th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <th>Total de tramites</th>
                    <th>Procesado</th>
                    <th>No Procesado</th>
                    <th>Monto</th>
                    <th>Total de tramites</th>
                    <th>Procesado</th>
                    <th>No Procesado</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>                   
                
                <tr>
                <td>
                    <span class="help-block">No Found</span>
                </td>
                </tr>                 
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
       sortTable();
    }); 
</script>
@endsection
