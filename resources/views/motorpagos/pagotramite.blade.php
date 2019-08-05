@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Pago de Trámites</small></h3>
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
            <a href="#">Configuración Pago de Trámites</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Trámite
            </div>
            
        </div>
        <div class="portlet-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label >&nbsp;&nbsp;Selecciona el trámite para configurar</label>
                    
                        <select class="form-control">
                            <option>------</option>
                            <option>Acta de Nacimiento</option>
                            <option>Pago de Tenencia</option>
                            <option>Pago de Actas</option>
                        </select>
                </div>
                
                <button class="btn green">Agregar</button>
            </form>
        </div>
    </div>
</div>
<h3 class="page-title">Acta de Nacimiento: </h3>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Banco
            </div>
            
        </div>
        <div class="portlet-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>
                    
                        <select class="form-control">
                            <option>------</option>
                            <option>Bancomer</option>
                            <option>HSBC</option>
                            <option>Banamex</option>
                        </select>
                </div>
                
                <button class="btn green">Agregar</button>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Cuentas Bancomer
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-group">
                <label >&nbsp;&nbsp;Cuentas disponibles:</label>
                
                    <select class="form-control">
                        <option>------</option>
                        <option>9803096790 Tarjeta de Crédito Bancomer</option>
                        <option>9803096791 Tarjeta de Crédito Bancomer</option>
                        <option>9803096792 Tarjeta de Crédito Bancomer</option>
                    </select>
            </div>
            <button class="btn green">Agregar</button>
            <div class="table-scrollable">
                <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        Cuenta
                    </th>
                    <th>
                        Servicio / CIE / CLABE
                    </th>
                    <th>
                        Método de pago
                    </th>
                    <th>
                        Monto Mínimo
                    </th>
                    <th>
                        Monto Máximo
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                         9803096712345
                    </td>
                    <td>98030967123459803096712345
                    </td>
                    <td>Tarjeta de Crédito Bancomer Cuenta 12345</td>
                    <td>$ 1.00</td>
                    <td>$ 10,000.00</td>
                    <td>
                        <a class="btn btn-icon-only blue" href="#portlet-config" data-toggle="modal" data-original-title="" title="Agregar Cuenta">
                            <i class="fa fa-calendar"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                         9803096799999
                    </td>
                    <td>98030967123459803096799999
                    </td>
                    <td>Tarjeta de Crédito Bancomer Cuenta 99999</td>
                    <td>$ 1.00</td>
                    <td>$ 10,000.00</td>
                    <td>
                        <a class="btn btn-icon-only blue" href="#portlet-config" data-toggle="modal" data-original-title="" title="Agregar Cuenta">
                            <i class="fa fa-calendar"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>
                
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Cuentas Banorte
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-group">
                <label >&nbsp;&nbsp;Cuentas disponibles:</label>
                
                    <select class="form-control">
                        <option>------</option>
                        <option>9803096790 Tarjeta de Crédito Banorte</option>
                        <option>9803096791 Tarjeta de Crédito Banorte</option>
                        <option>9803096792 Tarjeta de Crédito Banorte</option>
                    </select>
            </div>
            <button class="btn green">Agregar</button>
            <div class="table-scrollable">
                <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        Cuenta
                    </th>
                    <th>
                        Servicio / CIE / CLABE
                    </th>
                    <th>
                        Método de pago
                    </th>
                    <th>
                        Monto Mínimo
                    </th>
                    <th>
                        Monto Máximo
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                         9803096712345
                    </td>
                    <td>98030967123459803096712345
                    </td>
                    <td>Tarjeta de Crédito Banorte Cuenta 12345</td>
                    <td>$ 1.00</td>
                    <td>$ 10,000.00</td>
                    <td>
                        <a class="btn btn-icon-only blue" href="#portlet-config" data-toggle="modal" data-original-title="" title="Agregar Cuenta">
                            <i class="fa fa-calendar"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                         9803096799999
                    </td>
                    <td>98030967123459803096799999
                    </td>
                    <td>Tarjeta de Crédito Banorte Cuenta 99999</td>
                    <td>$ 1.00</td>
                    <td>$ 10,000.00</td>
                    <td>
                        <a class="btn btn-icon-only blue" href="#portlet-config" data-toggle="modal" data-original-title="" title="Agregar Cuenta">
                            <i class="fa fa-calendar"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-minus"></i>
                        </a>
                        
                    </td>
                </tr>
                
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->

</div>
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Configuración específica</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripción</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha de Inicio</label>
                            <div class="col-md-4">
                                <input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="">
                                <span class="help-block">Selecciona una fecha </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha Fin</label>
                            <div class="col-md-4">
                                <input id="datetime2" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="">
                                <span class="help-block">Selecciona una fecha </span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn blue">Guardar</button>
                                    <button type="button" class="btn default">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
    }); 
</script>
@endsection
