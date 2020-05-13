@extends('layout.app')


@section('content')
<h3 class="page-title">Control <small>Acceso</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Control</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Acceso</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Usuarios
            </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            <div class="form-group"> 
             <div class="col-md-6">           
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Nuevo Usario</button>
            </div>
            </div>
            <div class="form-group">
             <div class="col-md-6 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
            <span class="help-block">&nbsp; </span>
            
                <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Correo Electrónico
                    </th>                 
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                     <td><span class="help-block">No Found</span></td>
                            <td></td>                         
                            <td></td>                                 
                </tbody>
                </table>
          
            </div>
        </div>
</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Registro Usuarios</h4>
            </div>
            <div class="modal-body">
                    <input hidden="true" type="text"  id="idupdate">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nombre:</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Nombre Completo" id="name">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Correo Electrónico:</label>
                            <div class="col-md-8">
                                <input type="email" autocomplete="off" class="form-control" placeholder="Ingresa la Descripcion de la Partida" id="email">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contraseña</label>
                            <div class="col-md-8">
                                <input type="text" name="password"id="password" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                            </div>
                        </div>
                    </div>
                     <span class="help-block">&nbsp; </span>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirma Contraseña</label>
                            <div class="col-md-8">
                                <input type="text" name="confirmpassword" id="confirmpassword"autocomplete="new-password" class="form-control" placeholder="Confirma la Contraseña" value="" >
                            </div>
                        </div>
                    </div>
                     <span class="help-block">&nbsp; </span>
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="form-group">
                                <button type="submit" class="btn blue" onclick="saveUpdatePartida()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                
            </div>
        </div>
    </div>
</div>

<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaPartida()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {  
    document.getElementById('password').type='password';   
    document.getElementById('confirmpassword').type='password';   
    });

</script>
@endsection