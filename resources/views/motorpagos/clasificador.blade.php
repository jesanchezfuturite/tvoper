@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Clasificador</small></h3>
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
            <a href="#">Configuración Clasificador</a>
        </li>
    </ul>
</div>


<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Clasificador
            </div>
        </div>
        <div class="portlet-body" id="Removetable">           
            <div class="form-group">           
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Agregar</button>
            </div>
            
            
                <table class="table table-hover" id="sample_1">
                <thead>
                <tr>
                    <th>
                        Descripcíon
                    </th>
                    <th>
                        Entidad
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
    <!-- END SAMPLE TABLE PORTLET-->    

</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Registro Clasificador</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                         <input hidden="true" type="text"  id="idupdate">
                       
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripcion Clasificador</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Descripcion del Clasificador" id="descripcion">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Entidad</label>
                            <div class="col-md-8">
                                <select id="entidad" class="select2me form-control" >
                                  <option value="limpia">-------</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" data-dismiss="modal" class="btn blue" onclick="saveUpdateclasificador()">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaclasificador()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        clasificadorFindAll();
        EntidadFindAll();
       
        
    });    
    function limpiar()
    {
        document.getElementById('idupdate').value="";
        document.getElementById('iddeleted').value="";
        document.getElementById('descripcion').value="";
        $("#entidad").val("limpia").change();
    }
    function saveUpdateclasificador()
    {
        var Registro=$("#idupdate").val();
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        if(descripcion_.length==0)
        {
            Command: toastr.warning("Clasificador, Requerido!", "Notifications")
        }else if(identidad_=="limpia"){
            Command: toastr.warning("Entidad Sin Seleccionar, Requerido!", "Notifications")            
        }else{  
            if(Registro.length==0)
            {
                clasificadorInsert();
            }else{
                clasificadorActualiza();
            }
        }

    }
    function clasificadorInsert()
    {
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-insert') }}",
        data: {identidad:identidad_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            clasificadorFindAll();
            limpiar();
        }else{
            Command: toastr.warning("La partida ya Existe", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la partida", "Notifications")   });
    }
    function eliminaclasificador()
    {
        var iddeleted=$("#iddeleted").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-deleted') }}",
        data: {id:iddeleted,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            clasificadorFindAll();

        }else{
            Command: toastr.warning("Error al eliminar la partida!", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al eliminar la partida!", "Notifications")   });
    }

    function clasificadorUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
       
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-find-where') }}",
        data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);          
        $.each(Resp, function(i, item) { 
        document.getElementById('descripcion').value=item.descripcion;
         $("#entidad").val(item.entidad_id).change();
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });

    }
    function clasificadorActualiza()
    {
         var id_=$("#idupdate").val();
        var identidad_=$("#entidad").val();
        var descripcion_=$("#descripcion").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/clasificador-update') }}",
        data: {id:id_,identidad:identidad_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
            if(responseinfo=="true")
            {
                Command: toastr.success("Success", "Notifications")
                clasificadorFindAll();
                limpiar();
            }else{
                Command: toastr.warning("Error al Actualizar la partida", "Notifications") 
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar", "Notifications")   });
    }
    function clasificadorDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;
    }
    function clasificadorFindAll()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/clasificador-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'>  <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div><table class='table table-hover' id='sample_1'><thead><tr> <th> Clasificador</th><th>Entidad</th>   <th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
        $.each(Resp, function(i, item) {                
            $('#sample_1 tbody').append("<tr>"
                +"<td>"+item.descripcion+"</td>"
                +"<td>"+item.entidad+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='clasificadorUpdate("+item.id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='clasificadorDeleted("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableAdvanced.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function EntidadFindAll()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/entidad-find') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#entidad option").remove();
          $("#entidad").append("<option value='limpia'>-------</option>");
        $.each(Resp, function(i, item) {                
              $("#entidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>");
            
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
</script>
@endsection