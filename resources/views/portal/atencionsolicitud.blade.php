@extends('layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
<link href="{{ asset('assets/global/dataTable/dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Portal <small>Atencion Solicitudes</small></h3>
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
            <a href="#">Atencion Solicitudes</a>
        </li>
    </ul>
</div>
<div class="row">
  <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
          <i class="fa fa-bank"></i>Filtros
      </div>
    </div>
    <div class="portlet-body">
      <div class="form-body">
        
        <div class="filtros-funcionarios">
          <div class="row">             
            <div class="col-md-4 col-ms-12">
              <div class="form-group">
                <label >Tipo de Solicitud</label>           
                <select class="select2me form-control" name="opTipoSolicitud" id="opTipoSolicitud" onchange="">
                   <option value="0">------</option>
                    @foreach($tipo_solicitud as $tr)
                      <option value="{{$tr['id']}}">{{$tr["titulo"]}}</option>
                    @endforeach     
                </select>   
              </div>
            </div>
            @if($atencion=="false")
            <div class="col-md-3 col-ms-12">
              <div class="form-group"> 
                <label >Estatus</label>          
                <select class="select2me form-control" name="opEstatus" id="opEstatus" onchange="">         
                   <option value="">------</option>
                   <option value="0">Todos menos cerrado</option>
                   @foreach( $status as $sd)
                             <option value="{{$sd['id']}}">{{$sd["descripcion"]}}</option>
                            @endforeach     
                </select>  
              </div>
            </div>
            
             @else  
            <div class="col-md-3 col-ms-12">
              <div class="form-group"> 
                <label >Usuario</label> 
                <select class="select2me form-control" name="opUser" id="opUser" onchange="">         
                   <option value="0">------</option>
                    @foreach( $usuarios_atencion as $us)
                    <option value="{{$us['id_usuario']}}">{{$us["name"]}} - {{$us["email"]}}</option>     
                    @endforeach  
                </select>    
              </div>
            </div>
            @endif 
            <div class="col-md-2 col-ms-12">
              <div class="form-group"> 
                <label >FSE/Folio Pago</label>          
                <input type="text" class="form-control" name="noSolicitud" id="noSolicitud" placeholder="Numero de Solicitud..." autocomplete="off">  
              </div>
            </div>
            <div class="col-md-1 col-ms-12">
              <div class="form-group">
                  <span class="help-block">&nbsp;</span>
                  <button type="button" class="btn green" onclick="findSolicitudes()">Buscar</button>
              </div>
            </div>
                         
          </div> 
        </div>        
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            
            <div class="caption" id="headerTabla">
                <div id="borraheader"> 
                  <i class="fa fa-cogs"></i>&nbsp;Solicitudes &nbsp;
              </div>
            </div>
            <div class="tools" id="toolsSolicitudes">                
                <a href="#" data-toggle="modal" class="config" data-original-title="" title="">
                </a>
            </div>
        </div>
         <div class="portlet-body" id="addtables">
        <div class="table-responsive">
              <table class="table table-hover" cellspacing="0" width="100%"  id="example">
              <thead>
                <tr>
                    <th></th>
                    <th>Grupo</th>
                    <th>Total</th>
                    <th>Solicitudes</th>
                    <th>grupo</th>
                    <th></th>
                </tr>
            </thead>
            </table>  
          </div>             
      </div>
    </div>
</div>
<!----------------------------------------- Informacion de la Solicitud-------------------------------------------->
<div class="modal fade" id="portlet-atender" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content" >
      <div class="modal-header">
       
        <div class="row"><div class=" col-md-9"><h4 class="modal-title">Información de la Solicitud <label id="idmodal">1</label> </h4></div>
          <div class="col-md-3 group-btn1" style="text-align: right; ">
            <!--<button type="button"  data-dismiss="modal" class="btn green right btn_cerrar_1" id="btn_cerrar_1"  onclick="cerrarTicket()">Cerrar Ticket</button>-->
          </div>
        </div>        
      </div>
      <div class="modal-body" id="scrollDiv" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
        <div class="content-detalle">
        <div class="row divDetalles">
          <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4><strong>Datos generales</strong></h4>
                </div>
                <div class="panel-body" id="detalles">
                   <div id="addDetalles">
                    </div>
                </div>
              </div>           
          </div>    
        </div>
        <div class="row divSolicitante">
          <div class="col-md-12" >            
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h4><strong>Datos del solicitante</strong></h4>
                </div>
                <div class="panel-body"id="solicitante">
                   <div id="addSolicitante">
                    </div>
                </div>
              </div>
          </div>    
        </div>
        <div class="row divNotaria">
          <div class="col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4><strong>Datos de la Notaria</strong></h4> 
                </div>
                <div class="panel-body"id="notaria">
                  <div id="addnotaria">
                  </div>
                </div>
              </div>
            
          </div>    
        </div>
        <div class="content-mensajes">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4><strong>Nuevo Mensaje</strong></h4> 
                </div>
                <div class="panel-body"id="notaria">
                  <div class="col-md-12">
                    <div class="col-md-9">             
                      <div class="form-group">
                        <label>Mensaje</label>
                        <textarea class="form-control" rows="4" placeholder="Escribe..." id="message"></textarea>
                        <span class="help-block">&nbsp;</span>
                        <div class="form-group form-md-checkboxes">
                          <div class="md-checkbox-inline">
                            <div class='md-checkbox'>
                              <input type='checkbox' id='checkbox30' name="checkbox30" class='md-check'>
                                <label for='checkbox30'>
                                <span></span>
                                <span class='check'></span> <span class='box'>
                                </span>  Mensaje Publico. </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">             
                      <div class="form-group">
                        <span class="help-block">&nbsp;</span>                
                        <button type="button" class="btn blue" onclick="saveMessage(0,{})" id="btn_guardar"><i class="fa fa-check"></i> Guardar</button>
                        <span class="help-block">&nbsp;</span>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn green btn-file">
                                <span class="fileinput-new">
                                <i class="fa fa-plus"></i>&nbsp; &nbsp;Adjuntar Archivo </span>
                                <span class="fileinput-exists">
                                <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Archivo </span>
                                <input type="file" name="file" accept="application/pdf" id="file" >
                                </span>
                                <div class="col-md-12"><span class="fileinput-filename" style="display:block;text-overflow: ellipsis;width: 140px;overflow: hidden; white-space: nowrap;">
                                </span>&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"style="position: absolute;left: 155px;top: 4px" id="delFile">
                                </a></div>
                                
                        </div>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">                
                  <h4><strong>Mensajes registrados</strong></h4>
                </div>
                <div class="panel-body"> 
                  <div class="col-md-12">
                  <div id="addtableMsg">
                    <div class="removeMsg"> 
                      <table class="table table-hover" id="sample_7">
                       <thead>
                        <tr>
                          <th></th>
                          <th>Titulo</th>
                          <th></th>
                        </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-8" style="text-align: left;">
            <div class="form-group">
               <button type="button" data-dismiss="modal" class="btn red">Salir</button>
            </div>
          </div>
          <div class="col-md-1 ">
            <div class="form-group ">
              <button type="button"  class="btn default btnPrelacion ">Prelación</button>
            </div>
          </div>
        </div>
      </div>   
    </div>
  </div>
</div>
<div id="portlet-asignar" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cerrarModal()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿<label id="lbl_habilitar" style="color: #cb5a5e;"></label> Asignar grupo de solicitudes, con id grupo: <label id="lbl_idgrupo" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" onclick="cerrarModal()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="Asignar()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<div id="portlet-cerrarTickets" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿Rechazar Solicitudes: <label id="lbl_tickets" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="cerrarSolicitudes()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<div id="portlet-aceptarTickets" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿Aceptar Solicitudes: <label id="lbl_a_tickets" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="cerrarSolicitudes()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="text" name="id_registro" id="id_registro" hidden="true">
<input type="text" name="configP" id="configP" hidden="true">
<input type="text" name="folioPago" id="folioPago" hidden="true">
<input type="text" name="idgrupo" id="idgrupo" hidden="true">
<input type="text" name="m_grupo_clave" id="m_grupo_clave" hidden="true">
<input type="text" name="obj_grupo" id="obj_grupo" hidden="true">
<input type="text" name="grp_clave" id="grp_clave" hidden="true">
<input type="text" name="jsonStatus" id="jsonStatus"hidden="true" value="{{json_encode($status,true)}}">
<input type="text" name="tickets_id" id="tickets_id" hidden="true">
<input type="text" name="ids" id="ids" hidden="true">
<input type="text" name="ids_abiertos" id="ids_abiertos" hidden="true">
<input type="text" name="data" id="data" hidden="true">
<input type="text" name="id_proceso" id="id_proceso" hidden="true">
<input type="text" name="ticket_status" id="ticket_status" hidden="true">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{ asset('assets/global/dataTable/dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/global/dataTable/jszip.min.js')}}"></script>
  <script src="{{ asset('assets/global/dataTable/vfs_fonts.js')}}"></script>
  <script>
  jQuery(document).ready(function() {
   // TableManaged2.init2();
    $(".btnPrelacion").css("display", "none");
    $(".selectMotivos").css("display", "none");
    configprelacion();
  }); 
  $("#noSolicitud").keypress(function(event) {
    if (event.keyCode === 13) {
       findSolicitudes();
    }
  });
  //console.log("{{$atencion}}");
function configprelacion()
{
  $.ajax({
      method: "get",            
      url: "{{ url()->route('configprelacion') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
      //console.log(response);   
        document.getElementById("configP").value=response;
        })
      .fail(function( msg ) {
        Command: toastr.warning("Error Config", "Notifications") 
      })
  }
  function changeMotivos()
  {
    if($("#checkbox1").prop("checked") == true){
      $(".selectMotivos").css("display", "block");
      //document.getElementById("message").disabled = true;     
    }else{
      $(".selectMotivos").css("display", "none");
      //document.getElementById("message").disabled = false;
    } 
    document.getElementById("message").value = "";
    $("#itemsMotivos").val("0").change();
  }
  function changeSelectMot()
  {
    var select=$("#itemsMotivos").val();
    var mot=$("#itemsMotivos option:selected").text();
    //console.log(select);
    if(select=='0')
    {
      $("#checkbox30").prop("checked", false);
    }else{
      $("#checkbox30").prop("checked", true);
    }
  }
  function AsignarGrupo(id,grupo,val)
  { 
    var labl=document.getElementById("lbl_habilitar");    
    document.getElementById("lbl_idgrupo").textContent=grupo;
    if(val==1)
    {
      $('#portlet-asignar').modal('show');
    }
    document.getElementById("id_registro").value=id;
  }
  function Asignar()
  {
    var id_=$("#id_registro").val();
    
  }
  async function registroPublico()
  {
    var resp;
      
      await sleep(1000);
      return resp;
  }
  function findSol()
  {
    $.ajax({
      method: "get",            
      url: "{{ url()->route('find-solicitudes') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {     
        //console.log(response);
        var resp=response;
        $("#opTipoSolicitud option").remove();
        $('#opTipoSolicitud').append("<option value='0'>------</option>");
          $.each(resp, function(i, item) {
            $('#opTipoSolicitud').append("<option value='"+item.id+"'>"+item.titulo+"</option>");
          
          });
        })
      .fail(function( msg ) {
         Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function findMotivosSelect(catalogo_id)
  {
      $.ajax({
          method: "get",            
          url: "{{ url()->route('get-solicitudes-motivos', '') }}",
          data: {solicitud_catalogo_id:catalogo_id,_token:'{{ csrf_token() }}'}  })
          .done(function (response) {   
          //console.log(response);  
            $("#itemsMotivos option").remove();
            $("#itemsMotivos").append("<option value='0'>-------</option>");
            $.each($.parseJSON(response), function(i, item) {                
              $("#itemsMotivos").append("<option value='"+item.motivo_id+"'>"+item.motivo+"</option>");
            });
          })
      .fail(function( msg ) {
      Command: toastr.warning("Error al Cargar Select Rol", "Notifications")   });
  }
  function findSolicitudes(){
    var noSolicitud=$("#noSolicitud").val();
    var opTipoSolicitud=$("#opTipoSolicitud").val();
    var opEstatus=$("#opEstatus").val();
    var opUser=$("#opUser").val();
    var formdata={            };

    if({{$atencion}}){
       if(noSolicitud.length>0){
         Object.assign(formdata,{id_solicitud:noSolicitud});  
      }else{        
        Object.assign(formdata,{tipo_solicitud:opTipoSolicitud}); 
        Object.assign(formdata,{user_id:opUser});
      } 
    }else{
      if(noSolicitud.length>0){
         Object.assign(formdata,{id_solicitud:noSolicitud});  
      }else if(opTipoSolicitud !="0" && opEstatus !=""){
        Object.assign(formdata,{tipo_solicitud:opTipoSolicitud}); 
        Object.assign(formdata,{estatus:opEstatus});    
      }else if(opTipoSolicitud != "0"){ 
        Object.assign(formdata,{tipo_solicitud:opTipoSolicitud});  
      }else if( opEstatus != ""){   
        Object.assign(formdata,{estatus:opEstatus}); 
      }else{
        Command: toastr.warning("campo Tipo Solitud / Estatus / Numero de Solitud, requerido!", "Notifications");
        return;
      }
    }
    
    Object.assign(formdata,{_token:'{{ csrf_token() }}'});  
    $.ajax({
         method: "POST", 
         url: "{{ url()->route('filtrar-solicitudes') }}",
         data: formdata })
      .done(function (response) {
        var objectResponse=[];
        var padre_id=0;        
        if(typeof response=== 'object'){
          for (n in response) { 
            var tickets_id=[]; 
            var catalogos_id=[];            
                var total=0;
                var exit_distrito=null;
                for(k in response[n].grupo)
                {
                  tickets_id.push(response[n].grupo[k].id);
                  
                  var legt=response[n].grupo[k].bitacora.length-1;
                  if(legt>=0){
                    catalogos_id.push(response[n].grupo[k].bitacora[legt].id_estatus_atencion);
                  }else{
                    catalogos_id.push(0);
                  }
                  
                  if(response[n].grupo[k].status!="11"){
                    total=total+parseFloat(response[n].grupo[k].info.costo_final);
                  }                  
                  Object.assign(response[n],{"tickets_id":tickets_id});
                  Object.assign(response[n],{"catalogos_id":catalogos_id});
                  Object.assign(response[n],{"costo_final":formatter.format(total) + " MXN"});
                   for(h in response[n].grupo)
                   {
                    Object.assign(response[n].grupo[h],{"tickets_id":tickets_id});
                    distrito=searchIndex('distrito',response[n].grupo[h].info.campos);
                    if(typeof distrito==="object")
                    {
                      if(distrito.clave=="1" && response[n].grupo[k].status=="1")
                      {
                        exit_distrito=distrito.clave;
                      }
                    }
                    if(response[n].grupo[h].padre_id==null)
                    {
                      padre_id=null;
                    } 
                    if(typeof (response[n].grupo[k])!=="undefined" )
                    {
                       if(response[n].grupo[k].id==response[n].grupo[h].info.complementoDe && response[n].grupo[h].info.complementoDe != null && response[n].grupo[h].id!=response[n].grupo[h].info.complementoDe && response[n].grupo[h].status==11)
                       {                       
                          Object.assign(response[n].grupo[h],{"id_transaccion_motor":[response[n].grupo[k].id_transaccion_motor]});
                       }
                    }                   
                     Object.assign(response[n].grupo[h],{"distrito":exit_distrito});
                     Object.assign(response[n].grupo[h],{"padre_exist":padre_id});
                   }                     
                } 
                objectResponse.push(response[n]);
            }
           response=objectResponse;

          }   
        createTable(response);  
      })
      .fail(function( msg ) {
       Command: toastr.warning("Error", "Notifications");
    });
  }
  function findSolicitudesCerrar(grupo_clave,data,id_proceso){
      document.getElementById("obj_grupo").value=JSON.stringify([data]);
    var formdata={ };
    Object.assign(formdata,{id_solicitud:grupo_clave}); 
    Object.assign(formdata,{_token:'{{ csrf_token() }}'});  
    response=[data];
    var tickets_id=[];
    var ids=[];
    var grupo_clave="";
    if(typeof response=== 'object'){
      for (n in response) { 
        for(k in response[n].grupo)
        {   
          tickets_id.push(response[n].grupo[k].id);               
          if(response[n].grupo[k].status=="1")
          {
            ids.push(response[n].grupo[k].id);
            grupo_clave=response[n].grupo[k].grupo_clave;
          }                                                      
        } 
      }
    }

    document.getElementById("lbl_tickets").textContent=tickets_id;
    $('#portlet-cerrarTickets').modal('show');
    document.getElementById("idgrupo").value=grupo_clave;
    document.getElementById("id_proceso").value=id_proceso;
    document.getElementById("tickets_id").value=JSON.stringify(ids);
    document.getElementById("ids").value=JSON.stringify(ids);
  }
  function cerrarSolicitudes()
    {
      var id_transaccion=$("#idgrupo").val();
      var id_proceso=$("#id_proceso").val();
      var ticks_id=$.parseJSON($("#tickets_id").val());
      var ids=$.parseJSON($("#ids").val());
      $.ajax({
      method: "post",            
      url: "{{ url()->route('update-rechazo') }}",
      data: {id:ids,tickets_id:ticks_id,estatus:52,grupo_clave:id_transaccion,id_estatus_atencion:id_proceso,mensaje:"TICKET CERRADO ",_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
          if(response.Code=='200'){
             findSolicitudes();
            Command: toastr.success(response.Message, "Notifications") 
          }else{
              Command: toastr.warning(response.Message, "Notifications") 
          }
        })
      .fail(function( msg ) {
        Command: toastr.warning("Error Rechazo", "Notifications") 
      })
    }
  function searchSolicitudes(grupo_clave){
    var formdata={};
    Object.assign(formdata,{id_solicitud:grupo_clave});  
    Object.assign(formdata,{_token:'{{ csrf_token() }}'});  
    $.ajax({
         method: "POST", 
         url: "{{ url()->route('filtrar-solicitudes') }}",
         data: formdata })
      .done(function (response) {
        
        document.getElementById("obj_grupo").value=JSON.stringify(response);
      })
      .fail(function( msg ) {
       Command: toastr.warning("Error", "Notifications");
    });
  }
  async function createTable( dataS){
      var table = $('#example').DataTable();
                table.destroy();    

      $('#example').DataTable( {
               "data": dataS,
                "columns": [
                  {
                "data": "grupo_clave",
                "class": 'detectarclick',
                "width": "2%",
                "render": function ( data, type, row, meta) {
                  
                  return row.grupo.length > 0 ? '<a ><i id="iconShow-' + data  +'" class="fa fa-plus"></a>' : '';
                }
              },
                  { "defaultContent":"Ver Detalles del Tramite"},
                  { "data":"costo_final"},
                  { "data":"grupo.length"},
                  { "data": function ( grupo ) {
                  return JSON.stringify( grupo );
                      },"visible":false},
                  {
                    "data": "grupo_clave",
                    "render": getTemplateAcciones
                  }
              ]
        });
      $('#example tbody').unbind().on('click', 'td.detectarclick', buildTemplateChild );
      await sleep(1000);
      if(dataS.length<6){
        dataS.forEach((grupo) =>{
          $("#iconShow-"+grupo.grupo_clave).trigger("click");
        });
      }
    }
    function buildTemplateChild(){
      var table = $('#example').DataTable();
          var tr = $(this).parents('tr');
          var row = table.row( tr );
          if(row.data() && row.data().grupo.length > 0){
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
              $("#iconShow-" + row.data().grupo_clave).addClass("fa-plus").removeClass("fa-minus");
            } else {
                $("#iconShow-" + row.data().grupo_clave).removeClass("fa-plus").addClass("fa-minus");
                row.child( "<div style='margin-left:15px; margin-right:15px;'>"  + format(row.data()) + "</div>").show();
                tr.addClass('shown'); 
                
            }
        }
        
        if(!{{$atencion}})
        {
          $("#select_"+row.data().grupo[0].grupo_clave).select2();
          addSelect(row.data().grupo[0].grupo_clave,row.data().catalogos_id);
        }else{
          $("#select_status_"+row.data().grupo[0].grupo_clave).select2();
          $("#select_atencion_"+row.data().grupo[0].grupo_clave).select2();
          addSelectAtencion(row.data().grupo[0].grupo_clave);
          addSelectStatus(row.data().grupo[0].grupo_clave);
          
        }
    }
  function getTemplateAcciones( data, type, row, meta){
    var  color_btn='red';
    var  label_btn='Asignado';
    var val=0;
      if(row.grupo[0].asignado_a==null)
      {
        color_btn="green";
        label_btn="Asignar";
        val=1;
      }
      let botonAtender ="";
      if(row.grupo[0].distrito!="1")
      {
        botonAtender='';
      }
       return botonAtender;
    }
  function format ( d ,b_pr) {                 
      var valid=0;            
      var rechazados=0;            
      let html = ''; 
      var exist=0;
      var ticket_status="";     
      var status_proceso=0;     
      d.grupo.forEach( (solicitud) =>{     
      //console.log(solicitud.permiso);  
        var municipio=searchIndex('municipio',solicitud.info.campos);
        var Mp='';
        if(typeof (municipio) !== 'object'){
          Mp=municipio;
        }else{          
           Mp=conctenaM(municipio);
        }     
          var clase='';
          var distrito=searchIndex('distrito',solicitud.info.campos);
          var Atender_btn="<a class='btn default btn-sm yellow-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Detalles' onclick='findAtender(\""+solicitud.id+"\",\""+solicitud.status+"\",\""+solicitud.grupo_clave+"\",\""+solicitud.id_transaccion_motor+"\",\""+solicitud.catalogo+"\",\""+JSON.stringify(solicitud.tickets_id)+"\","+JSON.stringify(solicitud)+")'><strong>Detalles</strong> </a>";
          var dist='0';

          //console.log(valid);&& index==bitacora_end
          let botonAtender = "<td class='text-center'>"+Atender_btn+"</td>";
        var valorCatas=searchIndex('valorCatastral',solicitud.info.campos);
          var lote=searchIndex('lote',solicitud.info.campos);
          var solicitantes=solicitud.info.solicitantes;
          var so="";
          var coma="";
          if(typeof solicitantes !=="undefined"){
          solicitantes.forEach((soli,ind)=>{
            so= so + coma + soli.nombreSolicitante + " " + soli.apPat + " " + soli.apMat;
            coma=', ';
          });
          so=so +'.';
        }else{
          so='';
        }
        var btn_cerrarTicket="<a class='btn default btn-sm' data-toggle='modal' data-original-title='' title='Rechazar Tickets' class='btn default btn-sm' onclick='aceptarRechazar("+solicitud.id+",\"rechazar\")'>Rechazar</a>";
        var btn_aceptarTicket="<a class='btn default btn-sm green' data-toggle='modal' data-original-title='' title='Rechazar Tickets' class='btn default btn-sm' onclick='aceptarRechazar("+solicitud.id+",\"aceptar\")'>Aceptar</a>";


          var valorOperacion=searchIndex('valorOperacion',solicitud.info.campos);
          let tdShowHijas = solicitud.grupo && solicitud.grupo.length > 0 ? "<a onclick='showMore(" + JSON.stringify(solicitud) +", event)' ><i id='iconShowChild-" + solicitud.id  +"' class='fa fa-plus'></a>" : '';
          if(solicitud.status==7 || solicitud.status==8){
            clase='warning';
          }else{
            clase='';
          }

          html += '<tr class="'+clase+'" id="trchild-' + solicitud.id +'" ><td style="width:3%;">' + tdShowHijas +'</td><td>'+solicitud.id_transaccion_motor +'('+ solicitud.id  + ')</td><td>'+ solicitud.id_transaccion  + '</td><td>'+ solicitud.tramite  + '</td><td>'+Mp+'</td><td>'+lote+'</td><td>'+so+'</td><td>'+ formatter.format(valorCatas) + '</td> <td >'+formatter.format(valorOperacion)+'</td><td>'+ solicitud.descripcion  + '</td><td class="text-center">'+btn_cerrarTicket+'</td><td class="text-center">'+btn_aceptarTicket+'<td>'+ botonAtender + '</tr>';


      });
      //console.log(exist);
      var f_o_detalle='<th></th>';
      
        html += "<tr><th></th><th colspan='5'></th> <th></th><th></th><th colspan='3'></th><th colspan='3'></th></tr>";
//style='display:none;'
        tbl_head = "<table class='table table-hover' class='sort_table' id='tbl_"+d.grupo_clave+"'><tr><th></th><th>Solicitud</th><th>FSE</th><th>Trámite</th><th>Municipios</th><th># de Lotes</th><th class='text-center' >Solicitantes</th> <th>Valor Castatral</th><th>Valor de operacion</th><th>Estatus</th><th class='text-center' ></th><th class='text-center' ></th><th></th><th></th></tr>"+html;
        return tbl_head;
    }
    function saveMessage(prelacion_,data)
    {
      //console.log(data);
      var mensaje=$("#message").val();
      var select=$("#itemsMotivos").val();
      var mot=$("#itemsMotivos option:selected").text();
      var file=$("#file").val();
      var id_=$("#idTicket").val();
      var ticks_id=$.parseJSON($.parseJSON($("#tickets_id").val()));
      var grp_clave=$("#grp_clave").val();
      var check=$("#checkbox30").prop("checked");
      var checkRechazo=$("#checkbox1").prop("checked");
      var msjpublic="1";
      var rechazo=0;
      var formdata = new FormData();
      if(check==false){
        var msjpublic="0";        
      }
      if(checkRechazo==true){
        if(select==0)
        {
          Command: toastr.warning("Motivo de rechazo, Requerido!", "Notifications")
          return;
        }
        if(mensaje.length>0)
        {
          mensaje=', Nota: '+mensaje;
        } 
        mensaje=mot +mensaje;
        formdata.append("rechazo_id",select);
        
      }
    console.log(ticks_id);
      for(r in ticks_id)
        {
          formdata.append("tickets_id[]", ticks_id[r]);  
        }
      if(mensaje.length==0){
        Command: toastr.warning("Mensaje, Requerido!", "Notifications")
        return;
      }
        var fileV = $("#file")[0].files[0];
        if(file.length>0){ 
          formdata.append("file", fileV);
        }              
        formdata.append("id[]", id_);      
        formdata.append("mensaje", mensaje);
        formdata.append("mensaje_para", msjpublic);
        formdata.append("prelacion", prelacion_);
        formdata.append("rechazo", checkRechazo);
        formdata.append("grupo_clave", grp_clave);
        formdata.append("data[]", JSON.stringify(data));
        formdata.append("_token",'{{ csrf_token() }}');
        //console.log(Object.fromEntries(formdata));
        $.ajax({
           method: "POST",
           contentType: false,
            processData: false, 
           url: "{{ url()->route('guardar-solicitudes') }}",
           data: formdata })
        .done(function (response) {
          //console.log(response.solicitante);
           if(response.Code=="200")
             {
              document.getElementById("message").value="";
              document.getElementById("file").value="";
              limpiar();
              findMessage(JSON.stringify(ticks_id));
               Command: toastr.success(response.Message, "Notifications")
               findSolicitudes();
               return;
             }
             else{
                Command: toastr.warning("Ocurrio un Error", "Notifications")
             }
          //TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }

    function revisar(id_tick,grupo_clv,id_atencion,status_){

      $.ajax({
      method: "post",            
      url: "{{ url()->route('registro-bitacora') }}",
      data: {id_ticket:id_tick,grupo_clave:grupo_clv,id_estatus_atencion:id_atencion,user_id:'{{Auth::user()->id}}',mensaje:"Revisado",status:status_,_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
          if(response.Code=='200'){
             findSolicitudes();
            Command: toastr.success(response.Message, "Notifications") 
          }else{
              Command: toastr.warning(response.Message, "Notifications") 
          }
        })
      .fail(function( msg ) {
        Command: toastr.warning("Error Rechazo", "Notifications") 
      })
    }
    function revertirStatus(tickets_id,data,status)
    { 
      response=[data];      
      var select_atencion=$("#select_atencion_"+response[0].grupo_clave).val();
      var select_status=$("#select_status_"+response[0].grupo_clave).val();
      if(select_status==0 && select_atencion==0)
      {
         Command: toastr.warning("Seleccione una Opcion", "Notifications") 
         return;
      }
      var ids=[];
      var ids_abiertos=[];
      if(typeof response=== 'object'){
        for (n in response) { 
          for(k in response[n].grupo)
          {   
            distrito=searchIndex('distrito',response[n].grupo[h].info.campos);
            if(typeof distrito==="object")
            {
              if(response[n].grupo[k].status=="1"  || response[n].grupo[k].status=="2"  || response[n].grupo[k].status=="3" && distrito.clave=="1" )
              {
                 ids.push(response[n].grupo[k].id);
              }
              if(response[n].grupo[k].status=="1" && distrito.clave=="1" )
              {
                 ids_abiertos.push(response[n].grupo[k].id);
              }
            }                                                   
          } 
        }
      }
        document.getElementById("lbl_revert_tickets").textContent=ids;
        document.getElementById("ticket_status").value=status;
        document.getElementById("grp_clave").value=response[0].grupo_clave;
        document.getElementById("ids").value=JSON.stringify(ids);
        document.getElementById("ids_abiertos").value=JSON.stringify(ids_abiertos);
         $('#portlet-revertTickets').modal('show');
    }
    function revert()
    {
      var grp_clave=$("#grp_clave").val();
      var select_atencion=$("#select_atencion_"+response[0].grupo_clave).val();
      var select_status=$("#select_status_"+response[0].grupo_clave).val();

      var ids=$.parseJSON($("#ids").val());
      var ids_abiertos=$.parseJSON($("#ids_abiertos").val());
      //console.log(ids_abiertos);
      if(select_status==0 && ids_abiertos.length==0){
          Command: toastr.warning("Seleccione el Estatus", "Notifications") 
      }else if(select_atencion!=0 && select_status==0){
        revertirTicket(ids,1,select_atencion);
      }else if(select_atencion!=0 && select_status!=0){
        revertirTicket(ids,select_status,select_atencion);
      }
    }   
    function revertirTicket(ids,status_,select_atencion)
    {
      $.ajax({
      method: "post",            
      url: "{{ url()->route('revertir-status') }}",
      data: {id_ticket:ids,status:status_,estatus_atencion:select_atencion,_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
         if(response.Code=="200")
            {
              Command: toastr.success(response.Message, "Notifications")
              findSolicitudes();
              return;
            }
            else{
              Command: toastr.warning("Ocurrio un Error", "Notifications")
            } 
        })
      .fail(function( msg ) {
        Command: toastr.warning("Error Rechazo", "Notifications") 
      })

    }

    function relacion_mult(grupo_clave,data,id_proceso)
    {
      //searchSolicitudes(grupo_clave);
       document.getElementById("obj_grupo").value=JSON.stringify([data]);
      document.getElementById("m_grupo_clave").value=grupo_clave;
      document.getElementById("id_proceso").value=id_proceso;
      document.getElementById("lbl_grupo_clave").textContent=grupo_clave;
      $('#portlet-prelacion').modal('show');
    }
   
    function savePrelacion(prelacion_,formdata,grupo_clave,resp)
    {
      var mensaje=$("#message").val();
      var file=$("#file").val();
      var checkRechazo=false;
      var msjpublic="1";
      var rechazo=0;
     resp=$.parseJSON(resp);
      //var formdata = new FormData();     
      mensaje="Prelación, Clave_grupo:"+grupo_clave+", Folio:"+resp.folio+", Fecha:"+resp.fecha;        
             
        formdata.append("mensaje", mensaje);
        formdata.append("mensaje_para", msjpublic);
        formdata.append("prelacion", prelacion_);
        formdata.append("rechazo", checkRechazo);
        formdata.append("grupo_clave", grupo_clave);
        //formdata.append("id_estatus_atencion", id_proceso);
        //formdata.append("data[]", JSON.stringify(data));
        formdata.append("_token",'{{ csrf_token() }}');
      $.ajax({
          method: "POST",
          contentType: false,
          processData: false, 
          url: "{{ url()->route('guardar-solicitudes') }}",
          data: formdata })
      .done(function (response) {
          if(response.Code=="200")
            {
              Command: toastr.success(response.Message, "Notifications")
              findSolicitudes();
              return;
            }
            else{
              Command: toastr.warning("Ocurrio un Error", "Notifications")
            }  
      })
      .fail(function( msg ) {
        Command: toastr.warning("Error", "Notifications");
      });
    }

    function showMore( solicitud, e){
      var tr = $(e.target).parents('tr');
      if( solicitud.grupo && solicitud.grupo.length > 0 ){

        if(tr.hasClass("shown") ){
          tr.removeClass('shown');
          $("#brothertr-" + solicitud.id ).remove();

          $("#iconShowChild-" + solicitud.id).addClass("fa-plus").removeClass("fa-minus");
        } else {
          $("#iconShowChild-" + solicitud.id).removeClass("fa-plus").addClass("fa-minus");
          tr.addClass('shown');
          $("#trchild-" + solicitud.id).after("<tr style='border-left-style: dotted; border-bottom-style: dotted;' id='brothertr-" + solicitud.id + "''><td colspan='12'>"  + format( solicitud) + "</td></tr>");
        }

      }
      $("#select_"+solicitud.grupo[0].grupo_clave).select2();
    }

    function obtnerRegion()
    {
      var id_ticket="";
      var user_id="";
      $.ajax({
      method: "post",            
      url: "{{ url()->route('obtener-region',['id_ticket'=>"+id_ticket+",'user_id'=>"+user_id+"]) }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) { 
         
        })
      .fail(function( msg ) {
        Command: toastr.warning("Error Rechazo", "Notifications") 
      })
    }
  
   
   function addSelect(grupo_clave,id){
      $.ajax({
          method: "get",            
          url: "{{ url()->route('get-solicitudes-motivos', '') }}",
          data: {solicitud_catalogo_id:id,_token:'{{ csrf_token() }}'}  })
          .done(function (response) { 
            $("#select_"+grupo_clave+" option").remove();
          $("#select_"+grupo_clave).append("<option value='0'>------</option>");
          $.each($.parseJSON(response), function(i, item) {
            $("#select_"+grupo_clave).append("<option value='"+item.motivo_id+"'>"+item.motivo+"</option>");
          
          });
      })
      .fail(function( msg ) {
        Command: toastr.warning("Error Select", "Notifications") 
      })
    }   
    function addSelectAtencion(grupo_clave){
      
      $("#select_atencion_"+grupo_clave+" option").remove();
      $("#select_atencion_"+grupo_clave).append("<option value='0'>---Estatus Proceso---</option>");
      $("#select_atencion_"+grupo_clave).append("<option value='2'>Recepcion de documentos</option>");
      $("#select_atencion_"+grupo_clave).append("<option value='3'>Validador</option>");
      $("#select_atencion_"+grupo_clave).append("<option value='4'>Finalizado</option>");
          
    } 
    function addSelectStatus(grupo_clave){
      
      $("#select_status_"+grupo_clave+" option").remove();
      $("#select_status_"+grupo_clave).append("<option value='0'>---Estatus Solicitud----</option>");
      $("#select_status_"+grupo_clave).append("<option value='1'>Abierto</option>");
      $("#select_status_"+grupo_clave).append("<option value='2'>Cerrado</option>");
          
    }
    function conctenaM(municipio)
    {
      var coma='';var Mp='';
      if(typeof municipio.nombre !=='undefined')
       {
        Mp=municipio.nombre;
       }else{
         $.each(municipio, function(i, item) {
            Mp=Mp + coma + item.nombre;
            coma=', ';
          });
          Mp=Mp+'.';
       }
         
        return Mp;
    }
    function tableMsg(){
      $("#addtableMsg div").remove();
      $("#addtableMsg").append("<div class='removeMsg'> <table class='table table-hover' id='sample_7'> <thead><tr><th>Solicitud</th><th>Mensajes</th><th>Archivo</th> <th>Estatus</th><th>Fecha</th> </tr></thead> <tbody></tbody> </table></div>");
    }
    function addInfo()
    {
      $("#addDetalles").empty();
      $("#addSolicitante").empty();
      $("#addnotaria").empty();
      $(".divNotaria").css("display", "none");
      //document.getElementById("btn_guardar").disabled = true;
      //document.getElementById("file").disabled = true;
    }
    function findAtender(id,estatus,grupo_clave,folioPago,catalogo_id,tickets_id,data_o)
    {addInfo();
      document.getElementById("idmodal").textContent=id;
      document.getElementById("idTicket").value=id;
      document.getElementById("folioPago").value=folioPago;
      document.getElementById("grp_clave").value=grupo_clave;
      document.getElementById("tickets_id").value=JSON.stringify(tickets_id);
      document.getElementById("data").value=data_o;
      //console.log(tickets_id);
      findMessage(tickets_id);
            response=$.parseJSON(JSON.stringify(data_o));
          document.getElementById("jsonCode").value=JSON.stringify(response);
          var Resp=response;
          var soli=Resp.info.solicitantes;
          var tipo="";
          var obj="";
          if(typeof soli !=="undefined")
          {
          $.each(soli, function(i, item) { 
           
             for (n in item) {  
            obj=n;
            tipo=item[n];    
            if(tipo=="pm"){tipo="Moral";}
            if(tipo=="pf"){tipo="Fisica";}
            if(obj=="tipoPersona"){obj="Tipo Persona";}
            if(obj=="rfc"){obj="RFC";}
            if(obj=="razonSocial"){obj="Razón Social";}
            if(obj=="nombreSolicitante"){obj="Nombre del Solicitante";}            
            if (typeof (tipo) !== 'object' && obj!="id")
            {
              if(obj=="notary"){obj="Notaria"}
              if(obj=="apPat"){obj="Apellido Paterno";}
              if(obj=="apMat"){obj="Apellido Materno";}
              $("#addSolicitante").append("<div class='col-md-4'><div class='form-group'><label><strong>"+obj+":</strong></label><br><label>"+tipo+"</label></div></div>");            
            }            
          }
          });


          for (n in soli) {  
            obj=n;
            tipo=soli[n];    
            if(tipo=="pm"){tipo="Moral";}
            if(tipo=="pf"){tipo="Fisica";}
            if(obj=="tipoPersona"){obj="Tipo Persona";}
            if(obj=="rfc"){obj="RFC";}
            if(obj=="razonSocial"){obj="Razón Social";}
            if(obj=="nombreSolicitante"){obj="Nombre del Solicitante";}            
            if (typeof (tipo) !== 'object' && obj!="id")
            {
              if(obj=="notary"){obj="Notaria"}
              if(obj=="apPat"){obj="Apellido Paterno";}
              if(obj=="apMat"){obj="Apellido Materno";}
              $("#addSolicitante").append("<div class='col-md-4'><div class='form-group'><label><strong>"+obj+":</strong></label><br><label>"+tipo+"</label></div></div>");            
            }            
          }
        }
          if(typeof(Resp.notary_number)!=="undefined" && typeof(Resp.notary_number)!=="object" ){
            $(".divNotaria").css("display", "block");
            dataNot='';
            for (not in Resp) {  
              if(not=='notary_number' || not=='email' || not=='nombre_titular' || not=='apellido_pat_titular' || not=='apellido_mat_titular')
              { 
                if(not=='notary_number'){dataNot='Numero de Notaria';}
                if(not=='email'){dataNot='Correo Electrónico';}  
                 if(not=='nombre_titular'){dataNot='Nombre';}
                if(not=='apellido_pat_titular'){dataNot='Apellido Paterno';} 
                if(not=='apellido_mat_titular'){dataNot='Apellido Materno';}           
                $("#addnotaria").append("<div class='col-md-4'><div class='form-group'><label><strong>"+dataNot+":</strong></label><br><label>"+Resp[not]+"</label></div></div>");
              }
            }
          }
          for (n in Resp.info.campos) {  
            if(typeof (Resp.info.campos[n]) !== 'object') {         
              $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+Resp.info.campos[n]+"</label></div></div>");  
            }else{
                Mp=conctenaM(Resp.info.campos[n]); 
                $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+ Mp+"</label></div></div>");
            }             
          }
            $("#scrollDiv").animate({ scrollTop: 0 }, "slow");
         
    }
    function findMessage(id_)    
    {
      $.ajax({
           method: "GET", 
           url: "{{ url()->route('listado-mensajes', '') }}" + "/"+id_,
           data:{_token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response);
          tableMsg();
          var icon="";
          var color="";
          var attach="";
          var mensaje_para="";
          var resp=$.parseJSON(response);
           $.each(resp, function(i, item) {
            if(item.attach== null || item.attach=="")
            {
              icon="";
              attach="";
            }else {
              icon="<i class='fa fa-download'></i>";
              attach=item.attach.split("/");            
              attach= attach[attach.length-1];
            }
            if(item.mensaje_para==null || item.mensaje_para==0 )
            {
              mensaje_para="Privado";
              label="danger";
            }else{
              mensaje_para="Publico";
              label="success";
            }
            

              $('#sample_7 tbody').append("<tr>"
                  +"<td>"+item.ticket_id+"</td>"
                  +"<td>"+item.mensaje+"</td>"
                  +"<td><a href='"+item.attach+"' title='Descargar Archivo' target='_blank'>"+attach+" "+icon+"</a></td>"
                  +"<td><span class='label label-sm label-"+label+"'>"+mensaje_para+"</span></td>"
                  +"<td>"+item.created_at+"</td>"
                  +"</tr>"
                );           
            
            });
          
          //TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function aceptarRechazar(id_ticket,mensaje_)
    {
      //var idT=$("#idTicket").val();
      //var mensaje_=$("#message").val();
     $.ajax({
           method: "POST", 
           url: "{{ url()->route('aceptar-rechazar-tramite') }}",
           data:{ ticket_id:id_ticket ,mensaje:mensaje_,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               findSolicitudes();
               return;
             } 
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
  async function chgopt(id)
  {  
    await sleep(2000);
    $("#opTipoSolicitud").val(id).change();
  } 
  function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
  }

  function searchIndex(key,jarray)
  {
    //console.log(jarray);
    var config=$.parseJSON($("#configP").val());
    var response='';
    if(typeof jarray!=='undefined')
    {
      $.each(config.solicitudes[key], function(i, item) {  

        if(typeof jarray[item]!=='undefined')
        {       
          response=jarray[item];        
        }    
      });
    }
    return response;
  }
  function searchDivisa(key)
  {
    var config=$.parseJSON($("#configP").val());
    var response='MXN';
    if(typeof config.solicitudes[key] !=='undefined')
    {
      response=config.solicitudes[key];
    }
    return response;
  }
   const formatter = new Intl.NumberFormat('es-MX', {
      style: 'currency',
      currency: 'MXN',
      minimumFractionDigits: 2
    })
  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
  function sortTable(grupo_clave) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("tbl_"+grupo_clave);
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[1];
      y = rows[i + 1].getElementsByTagName("TD")[1];
      if(typeof(y) !=='undefined')
      {
        if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
function limpiar()
  {
    $("#checkbox1").prop("checked", false);
    document.getElementById("message").value="";
    document.getElementById('delFile').click();
    
  }
  </script>

@endsection
