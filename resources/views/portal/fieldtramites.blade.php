@extends('layout.app')

@section('content')
<h3 class="page-title"> Portal de trámites<small>Configuración de Campos</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal de trámites - Configuración de Campos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Listado</a>
        </li>
    </ul>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Lorem ipsum
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Consultar resultados conciliación</label>
            <div class="col-md-3">
                <input id="fecha" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha" required="true">
                <span class="help-block">
                 </span>
                <button class="btn blue" id="busqueda" type="submit">
                    Buscar
                </button>
                <div id="corte_div" style="display: inline"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

<script>
    


</script>
@endsection
