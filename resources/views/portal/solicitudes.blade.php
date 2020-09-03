@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Bancos</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Bancos</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta configuración te permite la activación de un banco incluyendo el logo con el que ira a mostrarse en las fichas, asignar la cuenta o claves, método de pago y sus montos mínimo o máximo para pago. Esta misma es posible activar o desactivar en el momento que el usuario le solicite además de su edición.
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Solicitud
            </div>
        </div>
        <div class="portlet-body">
	        <div class="form-body">
		        <div class="row">
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">
		                    <label >Bancos Registrados (Selecciona para ver las cuentas)</label>   
		                  </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">           
		                        <select class="select2me form-control"name="items" id="items" onchange="CuentasBanco()">
		                           <option value="limpia">------</option>
		                        </select>            
		                </div>
		            </div>
		            <div class="col-md-2 col-ms-12">
		                <div class="form-group" id="addButton">
		                    
		                </div>
		            </div>
	            </div> 
            </div>
        </div>
    </div>
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs"></i>&nbsp;Cuentas &nbsp;<span class="label label-sm label-danger">
                    No Found </span>&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>
                <div class="caption">              
                <div class="md-checkbox has-info" >
                   <input type="checkbox" id="checkbox10" class="md-check" onclick="Check()" >
                   <label for='checkbox10' style="color:white !important;"><span></span>
                    <span class='check'style="border-color: white !important;"></span><span class='box'style="border-color: white !important;"></span>Conciliar
                    </label>
                </div> 
                </div>
                <div class="tools" id="removeBanco">                
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                   <a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Banco" onclick="desactivabanco()"><i class='fa fa-remove' style="color:white !important;"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <th>Cuenta</th>
                        <th>Servicio / CIE / CLABE</th>
                        <th>Leyenda</th>
                        <th>Alias</th>
                        <th>En Linea</th>
                        <th>Método de pago</th>
                        <th>Monto Mínimo</th>
                        <th>Monto Máximo</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>                   
                    <tr>
                     <td><span class="help-block">No Found</span></td>
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
	<script>

	</script>
@endsection
