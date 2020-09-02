@extends('layout.app')
@section('content')
<h3 class="page-title">Portal <small>Configuración de campos para trámites </small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración de campos para trámites</a>
        </li>
    </ul>
</div>

<div class="row">
     <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Indice Nacional de Precios al Consumidor
            </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            <div class="form-group"> 
                <div class="col-md-6">              
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
                </div>
            </div>
            <span class="help-block">&nbsp; </span>
            
            <table class="table table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estatus</th>                                      
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $data as $tramite)
                        <tr>                           
                            <td>                              
                                {{$tramite["campo"]}}                               
                            </td>
                            <td class="text-right">
                            <td class='text-center' width='20%'>
                                <a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='InpcUpdate( {{ json_encode($tramite) }} )'>
                                    <i class='fa fa-pencil'></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach                                                              
                </tbody>
            </table>
          
        </div>
    </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
                 
                <div class="form-body">
                    <input hidden="true" type="text"  id="idupdate">
                    <div class="row">
                        <div class="col-md-12">                        
                       <div class="form-group">
                            <label class="col-md-3 control-label ">Nombre</label>
                            <div class="col-md-8">
                                <input id="nombre" class="valida-num form-control" autocomplete="off" placeholder="Ingresar Nombre">
                            </div>
                        </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="form-group">
                                <button type="submit" class="btn blue" onclick="VerificaInsert()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                        
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal-dialog -->

<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    function limpiar()
    {
        document.getElementById('nombre').value="";
        document.getElementById('idupdate').value="";
    }

    function VerificaInsert()
    {
        var nombre=$("#nombre").val();
        var id_=$("#idupdate").val();
        if(nombre.length<1)
        {
            Command: toastr.warning("Campo Nombre, Requerido!", "Notifications")

        } else {
            id_.length == 0 ? alert("add") : alert("ipdat");
                //InpcInsert();
                //InpcActualizar();
        }

    }

    function InpcUpdate( tramite )
    {
        $("#nombre").val( tramite.campo );
        $('#idupdate').val( tramite.id_campo );
    } 
</script>
@endsection