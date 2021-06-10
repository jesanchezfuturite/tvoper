@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Cambiar transacción de estatus</small></h3>
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
            <a href="#">Cambiar transacción de estatus</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta consulta te permite buscar y cambiar el estatus de una transacción.
</div>
<div class="row">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue"id="table_1">
            <div class="portlet-title" >
                <div class="caption" id="headerTabla">
                  <div id="borraheader"> <a class=" popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="Esta consulta te permite buscar y cambiar el estatus de una transacciónDismissable " data-original-title="Tip"> <i class="fa fa-cogs" style="color:white;">&nbsp; </i></a>Tipos Tramite</div>
                  </div>
                  <div class="tools" hidden="true">
              </div>             
            </div>
            <div class="portlet-body" id="table_2">
               <div class="row"> 
                <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" id="folio"name="folio" autocomplete="off"placeholder="Buscar Por Folio/Referencia...">
                </div>
                </div>
                <div class="col-md-1">
                <div class="form-group">
                    <button class="btn green" id="Buscar" onclick="findTransaccionesWhere()">Buscar</button>
                </div>
                </div>
               </div>
                 
                <span class="help-block">&nbsp;</span>
                <div class="table-scrollable" id="RemoveTable">
                    <table class="table table-hover" id="sample_2">
                    <thead>
                    <tr> 
                        <th>Referencia</th>
                        <th>Estatus</th>                        
                        <th>Importe</th>
                        <th>Fecha Transaccion</th>
                        <th>&nbsp;Operacion&nbsp; </th>
                    </tr>
                    </thead>
                    <tbody>                   
                    
                        <tr>
                            <td><span class="help-block">No Found</span></td>
                            <td></td>                         
                            <td></td>
                            <td></td>
                             <td></td>
                        </tr>
                                   
                    </tbody>
                    </table>
               </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
</div><div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h3 class="form-section">Configuración Estatus</h3>
            </div>
            <div class="modal-body">
              <div class="tabbable-line boxless tabbable-reversed">
                        <!--<form class="horizontal-form">-->
                     <input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">
                     <input hidden="true" type="text" name="MetodoBusqueda" id="MetodoBusqueda" class="MetodoBusqueda">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Estatus</label>
                                                <select id="idestatus" class="select2me form-control">
                                                    <option value="limpia">-------</option>
                                                 </select>
                                                <span class="help-block">
                                                  Seleccione una Opcion </span>
                                                 <span class="help-block">&nbsp;</span>
                                            </div>
                                     </div>
                                </div>                                             
                            </div>
                                                <!--/row-->                                           
                         <div class="form-actions left">
                                                <!--<button type="button" class="btn default">Cancel</button>-->
                            <button type="submit" class="btn blue" data-dismiss="modal" onclick="updatetrasaccion()"><i class="fa fa-check"></i> Guardar</button>
                         </div>
                                        <!--</form>-->
                     </div>
                </div>
                <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        //TableManaged.init(); 
        findEstatus();
        
    });
    function limpiar()
    {
    $("#idestatus").val("limpia").change();
    }
    function findEstatus()
    {
        $.ajax({
           method: "get",           
           url: "{{ url()->('status-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#idestatus option").remove();
         $('#idestatus').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#idestatus').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                );
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    }
    $("#folio").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#Buscar").click();
    }
    });
     function findTransaccionesWhere()
    {
        var numero=$("#folio").val();
       if(numero.length<=2){
            document.getElementById("MetodoBusqueda").value="";
            $("#RemoveTable table").remove();
             $("#RemoveTable").append(" <table class='table table-hover' id='sample_2'> <thead> <tr>   <th>Referencia</th>   <th>Estatus</th><th>Importe</th><th>Fecha Transaccion</th> <th>&nbsp;Operacion&nbsp; </th></tr> </thead> <tbody>  <tr> <td><span class='help-block'>No Found</span></td> <td></td> <td></td> <td></td> <td></td> </tr> </tbody> </table>");
        }else{

            document.getElementById("MetodoBusqueda").value="";
            findOper_Transacciones();
        }
    }
    function findOper_Transacciones()
    {
        var numero=$("#folio").val();
        $("#RemoveTable table").remove();
        $("#RemoveTable").append(" <table class='table table-hover' id='sample_2'> <thead> <tr>   <th>Referencia</th>   <th>Estatus</th><th>Importe</th><th>Fecha Transaccion</th> <th>&nbsp;Operacion&nbsp; </th></tr> </thead> <tbody>  <tr> <td><span class='help-block'>No Found</span></td> <td></td> <td></td> <td></td> <td></td> </tr> </tbody> </table>");
        $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-find-referencia') }}",
           data: {folio:numero,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
           
          var Resp=$.parseJSON(response);
           $("#sample_2 tbody tr").remove();
         if(response=='[]')
         {
             Command: toastr.warning("No se encontro el Registro", "Notifications")
            $('#sample_2 tbody').append("<tr>"
                +"<td><span class='help-block'>No Found</span></td>"                
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
               + "</tr>"
                );
        }else{
            var impor=0;
             $.each(Resp, function(i, item) { 
             impor= item.importe;              
                $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.referencia+"</td>"                
                +"<td>"+item.status+"</td>"
                +"<td>$"+impor.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                +"<td>"+item.fecha+"</td>"
                +"<td><a class='btn btn-icon-only blue' href='#static2' data-toggle='modal' data-original-title='' title='static2' onclick=\"updateTransaccion("+item.id+",\'"+item.bd_tb+"\')\"><i class='fa fa-pencil'></i></a></td>"
                + "</tr>"
                    );
                });
            }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    }
   /* function findEgob_Transacciones()
    {
         var numero=$("#folio").val();
        $("#RemoveTable table").remove();
        $("#RemoveTable").append(" <table class='table table-hover' id='sample_2'> <thead> <tr>   <th>Transaccion</th>   <th>Nombre de Envio</th><th>Estatus</th><th>Importe</th> <th>Fecha Transaccion</th><th>&nbsp;Operacion&nbsp; </th></tr> </thead> <tbody>  <tr> <td><span class='help-block'>No Found</span></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr> </tbody> </table>");
        $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-find-referencia') }}",
           data: {folio:numero,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#sample_2 tbody tr").remove();
         if(response=='[]')
         {
             Command: toastr.warning("No se encontro el Registro", "Notifications")
            $('#sample_2 tbody').append("<tr>"
                +"<td><span class='help-block'>No Found</span></td>"                
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
                +"<td></td>"
               + "</tr>"
                );
        }else{
             $.each(Resp, function(i, item) {                
                $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.id+"</td>"                
                +"<td>"+item.envio+"</td>"
                +"<td>"+item.status+"</td>"
                +"<td>"+item.pais+"</td>"
                +"<td>"+item.fecha+"</td>"
                +"<td><a class='btn btn-icon-only blue' href='#static2' data-toggle='modal' data-original-title='' title='static2' onclick='updateTransaccion("+item.id+")'><i class='fa fa-pencil'></i></a></td>"
                + "</tr>"
                    );
                });
            }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    }*/
    function updateTransaccion(id_,bd_tb)
    {   
        document.getElementById("MetodoBusqueda").value=bd_tb;
        //var busca= $("#MetodoBusqueda").val(); 
        document.getElementById('idupdate').value=id_;
       
       if(bd_tb=="egob_transaccion"){
       
        $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-find-status') }}",
           data: {folio:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {           
          var Resp=$.parseJSON(response);        
            $.each(Resp, function(i, item) { 
                $("#idestatus").val(item.status).change();
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
        }else{
             $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-find-status-oper') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);        
            $.each(Resp, function(i, item) { 
                $("#idestatus").val(item.status).change();
            });
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
        }

    }
    function updatetrasaccion()
    {

        var id_=$("#idupdate").val();
        var status_=$("#idestatus").val();
         var busca= $("#MetodoBusqueda").val(); 
        if(status_=="limpia")
        {
             Command: toastr.warning("Estatus No Seleccionado", "Notifications")
        }
        else if(busca=="egob_transaccion"){
        $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-update-status') }}",
           data: {folio:id_,status:status_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response=="true"){
          findTransaccionesWhere();
          Command: toastr.success("Success", "Notifications")
           }else{
             Command: toastr.warning("No Success", "Notifications")
           }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
        }else{
            $.ajax({
           method: "POST",           
           url: "{{ url()->('transaccion-update-status-oper') }}",
           data: {folio:id_,status:status_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            if(response=="true"){
          findTransaccionesWhere();
          Command: toastr.success("Success", "Notifications")
           }else{
             Command: toastr.warning("No Success", "Notifications")
           }
        })
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
        }

    }


</script>
@endsection
