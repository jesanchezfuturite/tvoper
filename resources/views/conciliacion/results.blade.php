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
<div class="row">
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
                    <div class="portlet box blue" id="addTable_1">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Operaciones
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>                                     
                            </div>
                        </div>
                        <div class="portlet-body" id="table_1"> 
                            <table class="table table-hover" id="sample_3">
                                <thead>
                                    <tr> 
                                        <th>Estatus</th>
                                        <th>Transacción</th>
                                        <th>Entidad</th>
                                        <th>Tramite</th>
                                        <th>Contribuyente</th> 
                                        <th>Inicio Tramite</th>                       
                                        <th>Banco</th>
                                        <th>Tipo Pago</th>
                                        <th>Total Tramite</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr>
                                        <td><span class="help-block">No Found</span></td>                       
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
                        <div class="form-actions">
                            <div class="row">
                            <span class="help-block">&nbsp;</span>              
                            </div>
                        </div>
                    </div>
                </div>            
                <div class="tab-pane" id="tab_1">
                    <div class="portlet box blue" id="addTable_2">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Egobierno
                            </div>
                            <div class="tools">                               
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                    <div class="portlet-body" id="table_2"> 
                        <table class="table table-hover" id="sample_2">
                            <thead>
                                <tr> 
                                    <th>Estatus</th>
                                    <th>Transacción</th>
                                    <th>Entidad</th>
                                    <th>Tramite</th>
                                    <th>Contribuyente</th> 
                                    <th>Inicio Tramite</th>                       
                                    <th>Banco</th>
                                    <th>Tipo Pago</th>                                            
                                    <th>Total Tamite</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td><span class="help-block">No Found</span></td>           
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
                    <div class="form-actions ">
                        <div class="row">
                            <span class="help-block">&nbsp;</span>              
                        </div>
                    </div>
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
       sortTable();
    }); 
</script>
@endsection
