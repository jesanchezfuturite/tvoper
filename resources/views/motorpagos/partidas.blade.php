@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Configuración Partidas</small></h3>
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
            <a href="#">Configuración Partidas</a>
        </li>
    </ul>
</div>


<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Partidas
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
                        Partida
                    </th>
                    <th>
                        Descripición Partida
                    </th>
                    <th>
                        Servicio
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
                <h4 class="modal-title">Registro Partidas</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                         <input hidden="true" type="text"  id="idupdate">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Partida</label>
                            <div class="col-md-8">
                                <input type="number" autocomplete="off" class="form-control" placeholder="Ingresa la Partida No." oninput="valida(this);"  id="idpartida">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripcion Partida</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Descripcion de la Partida" id="partidaDesc">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tipo Servicio</label>
                            <div class="col-md-8">
                                <select id="tiposervicio" class="select2me form-control" >
                                  <option value="limpia">-------</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" data-dismiss="modal" class="btn blue" onclick="saveUpdatePartida()">Guardar</button>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaPartida()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        partidasFindAll();
        ServiciosFindAll();
       
        
    });
    function valida(n) {
       var num = n.value;
        var vew;
       if (num.length>10) {
         vew= num.substring(0,num.length-1)    
           document.getElementById('idpartida').value=vew;
       } else {  
            
 
       }
    }
    function limpiar()
    {
        document.getElementById('idupdate').value="";
        document.getElementById('idpartida').value="";
        document.getElementById('iddeleted').value="";
        document.getElementById('partidaDesc').value="";
        $("#tiposervicio").val("limpia").change();
    }
    function saveUpdatePartida()
    {
        var Registro=$("#idupdate").val();
        var idpart=$("#idpartida").val();
        var idservicio_=$("#tiposervicio").val();
        var descripcion_=$("#partidaDesc").val();
        if(idpart.length==0)
        {
            Command: toastr.warning("Partida, Requerido!", "Notifications")
        }else if(descripcion_.length==0){
            Command: toastr.warning("Descripción Partida, Requerido!", "Notifications")
        }else if(idservicio_=="limpia"){
            Command: toastr.warning("Servicio Sin Seleccionar, Requerido!", "Notifications")            
        }else{  
            if(Registro.length==0)
            {
                partidaInsert();
            }else{
                partidaActualiza();
            }
        }

    }
    function partidaInsert()
    {
        var idpart=$("#idpartida").val();
        var idservicio_=$("#tiposervicio").val();
        var descripcion_=$("#partidaDesc").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/partidas-insert') }}",
        data: {idpartida:idpart,idservicio:idservicio_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            partidasFindAll();
            limpiar();
        }else{
            Command: toastr.warning("La partida ya Existe", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Insertar la partida", "Notifications")   });
    }
    function eliminaPartida()
    {
        var iddeleted=$("#iddeleted").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/partidas-deleted') }}",
        data: {idpartida:iddeleted,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        if(responseinfo=="true")
        {
            Command: toastr.success("Success", "Notifications")
            partidasFindAll();

        }else{
            Command: toastr.warning("Error al eliminar la partida!", "Notifications") 
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al eliminar la partida!", "Notifications")   });
    }

    function partidasUpdate(id_)
    {
        document.getElementById('idupdate').value=id_;
       
        $.ajax({
        method: "post",            
        url: "{{ url('/partidas-find-where') }}",
        data: {idpartida:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);          
        $.each(Resp, function(i, item) { 
        document.getElementById('idpartida').value=item.id_partida;
        document.getElementById('partidaDesc').value=item.descripcion;
         $("#tiposervicio").val(item.id_servicio).change();
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("Registro No Encontrado", "Notifications")  });

    }
    function partidaActualiza()
    {
         var idpart=$("#idupdate").val();
        var idservicio_=$("#tiposervicio").val();
        var descripcion_=$("#partidaDesc").val();
        $.ajax({
        method: "post",            
        url: "{{ url('/partidas-update') }}",
        data: {idpartida:idpart,idservicio:idservicio_,descripcion:descripcion_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
            if(responseinfo=="true")
            {
                Command: toastr.success("Success", "Notifications")
                partidasFindAll();
                limpiar();
            }else{
                Command: toastr.warning("Error al Actualizar la partida", "Notifications") 
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error al Actualizar", "Notifications")   });
    }
    function partidasDeleted(id_)
    {
        document.getElementById('iddeleted').value=id_;
    }
    function partidasFindAll()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/partidas-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <div class='form-group'>  <button class='btn green' href='#portlet-config' data-toggle='modal' >Agregar</button> </div><table class='table table-hover' id='sample_1'><thead><tr> <th> Partida</th><th>Descripición Partida </th><th>Servicio</th>   <th> &nbsp; </th> </tr> </thead> <tbody></tbody> </table> </div>"
        );
        $.each(Resp, function(i, item) {                
            $('#sample_1 tbody').append("<tr>"
                +"<td>"+item.id_partida+"</td>"
                +"<td>"+item.descripcion+"</td>"
                +"<td>"+item.servicio+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='portlet-config' onclick='partidasUpdate("+item.id_partida+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='partidasDeleted("+item.id_partida+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableAdvanced.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function ServiciosFindAll()
    {
        $.ajax({
        method: "get",            
        url: "{{ url('/tiposervicio-find-all') }}",
        data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#tiposervicio option").remove();
          $("#tiposervicio").append("<option value='limpia'>-------</option>");
        $.each(Resp, function(i, item) {                
              $("#tiposervicio").append("<option value='"+item.id+"'>"+item.nombre+"</option>");
            
        });
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
</script>
@endsection