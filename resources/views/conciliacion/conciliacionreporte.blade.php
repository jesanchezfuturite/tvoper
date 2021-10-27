@extends('layout.app')

@section('content')
<h3 class="page-title">Operación -  Conciliación <small> Conciliacion Reporte</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a >Operación - Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a >Conciliacion Reporte</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Consultar resultados conciliación</label>
            <div class="col-md-3">
                <input id="fecha" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" data-date-format='mm/dd/yyyy'placeholder="Selecciona una fecha" required="true">
                <span class="help-block">
                 </span>
                <button class="btn blue" id="busqueda" type="submit">
                    Buscar
                </button>
                <div id="corte_div" style="display: inline"></div>
            </div>
        </div>
    </div>
</div><div class="alert alert-secondary" id="imageloading" style="display: none" role="alert"></div>
<div id="bancos_tabs" class="row" >
   
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection

@section('scripts')

<script>
    jQuery(document).ready(function() {   
   
    }); 



</script>
@endsection
