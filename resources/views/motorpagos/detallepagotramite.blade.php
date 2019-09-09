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
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Cuentas Banco
            </div>
            
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label >&nbsp;&nbsp;Selecciona la Entidad para Mostrar las Cuentas Banco</label> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                                       
                        <select class="select2me form-control" id="optionEntidad" onchange="ChangeEntidadTramite()">
                            <option>------</option>                           
                    </select>
                </div>
           </div>
          </div>  
                  <table class='table table-hover' id='table'>   
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

@endsection

@section('scripts')
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
       FindEntidad();
    }); 
     function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
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
          $("#table tbody tr").remove();
              $("#table tbody").append("<tr>"
                    +"<td><span class='help-block'>No Found</span></td>"                   
                    +"</tr>"
              );
        }else{
        ActualizarTabla();
      }
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
           url: "{{ url('/pagotramite-delete') }}",
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
           url: "{{ url('/pagotramite-update') }}",
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
           url: "{{ url('/pagotramite-find-all') }}",
           data: {Id_entidad:identidad_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);
            if(responseTipoServicio=="[]")
            {
              $("#table tbody tr").remove();
              $("#table tbody").append("<tr>"
                    +"<td><span class='help-block'>No Found</span></td>"                   
                    +"</tr>"
                   );
            }else{
              var Resp=$.parseJSON(responseTipoServicio);          
              var item="";
              var Servicio="";
             var Cuenta="";
              var item="";
              var item2="";
              var max=0;
              var min=0;
             $("#table tbody tr").remove();
             $.each(Resp, function(i, item) {
                 var benef=$.parseJSON(item.beneficiario);
                  $.each(benef, function(ii, item2) {
                        Servicio=item2.servicio;
                        Cuenta=item2.cuenta;
                  });
                  max=item.monto_max;
                  min=item.monto_min;
                 $("#table tbody").append("<tr>"
                    +"<td>"+item.servicio+"</td>"
                    +"<td>"+item.banco+"</td>"
                    +"<td>"+Cuenta+"</td>"
                    +"<td>"+Servicio+"</td>"
                    +"<td>"+item.metodopago+"</td>"                    
                    +"<td>$"+min.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td>$"+max.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td><a class='btn btn-icon-only blue' href='#static' data-toggle='modal'  title='Agregar Cuenta' onclick=\"findPagoTramite(\'"+item.id+"\')\"><i class='fa fa-calendar'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static2' onclick=\"deletedPagoTramite(\'"+item.id+"\')\"><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>"
                   );
                });
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  }); 
}


</script>
@endsection