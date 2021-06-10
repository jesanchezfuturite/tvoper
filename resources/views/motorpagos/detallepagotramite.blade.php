@extends('layout.app')
@section('content')
<h3 class="page-title">Motor de pagos <small>Consulta Pago de Trámites</small></h3>
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
            <a href="#">Consulta Pago de Trámites</a>
        </li>
    </ul>
</div>

<!--<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Importante: </strong>Esta configuración es posterior al alta de un trámite y banco.
</div>-->
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite visualizar en general todas la cuentas de pago pertenecientes a una entidad. También permite eliminar/programar un tiempo de vencimiento para esa configuración.
</div>
<div class="row">
  <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
    <div class="portlet box blue" id="addTable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Cuentas Banco
            </div>
            
        </div>
        <div class="portlet-body" id="optionchange">
        <div class="row">
            <div class="form-group"> 
              <label class="col-md-3 control-label">Selecciona la Entidad para Mostrar las Cuentas Banco</label>          
                <div class="col-md-5">
                        <select class="select2me form-control" id="optionEntidad" onchange="ChangeEntidadTramite()">
                            <option>------</option>                           
                    </select>
                </div>
           </div>
            <div class="form-group">
              <div class="col-md-4 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
          </div> 
          
          </div> 
        <div class="portlet-body" id="removeTable">

                  <table class='table table-hover' id='sample_2'>   
                    <thead>            
                      <tr>  
                        <th>Tipo Tramite</th>
                        <th>Banco</th>      
                        <th>Cuenta</th>
                        <th>Servicio / CIE / CLABE</th>
                        <th>Método de pago</th>  
                        <th>Monto Mínimo</th> 
                        <th>Monto Máximo</th>        
                        <th>&nbsp; </th>
                      </tr> 
                    </thead>
                    <tbody>
                      <tr> 
                        <td>
                          <span class='help-block'>No Found</span>
                        </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                        <td>&nbsp; </td>
                      </tr>
                    </tbody>
                  </table>
                
            
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="static" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
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
                                <div class="col-md-offset-3 col-md-6" id="AddbuttonUpdate">
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
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminarRegistro()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>

<!-- modal-dialog -->
<div id="static3" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Desactivar/Activar Registro?
                </p>
                 <input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="updateEstatus()">Confirmar</button>
        </div>
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
       FindEntidad();
        TableManaged.init();
        UIBlockUI.init();
    }); 
     function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url()->('entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#optionEntidad option").remove();
          $("#optionEntidad").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#optionEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
  function ChangeEntidadTramite()
  {
    var identidad_=$("#optionEntidad").val(); 
      if(identidad_=="limpia")
        {          
          addtableDetalle();
          TableManaged.init();
        }else{

          $("#sample_2 tbody tr").remove();
          $("#sample_2 tbody").append("<tr><th>Espere Cargando...</th></tr>");
          
        ActualizarTabla();       
      }
  }
  function addtableDetalle() {
    $("#removeTable").remove();
    $("#addTable").append("<div class='portlet-body' id='removeTable'><table class='table table-hover' id='sample_2'> <thead>  <tr> <th>Tipo Tramite</th><th>Banco</th> <th>Cuenta</th><th>Servicio / CIE / CLABE</th><th>Método de pago</th>   <th>Monto Mínimo</th> <th>Monto Máximo</th>  <th>&nbsp;&nbsp;&nbsp; </th> </tr> </thead> <tbody><tr><td><span class='help-block'>No Found</span></td><td>&nbsp; </td><td><span class='help-block'>&nbsp; </span></td><td>&nbsp; </td><td>&nbsp; </td><td>&nbsp; </td><td>&nbsp; </td><td>&nbsp; </td> </tr></tbody> </table></div>");
  }
    
function deletedPagoTramite(id_)
{    
    document.getElementById('idregistro').value=id_;
}
function eliminarRegistro()
{
  var id_=$("#idTramite").val();
    $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-delete') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  
       })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
            ActualizarTabla();
        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
          return false; 
}

function findPagoTramite(id_)
{

  document.getElementById('idTramite').value=id_;
    $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-find-where') }}",
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
    //console.log(fechaInicio);
    if(descripcion_.length==0){
        Command: toastr.warning("Descripción Obligatorio", "Notifications")
    } else if(fechaInicio.length==0){
        Command: toastr.warning("Fecha Inicio Obligatorio", "Notifications")
    }else if(fechaFin.length==0){
        Command: toastr.warning("Fecha Fin Obligatorio", "Notifications")
    }else{

     if(fechaFin!=="30/11/1"){
           
      if(fechaInicio=="30/11/1")
      {
            Command: toastr.warning("Cambiar Fecha Inicio!", "Notifications")
          }else{
            actualizaPagoTramite();
        }
      }else{
        
        if(fechaInicio!=="30/11/1")
        {
             if(fechaFin=="30/11/1")
            {
            Command: toastr.warning("Cambiar Fecha Fin!", "Notifications")
            }else{
            actualizaPagoTramite();
            }
        }else{
          actualizaPagoTramite();
        }
      }
    }

}
function actualizaPagoTramite()
{
   var id_=$("#idTramite").val();
    var descripcion_=$("#descripcion").val();
    var fechaInicio=$("#datetime1").val();
    var fechaFin=$("#datetime2").val();
  fechaInicio=fechaInicio.replace("/","-");
    fechaInicio=fechaInicio.replace("/","-");    
    fechaFin=fechaFin.replace("/","-");
    fechaFin=fechaFin.replace("/","-");
     if(fechaInicio=="30-11-1")
     {
      fechaInicio="00-00-0000";
     }
    if(fechaFin=="30-11-1")
    {
      fechaFin="00-00-0000";
    }
    $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-update') }}",
           data: {id:id_,descripcion:descripcion_,fecha_inicio:fechaInicio,fecha_fin:fechaFin,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
             ActualizarTabla();

        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
}
function ActualizarTabla()
{ 
    var identidad_=$("#optionEntidad").val();
      $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-find-all') }}",
           data: {Id_entidad:identidad_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);

            if(responseTipoServicio=="[]")
            {              
              addtableDetalle();
            }else{
               addtableDetalle();
              var Resp=$.parseJSON(responseTipoServicio);          
              var item="";
              var Servicio="";
             var Cuenta="";
              var item="";
              var item2="";
              var max=0;
              var min=0;
              var msgg="";
              var msggI="";
              var icon="";
              var label="";
              var estatus="";
            $("#sample_2 tbody tr").remove();
             $.each(Resp, function(i, item) {
              estatus=item.status;
              if(estatus==0){
                var msggI="Activa";
                var msgg="Inactiva";
                var icon="green";
                var label="danger";
              }else{                
                var msggI="Inactiva";
                var msgg="Activo";
                var icon="red";
                var label="success";
              }

                  max=item.monto_max;
                  min=item.monto_min;
                 $("#sample_2 tbody").append("<tr>"
                    +"<td>"+item.descripcion+"&nbsp;<span class='label label-sm label-"+label+"'>"+msgg+"</span></td>"
                    +"<td>"+item.banco+"</td>"
                    +"<td>"+item.cuenta+"</td>"
                    +"<td>"+item.servicio+"</td>"
                    +"<td>"+item.metodopago+"</td>"                    
                    +"<td>$"+min.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td>$"+max.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td width='150'><a class='btn btn-icon-only blue' href='#static' data-toggle='modal'  title='Agregar Cuenta' onclick=\"findPagoTramite(\'"+item.id+"\')\"><i class='fa fa-calendar'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static2' onclick=\"deletedPagoTramite(\'"+item.id+"\')\" title='Eliminar Cuenta'><i class='fa fa-minus'></i> </a><a class='btn btn-icon-only "+icon+"'data-toggle='modal' href='#static3'  onclick=\"ChangeStatus(\'"+item.id+"\')\" title='"+msggI+" Cuenta'><i class='fa fa-power-off'></i> </a></td>"
                    +"</tr>"
                   );
                });
             TableManaged.init(); 
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  }); 
}
/*/***pendiente*****/
function ChangeStatus(id_)
{
  document.getElementById("idupdate").value=id_;
       
}
function updateEstatus()
{
  var id_=$("#idupdate").val();
  $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-update-status') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
            //console.log(responseTipoServicio);
            if(response=="false")
            { 
              Command: toastr.warning("Fallo Al Activar/Desactivar", "Notifications")              
            }else{
              ActualizarTabla();
              if(response=="activo"){
              Command: toastr.success("Activado!", "Notifications")             
              }else{
              Command: toastr.success("Inactiva!","Notifications")
              }
              
            }

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
     });
}
function GuardarExcel()
{
  var identidad_=$("#optionEntidad").val();
  if(identidad_=="limpia"){
    Command: toastr.warning("Entidad No Seleccionada!", "Notifications")
  }else{
    document.getElementById("blockui_sample_3_1").click();
     $.ajax({
           method: "POST",            
           url: "{{ url()->('pagotramite-find-all') }}",
           data: {Id_entidad:identidad_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);
            if(responseTipoServicio=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();

            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var Entidad=$("#optionEntidad option:selected").text();        
               JSONToCSVConvertor(responseTipoServicio, Entidad, true);
               
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); }); 
  
  }
   
     
}
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
  var f = new Date();
  fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;    
    var CSV = '';    
    //CSV += ReportTitle + '\r\n\n';
    if (ShowLabel) {
        var row = ""; 
        for (var index in arrData[0]) { 
            row += index + ',';
        }
        row = row.slice(0, -1);
        CSV += row + '\r\n';
    } 
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }
        row.slice(0, row.length - 1); 
        CSV += row + '\r\n';
    }
    if (CSV == '') {        
        alert("Invalid data");
        return;
    }
    document.getElementById("blockui_sample_3_1_1").click();

    var fileName = fecha;
    fileName += ReportTitle.replace(/ /g,"_");
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    var link = document.createElement("a");    
    link.href = uri;
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
     Command: toastr.success("Success", "Notifications")
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script>
@endsection
