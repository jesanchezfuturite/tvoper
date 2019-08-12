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
                        <select class="form-control" id="itemsTipoServicio" onchange="ChangeTitleTipoServicio()">
                            <option>------</option>                           
                        </select>
                </div>
                
                <button class="btn green">Agregar</button>
            </form>
        </div>
    </div>
</div>
<div id="tituloTamite">
<h3 class="page-title">TRAMITE NO SELECCIONADA: </h3>
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
                    <label class="sr-only" for="bancoNombre">Nuevo Banco</label>
                    <input type="text" class="form-control" id="bancoNombre"name="bancoNombre" placeholder="Nuevo Banco">
                </div>
                <div class="form-group">
                <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i>
                                <span>
                                Add Logo... </span>
                                <input type="file" name="file" id="file">
                                </span>
                </div>
                <button type="button" class="btn btn-default" onclick="guardarBanco()">Agregar</button>
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>             
                        <select class="form-control"name="itemsBancos" id="itemsBancos" onchange="FindTipoServicio()">
                           <option value="limpia">------</option>                           
                        </select>            
                </div> 
            </form>              
        </div>
    </div>
</div>
<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title" id="TitleBanco">
            <div class="caption" id="RemoveTitle">
                <i class="fa fa-cogs"></i>Cuentas Sin Seleccionar
            </div>
        </div>
        <div class="portlet-body">
           
            <div class="form-group col-md-6">
                          <label >Cuentas disponibles:</label>  
                    <select class="form-control" id="CuentasOption">
                        <option>------</option>
                    </select>  
            </div>
            <div class="form-group col-md-2">   
             <span class="help-block">&nbsp;</span>              
                <button class="btn green" data-toggle="modal" href="#static" >Agregar</button>
            </div>
            
            <div class="table-scrollable">
                <table class="table table-hover" id="table">
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
                    <td><span class="help-block">No Found</span></td>                   
                </tr>
                
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Configuración específica</h4>
            </div>
            <div class="modal-body">
                 <form action="#" class="form-horizontal">
                    <div class="form-body">
                         <input hidden="true" type="text"  id="idTramite">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descripción</label>
                            <div class="col-md-4">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa la Descripción" id="descripcion">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha de Inicio</label>
                            <div class="col-md-4">
                                <input id="datetime1" autocomplete="off" class="form-control form-control-inline input-medium date-picker" size="16" type="text" data-date-format="dd/mm/yyyy">
                                <span class="help-block">Selecciona una fecha </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha Fin</label>
                            <div class="col-md-4">
                                <input id="datetime2"  autocomplete="off"class="form-control form-control-inline input-medium date-picker" size="16" type="text" data-date-format="dd/mm/yyyy">
                                <span class="help-block">Selecciona una fecha </span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" data-dismiss="modal" class="btn blue" onclick="updatePagoTramite()">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Agregar Registro?
                </p>
                 <input hidden="true" type="text" name="idvalor" id="idvalor" class="idvalor">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="insertTramite()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal-dialog -->
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminarRegistro()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
       AddOptionBanco();
       AddOptionTipoServicio();
    }); 
    function AddOptionBanco() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/banco-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsBancos option").remove();
        var Resp=$.parseJSON(responseinfo);

         $('#itemsBancos').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsBancos').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function AddOptionTramite() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/tramite-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsBancos option").remove();
        var Resp=$.parseJSON(responseinfo);

         $('#itemsBancos').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsBancos').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
     function AddOptionTipoServicio() 
    {          
            $.ajax({
           method: "get",            
           url: "{{ url('/tiposervicio-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsTipoServicio option").remove();
        var Resp=$.parseJSON(responseinfo);

         $('#itemsTipoServicio').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsTipoServicio').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }
    function ChangeTitleTipoServicio()
    {
         var title;
         var titletramite=$("#itemsTipoServicio option:selected").text();
         var tramite=$("#itemsTipoServicio").val();
         if(tramite=="limpia"){
            title="TRAMITE NO SELECCIONADA";
             
         }else{
            title=titletramite;
         }
        $("#tituloTamite h3").remove();
       $("#tituloTamite").append("<h3 class='page-title'>"+title+": </h3>"); 
       document.getElementById('itemsBancos').value="limpia";
             $("#CuentasOption option").remove();      
            $('#CuentasOption').append(
                "<option value='limpia'>------</option>"
            );
            $("#table tbody tr").remove();
            $('#table').append("<tr>"
                +"<td><span class='help-block'>No Found</span></td>"
                +"<tr>"                   
            );

    }
    function guardarBanco() 
    {           
            var imagenV = $("#file")[0].files[0];  
            var fecha_=new Date();
            var fechaIn=fecha_.getFullYear() + "-" + (fecha_.getMonth() + 1) + "-" + fecha_.getDate() + " " + fecha_.getHours() + ":" + fecha_.getMinutes() + ":" + fecha_.getSeconds();  
            var nombre=$("#bancoNombre").val();         
             var formdata = new FormData();
             formdata.append("file", imagenV);
             formdata.append("nombre", nombre);
             formdata.append("fechaIn", fechaIn);
             formdata.append("estatus", '1');
             formdata.append("_token", '{{ csrf_token() }}');
            $.ajax({
           method: "POST",
            contentType: false,
            processData: false,
           url: "{{ url('/banco-insert') }}",
           data: formdata  })
        .done(function (responseinfo) { 
            $("#itemsBancos option").remove();
        var Resp=$.parseJSON(responseinfo);     
        Command: toastr.success("Success", "Notifications") 
        document.getElementById('bancoNombre').value="";
        document.getElementById('file').value="";
         $('#itemsBancos').append(
                "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
                 $('#itemsBancos').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
    }


    function FindTipoServicio()
    {
        var valueBanco=$("#itemsBancos").val();
        var titlebanco=$("#itemsBancos option:selected").text();
          var valueServicio=$("#itemsTipoServicio").val();
        if(valueServicio=="limpia")
        {
            Command: toastr.warning("Tramite No Selected", "Notifications")
            $("#CuentasOption option").remove();      
            $('#CuentasOption').append(
                "<option value='limpia'>------</option>"
            );
            document.getElementById('CuentasOption').value="limpia";
             document.getElementById('itemsBancos').value="limpia";
        }else{
        if(valueBanco=="limpia")
        {
            $("#RemoveTitle").remove();
            $("#TitleBanco").append("<div class='caption' id='RemoveTitle'><i class='fa fa-cogs'></i>Cuentas Sin Seleccionar</div>");
            $("#table tbody tr").remove();
            $('#table').append("<tr>"
                +"<td><span class='help-block'>No Found</span></td>"
                +"<tr>"                   
            );
            $("#CuentasOption option").remove();      
            $('#CuentasOption').append(
                "<option value='limpia'>------</option>"
            );
            document.getElementById('CuentasOption').value="limpia";
        }else
        {
            FindCuentasBancarias();
             $("#RemoveTitle").remove();
            $("#TitleBanco").append("<div class='caption' id='RemoveTitle'><i class='fa fa-cogs'></i>Cuentas "+titlebanco+"</div>");

        var TipoServ=$("#itemsTipoServicio").val();
        var IdBanc=$("#itemsBancos").val();
         $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-find') }}",
           data: {idBanco:IdBanc,idTiposervicio:TipoServ,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            var Resp=$.parseJSON(responseTipoServicio);          
          var item="";
          var Servicio="";
          var Cuenta="";
          var item="";
          var item2="";
          $("#table tbody tr").remove();
        $.each(Resp, function(i, item) {
                 var benef=$.parseJSON(item.beneficiario);
                  $.each(benef, function(ii, item2) {
                        Servicio=item2.servicio;
                        Cuenta=item2.cuenta;
                  });

                 $('#table').append("<tr>"
                    +"<td>"+Cuenta+"</td>"
                    +"<td>"+Servicio+"</td>"
                    +"<td>"+item.metodopago+"</td>"                    
                    +"<td>"+item.monto_min+"</td>"
                    +"<td>"+item.monto_max+"</td>"
                    +"<td><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Agregar Cuenta' onclick='findPagoTramite("+item.id+")'><i class='fa fa-calendar'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static2' onclick='deletedPagoTramite("+item.id+")'><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }

}

function FindCuentasBancarias()
{
    var valueBanco=$("#itemsBancos").val();
      $.ajax({
           method: "POST",            
           url: "{{ url('/cuentasbanco-find') }}",
           data: {id:valueBanco,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 

            var Resp=$.parseJSON(responseinfo); 
        $("#CuentasOption option").remove();      
         $('#CuentasOption').append(
                "<option value='limpia'>------</option>"
        );
          var item="";
          var item2="";
          var Cuenta="";
        $.each(Resp, function(i, item) {
            var beneficiario=$.parseJSON(item.beneficiario);
                $.each(beneficiario, function(ii, item2) {
                    Cuenta=item2.cuenta;
                });
                 $('#CuentasOption').append(
                "<option value='"+item.id+"'>"+Cuenta+"  "+ item.metodopago+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
}
function insertTramite()
{
     var Serv=$("#itemsTipoServicio").val();
     var CuentaB=$("#CuentasOption").val();
     var Banc=$("#itemsBancos").val();
     if(Serv=="limpia")
     {
        Command: toastr.warning("No Success, No Selected Tipo Tramite", "Notifications")
     }  else if(Banc=="limpia")
        {
        Command: toastr.warning("No Success, No Selected Banco", "Notifications")
     }  else if(CuentaB=="limpia")
        {
        Command: toastr.warning("No Success, No Selected Cuenta Banco", "Notifications")
     }
     else{
    var idTipoSer=$("#itemsTipoServicio").val();
    var idBanco=$("#CuentasOption").val();
    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-insert') }}",
           data: {Id_Banco:idBanco,Id_tiposervicio:idTipoSer,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
             FindTipoServicio();

        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
            return false;

}
function findPagoTramite(id_)
{

 document.getElementById('idTramite').value=id_;
    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-find-where') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
        var Resp=$.parseJSON(responseinfo);         
        var item="";
        $.each(Resp, function(i, item) {                
               document.getElementById('descripcion').value=item.descripcion;
            $("#datetime1").datepicker('setDate', item.fecha_inicio);
             $("#datetime2").datepicker('setDate', item.fecha_fin);

            });
         
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
}
function updatePagoTramite()
{
      var id_=$("#idTramite").val();
    var descripcion_=$("#descripcion").val();
    var fechaInicio=$("#datetime1").val();
    var fechaFin=$("#datetime2").val();
    if(descripcion_.length==0)
    {
        Command: toastr.warning("No Success, Descripción", "Notifications")
    } else if(fechaInicio.length==0)
        {
        Command: toastr.warning("No Success, Fecha Inicio", "Notifications")
    }else if(fechaFin.length==0)
        {
        Command: toastr.warning("No Success, Fecha Fin", "Notifications")
    }
    else{
    fechaInicio=fechaInicio.replace("/","-");
    fechaInicio=fechaInicio.replace("/","-");
    
    fechaFin=fechaFin.replace("/","-");
    fechaFin=fechaFin.replace("/","-");
    
    console.log(fechaInicio);
    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-update') }}",
           data: {id:id_,descripcion:descripcion_,fecha_inicio:fechaInicio,fecha_fin:fechaFin,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
             FindTipoServicio();

        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
        }

}
function deletedPagoTramite(id_)
{    
    document.getElementById('idregistro').value=id_;
}
function eliminarRegistro()
{
    var id_=$("#idregistro").val();
    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-delete') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  
       })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
             FindTipoServicio();
        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
          return false; 
}


</script>
@endsection
