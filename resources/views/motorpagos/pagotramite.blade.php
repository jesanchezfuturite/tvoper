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

<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Importante: </strong>Esta configuración es posterior al alta de un trámite y banco.
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite asignar para una entidad y/o trámites en particular, la cuenta de pago donde deseas se realice el depósito. También permite activar o desactivar esta funcionalidad, además de programar un tiempo de vencimiento para esa configuración.
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Entidad
            </div>            
        </div>
        <div class="portlet-body">
        <div class="form-body">
           <div class="row">
              <div class="col-md-12 text-left"> 
                <span class="help-block">&nbsp;</span>
                  <span class="help-block">Selecciona una Opcion de Busqueda. </span>
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="portramites" onclick="radiobuttons()" checked>
                                    <label for="radio6">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>Tramites por Entidad.</label>
                                    
                                </div>|
                                <div class="md-radio">
                                    <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="soloentidad" onclick="radiobuttons()">
                                    <label for="radio7">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>Solo Entidad.</label>
                                </div>                                
                        </div>                                                                 
                    </div>                   
        </div> 
        <span class="help-block">&nbsp;</span>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label >Selecciona la Entidad para Mostrar los Tramites:</label> 
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
            <div id="showtramites">
              <div class="row">            
                <div class="col-md-3">
                  <div class="form-group">
                    <label >Selecciona el trámite para configurar:</label> 
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select  class="select2me form-control" id="itemsTipoServicio" onchange="ChangeTitleTipoServicio()">
                            <option value="limpia">------</option>                           
                    </select>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
</div>

<h2 class="page-title"><p id="tituloTramite">TRAMITE NO SELECCIONADA:</p> </h2>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Banco
            </div>
            
        </div>
        <div class="portlet-body">
         <div class="form-body">
            <div class="row"> 
                <div class="col-md-3 col-ms-12">
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>  
                </div> 
                </div>
                <div class="col-md-4 col-ms-12">        
                <div class="form-group">             
                        <select multiple class="form-control"name="itemsBancos" id="itemsBancos" >
                           <option value="limpia">------</option>                           
                        </select>            
                </div>
                </div>
                <div class="col-md-1 col-ms-12">
                  <div class="form-group">
                    <span class="help-block">&nbsp;</span>
                    <span class="help-block">&nbsp;</span>
                      <button type="button" class="btn green" onclick="existeID()">Agregar</button>
                  </div>
              </div>
             </div>

            </div>            
        </div>
    </div>
</div>

<div id="addTables">

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
         <div id="Addbutton">
            <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>         
            <button type="button" data-dismiss="modal" class="btn green" onclick="insertTramite()">Confirmar</button>
        </div>
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
    AddOptionBanco();
    FindEntidad();
  });
  function radiobuttons()
    {
        var option = document.querySelector('input[name = radio2]:checked').value;
        $("#optionEntidad").val("limpia").change();
        $("#itemsBancos").val("limpia").change();
         $("#addTables div").remove();        
        if(option=="soloentidad")
        {
           $("#showtramites").hide();
           $("#tituloTramite").text("ENTIDAD NO SELECCIONADA:");

        }else{
          
          $("#tituloTramite").text("TRAMITE NO SELECCIONADA:");
          $("#showtramites").show();
        }
  }
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
    var option = document.querySelector('input[name = radio2]:checked').value;
    $("#addTables div").remove();
    $("#itemsBancos").val("limpia").change();       
    if(option=="soloentidad")
      {
        ChangeTitleEntidad();
      }else{
          
        var entidad=$("#optionEntidad").val();
        $("#itemsTipoServicio option").remove();
        $("#itemsTipoServicio").append("<option value='limpia'>-------</option>");
        $("#tituloTramite").text("TRAMITE NO SELECCIONADA:");
        if(entidad=="limpia")
        {
          $("#itemsTipoServicio").val("limpia").change();
        }
        else{        
          AddOptionTipoServicio();
        }
      }

      
    }
    function AddOptionBanco() 
    {          
        $.ajax({
           method: "get",            
           url: "{{ url('/banco-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 
        $("#itemsBancos option").remove();
        var Resp=$.parseJSON(responseinfo);
         /*$('#itemsBancos').append(
                "<option value='limpia'>------</option>"
        );*/
          var item="";
        $.each(Resp, function(i, item) {                
                 $('#itemsBancos').append(
                "<option value='"+item.id+"'>"+item.nombre+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning(msg.message, "Notifications")  });
            return false;
    }
    
     function AddOptionTipoServicio() 
    { 
      var entidadId=$("#optionEntidad").val();
            $.ajax({
           method: "POST",            
           url: "{{ url('/entidad-find-all') }}",
           data: {id:entidadId,_token:'{{ csrf_token() }}'}  })
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
      $("#tituloTramite").text(title+":");
      $("#itemsBancos").val("limpia").change();
      $("#addTables div").remove();

    }
    function ChangeTitleEntidad()
    {
      var title;
      var titletramite=$("#optionEntidad option:selected").text();
      var tramite=$("#optionEntidad").val();
      if(tramite=="limpia"){
        title="ENTIDAD NO SELECCIONADA";
      }else{
        title=titletramite; 
      }
      $("#tituloTramite").text(title+":");
      $("#itemsBancos").val("limpia").change();
      $("#addTables div").remove();

    }
    function existeID()
    {
        
         var valueBanco=$("#itemsBancos").val();
        var valueServicio=$("#itemsTipoServicio").val();
        var valueEntidad=$("#optionEntidad").val();
         var option = document.querySelector('input[name = radio2]:checked').value; 
        if(valueBanco==null)
        {
          Command: toastr.warning("Bancos No Seleccionados!", "Notifications")
        }else if(option=="portramites")
        {
          if(valueServicio=="limpia")
          {
            Command: toastr.warning("Servicio No Seleccionado!", "Notifications")
          }else{
            valueBanco.forEach(function(element) { 
              var titlebanco=$("#itemsBancos option[value="+element+"]").text();
              if( $("#Add"+element+"").length > 0 ) 
              {                
            
              }
              else{
                FindTipoServicio(element,titlebanco,option);
              }
            }); 
          }
        }else{
          if(valueEntidad=="limpia")
          {
            Command: toastr.warning("Entidad No Seleccionado!", "Notifications")
          }else{
            valueBanco.forEach(function(element) { 
              var titlebanco=$("#itemsBancos option[value="+element+"]").text();
              if( $("#Add"+element+"").length > 0 ) 
              {                
            
              }
              else{
                FindTipoServicio(element,titlebanco,option);
              }
            }); 
          }    
        } 
    
    }
    function FindTipoServicio(id_,nombreBanco,option_)
    {
        var valueBanco= id_;//$("#itemsBancos").val();
        var titlebanco=nombreBanco;//$("#itemsBancos option:selected").text();       
        //var valueServicio=$("#itemsTipoServicio").val();
        if(option_=="portramites")
          {
            var TipoServ=$("#itemsTipoServicio").val();
          }else{
            var TipoServ=$("#optionEntidad").val();
        }          
        if(TipoServ=="limpia")
        {
            Command: toastr.warning("Tramite No Seleccionado", "Notifications")
             document.getElementById('itemsBancos').value="limpia";
        }else{
        if(valueBanco=="")
        {
            Command: toastr.warning("Banco No Seleccionado", "Notifications")
            
        }else
        {
          addTablaVacio(titlebanco,valueBanco);
          FindCuentasBancarias(valueBanco);           
        
          var IdBanc= valueBanco;
         $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-find') }}",
           data: {idBanco:IdBanc,idTiposervicio:TipoServ,option:option_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            var Resp=$.parseJSON(responseTipoServicio);          
          var item="";
          var Servicio="";
          var Cuenta="";
          var item="";
          var item2="";
          var max=0;
          var min=0;
          $("#table"+IdBanc+" tbody tr").remove();
        $.each(Resp, function(i, item) {
            var benef=$.parseJSON(item.beneficiario);
            $.each(benef, function(ii, item2) {
              Servicio=item2.servicio;
              Cuenta=item2.cuenta;
          });
              max=item.monto_max;
              min=item.monto_min;
              $("#table"+IdBanc+"").append("<tr>"
                    +"<td>"+Cuenta+"</td>"
                    +"<td>"+Servicio+"</td>"
                    +"<td>"+item.metodopago+"</td>"                     
                    +"<td>$"+min.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td>$"+max.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Agregar Cuenta' onclick=\"findPagoTramite(\'"+item.id+"\',\'"+titlebanco+"\',\'"+IdBanc+"\')\"><i class='fa fa-calendar'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static2' onclick=\"deletedPagoTramite(\'"+item.id+"\',\'"+titlebanco+"\',\'"+IdBanc+"\')\"><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning(msg, "Notifications")  });
        }
    }

}

function FindCuentasBancarias(banco_)
{    
      $.ajax({
           method: "POST",            
           url: "{{ url('/cuentasbanco-find') }}",
           data: {id:banco_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) { 

            var Resp=$.parseJSON(responseinfo); 
        $("#CuentasOption"+banco_+" option").remove();      
         $("#CuentasOption"+banco_+"").append(
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
                 $("#CuentasOption"+banco_+"").append(
                "<option value='"+item.id+"'>"+Cuenta+"  "+ item.metodopago+"</option>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
}

function findPagoTramite(id_,banco_,idbanco_)
{

    document.getElementById('idTramite').value=id_;
    var valueEntidad=$("#optionEntidad").val();
    var option_ = document.querySelector('input[name = radio2]:checked').value;

    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-find-where') }}",
           data: {id:id_,entidad:valueEntidad,option:option_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
        var Resp=$.parseJSON(responseinfo);         
        var item="";
        $("#AddbuttonUpdate button").remove();
        $("#AddbuttonUpdate").append("<button type='submit' data-dismiss='modal' class='btn blue' onclick=\"updatePagoTramite(\'"+banco_+"\',\'"+idbanco_+"\')\">Guardar</button>    <button type='button' data-dismiss='modal' class='btn default'>Cancelar</button>");
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
function updatePagoTramite(banco_,idbanco_)
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
            actualizaPagoTramite(idbanco_);
        }
      }else{
        
        if(fechaInicio!=="30/11/1")
        {
             if(fechaFin=="30/11/1")
            {
            Command: toastr.warning("Cambiar Fecha Fin!", "Notifications")
            }else{
            actualizaPagoTramite(idbanco_);
            }
        }else{
          actualizaPagoTramite(idbanco_);
        }
      }
    }

}
function actualizaPagoTramite(idbanco_)
{
   var id_=$("#idTramite").val();
    var descripcion_=$("#descripcion").val();
    var fechaInicio=$("#datetime1").val();
    var fechaFin=$("#datetime2").val();
  fechaInicio=fechaInicio.replace("/","-");
    fechaInicio=fechaInicio.replace("/","-");    
    fechaFin=fechaFin.replace("/","-");
    fechaFin=fechaFin.replace("/","-");
    var valueEntidad=$("#optionEntidad").val();
    var option_ = document.querySelector('input[name = radio2]:checked').value;
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
           data: {id:id_,descripcion:descripcion_,fecha_inicio:fechaInicio,fecha_fin:fechaFin,entidad:valueEntidad,option:option_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
             ActualizarTabla(idbanco_);

        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
            return false;
}
function deletedPagoTramite(id_,banco_,idbanco_)
{    
    document.getElementById('idregistro').value=id_;
    $("#AddbuttonDeleted button").remove();
    $("#AddbuttonDeleted").append(" <button type='button' data-dismiss='modal' class='btn default'>Cancelar</button>   <button type='button' data-dismiss='modal' class='btn green' onclick=\"eliminarRegistro(\'"+banco_+"\',\'"+idbanco_+"\')\">Confirmar</button>");
}
function eliminarRegistro(banco_,idbanco_)
{
    var id_=$("#idregistro").val();
     var valueEntidad=$("#optionEntidad").val();
    var option_ = document.querySelector('input[name = radio2]:checked').value;

    $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-delete') }}",
           data: {id:id_,entidad:valueEntidad,option:option_,_token:'{{ csrf_token() }}'}  
       })
        .done(function (responseinfo) {
            if(responseinfo=="true")
                {Command: toastr.success("Success", "Notifications")
            ActualizarTabla(idbanco_);
        }
            else{Command: toastr.warning("No Success", "Notifications")}
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
          return false; 
}

function addTablaVacio(banco,idbanco_)
{

    $("#addTables").append("<div id='Add"+idbanco_+"'><div class='row'>  <div class='portlet box blue'> <div class='portlet-title'> <div class='caption'>    <i class='fa fa-cogs'></i>Cuentas "+banco+"    </div> <div class='tools'> <a  onclick=\"removeTableAdd(\'"+idbanco_+"\')\" style='color:white;'>X</a> </div></div>  <div class='portlet-body'>   <div class='form-group col-md-6'>  <label >Cuentas disponibles:</label>    <select class='form-control' id='CuentasOption"+idbanco_+"'>  <option value='limpia'>------</option>  </select>   </div>  <div class='form-group col-md-2'>     <span class='help-block'>&nbsp;</span>   <button class='btn green' data-toggle='modal' href='#static' onclick=\"InsertPagoTramite("+idbanco_+")\" >Agregar</button>   </div>       <div class='table-scrollable'>  <table class='table table-hover' id='table"+idbanco_+"'>   <thead>            <tr>        <th> Cuenta </th> <th>Servicio / CIE / CLABE      </th>   <th>  Método de pago </th>  <th> Monto Mínimo </th> <th> Monto Máximo   </th>        <th>&nbsp; </th></tr></thead> <tbody><tr> <td><span class='help-block'>No Found</span></td> </tr></tbody></table></div></div></div></div>");
}
function InsertPagoTramite(id_)
{
    $("#Addbutton button").remove();
            $("#Addbutton").append("<button type='button' data-dismiss='modal' class='btn default'>Cancelar</button>          <button type='button' data-dismiss='modal' class='btn green' onclick=\"PagoTramite(\'"+id_+"\')\">Confirmar</button>");
          
}
function PagoTramite(id_)
{
    
     var idcuentaBanco=$("#CuentasOption"+id_+"").val(); 
     var entidad_=$("#optionEntidad").val();
     var option_ = document.querySelector('input[name = radio2]:checked').value;
     if(option_=="soloentidad")
      {
         var TipoServ=$("#optionEntidad").val();
      }else{
         var TipoServ=$("#itemsTipoServicio").val();
      }

     if(TipoServ=="limpia")
     {
        Command: toastr.warning("No Success, Entidad O Tramite Sin Seleccionar", "Notifications")
     }else if(idcuentaBanco=="limpia")
      {
        Command: toastr.warning("Cuenta Banco Sin Seleccionar, Requerido!", "Notifications")
     }else{      

         $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-insert') }}",
           data: {Id_Banco:idcuentaBanco,Id_tiposervicio:TipoServ,option:option_,entidad:entidad_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {           
          if(responseTipoServicio=="true")        
         {
            ActualizarTabla(id_);
         }
         else{
          Command: toastr.warning("Ya se Encuentra Agregada", "Notifications")
         }
       
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
}
function ActualizarTabla(idbanco_)
{
    var option_ = document.querySelector('input[name = radio2]:checked').value;
    if(option_=="soloentidad"){
      var TipoServ=$("#optionEntidad").val();
    }else{
      var TipoServ=$("#itemsTipoServicio").val();
    }
    
      $.ajax({
           method: "POST",            
           url: "{{ url('/pagotramite-find') }}",
           data: {idBanco:idbanco_,idTiposervicio:TipoServ,option:option_,_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);
            var Resp=$.parseJSON(responseTipoServicio);          
          var item="";
          var Servicio="";
          var Cuenta="";
          var item="";
          var item2="";
          var max=0;
          var min=0;
          $("#table"+idbanco_+" tbody tr").remove();
        $.each(Resp, function(i, item) {
                 var benef=$.parseJSON(item.beneficiario);
                  $.each(benef, function(ii, item2) {
                        Servicio=item2.servicio;
                        Cuenta=item2.cuenta;
                  });
                  max=item.monto_max;
                  min=item.monto_min;
                 $("#table"+idbanco_+" tbody").append("<tr>"
                    +"<td>"+Cuenta+"</td>"
                    +"<td>"+Servicio+"</td>"
                    +"<td>"+item.metodopago+"</td>"                    
                    +"<td>$"+min.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td>$"+max.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+"</td>"
                    +"<td><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Agregar Cuenta' onclick=\"findPagoTramite(\'"+item.id+"\',\'"+idbanco_+"\',\'"+idbanco_+"\')\"><i class='fa fa-calendar'></i> </a><a class='btn btn-icon-only red' data-toggle='modal' href='#static2' onclick=\"deletedPagoTramite(\'"+item.id+"\',\'"+idbanco_+"\',\'"+idbanco_+"\')\"><i class='fa fa-minus'></i> </a></td>"
                    +"</tr>"
                   );
                });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  }); 
}
function removeTableAdd(id_)
{
  $("#Add"+id_+"").remove();

}

</script>
@endsection
