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
                    <label class="sr-only" for="exampleInputEmail2">Nuevo Banco</label>
                    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Nuevo Banco">
                </div>
                <button class="btn btn-default">Agregar</button>
                
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>
                    
                        <select class="form-control">
                            <option>------</option>
                            <option>Bancomer</option>
                            <option>HSBC</option>
                            <option>Banamex</option>
                            <option>Aqui se agregan las opciones del campo anterior</option>
                        </select>
            
                </div>
                
                
            </form>
        </div>
    </div>
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Cuentas Bancomer &nbsp;<span class="label label-sm label-success">
                            Activa </span>
                </div>
                <div class="tools">
                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Agregar Cuenta">
                    </a>
                    </a>
                    <a href="javascript:;" class="remove" data-original-title="" title="Desactivar Banco">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
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
                            <span class="label label-sm label-success">
                            Activa </span>
                        </td>
                        <td>Tarjeta de Crédito Bancomer Cuenta 12345</td>
                        <td>
                            <a href="javascript:;" class="btn btn-icon-only red">
                                <i class="fa fa-power-off"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                             9803096712345
                        </td>
                        <td>98030967123459803096799999
                            <span class="label label-sm label-danger">
                            Inactiva </span>
                        </td>
                        <td>Tarjeta de Crédito Bancomer Cuenta 99999</td>
                        <td>
                            <a href="javascript:;" class="btn btn-icon-only green">
                                <i class="fa fa-power-off"></i>
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
                <h4 class="modal-title">Configurar Nueva Cuenta</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Método de Pago</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Cuenta</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Servicio / CIE / CLABE</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter text">
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

@endsection
