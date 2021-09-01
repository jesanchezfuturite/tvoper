@extends('layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
<link href="{{ asset('assets/global/dataTable/dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Portal <small>Listado Solicitudes</small></h3>
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
            <a href="#">Listado Solicitudes</a>
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
                              <input type='checkbox' id='checkbox1' name="checkMotivos" class='md-check' onchange="changeMotivos()">
                                <label for='checkbox1'>
                                <span></span>
                                <span class='check'></span> <span class='box'>
                                </span> Rechazo. </label>
                            </div>
                          
                            <div class='md-checkbox'>
                              <input type='checkbox' id='checkbox30' name="checkbox30" class='md-check'>
                                <label for='checkbox30'>
                                <span></span>
                                <span class='check'></span> <span class='box'>
                                </span>  Mensaje Publico. </label>
                            </div>
                          </div>
                        </div>
                          <div class="row selectMotivos">
                            <div class="col-md-12">
                            <span class="help-block">&nbsp;</span> 
                            <label class="col-md-2">Motivos de Rechazo</label>
                              <div class="col-md-7">
                              <select class="select2me form-control" name="itemsMotivos" id="itemsMotivos" onchange="changeSelectMot()">
                                <option value="0">------</option>  
                              </select>
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
               <button type="button" data-dismiss="modal" class="btn red" onclick="limpiar()">Salir</button>
            </div>
          </div>
          <div class="col-md-1 ">
            <div class="form-group ">
              <button type="button"  class="btn default btnPrelacion " onclick="prelacion()" >Prelación</button>
            </div>
          </div>
        <!--  <div class="col-md-3 group-btn2">
            <button type="button" data-dismiss="modal" class="btn green btn_cerrar_2" id="btn_cerrar_2" onclick="cerrarTicket()" >Cerrar Ticket</button>
          </div>-->
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
<div id="portlet-rechazar" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿Rechazar Solicitudes: <label id="lbl_idsolicitudes" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="rechazarSolicitudes()">Confirmar</button>
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
             ¿Finalizar Solicitudes: <label id="lbl_tickets" style="color: #cb5a5e;"></label>?</p>
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
<div id="portlet-revertTickets" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿Revertir Solicitudes: <label id="lbl_revert_tickets" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="revert()">Confirmar</button>
        </div>
            </div>
        </div>
    </div>
</div>
<div id="portlet-prelacion" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <span class="help-block">&nbsp;</span> <p>
             ¿Generar Prelación del grupo: <label id="lbl_grupo_clave" style="color: #cb5a5e;"></label>?</p>
              <span class="help-block">&nbsp;</span>              
                
            </div>
            <div class="modal-footer">
                <div id="AddbuttonDeleted">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="prelacion_confirm_all()">Confirmar</button>
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
  function prelacion()
  { 
    objectResponse=[];    
    var reg=registroPublico();
    var resp=$.parseJSON(reg);
    //console.log(registroPublico());
    //console.log(resp);
    document.getElementById("message").value="Prelacion, Folio: " + resp.folio + "\n Fecha: "+resp.fecha; 
    //document.getElementById("message").value="Prelacion, Folio: \n Fecha: ";
    data=dataPrelacion(reg,null);
    //console.log(objectResponse);
    //var data=dataPrelacion({namd:"asd"});
    saveMessage(1,data);
    $(".btnPrelacion").css("display", "none");    
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
    //var id_catalogo_=$("#opTipoSolicitud").val();
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
          //console.log(response);     
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

      //console.log(tickets_id);
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
      //console.log(dataS);
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
       //sortTable(row.data().grupo[0].grupo_clave);

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
      let botonAtender ="";// "<a class='btn default btn-sm "+color_btn+"-stripe' href='' data-toggle='modal' data-original-title='' title='"+label_btn+"' onclick='AsignarGrupo(\""+row.grupo[0].id+"\",\""+row.grupo_clave+"\",\""+val+"\")'> <strong>"+label_btn+"</strong> </a>";
     
      if(row.grupo[0].distrito!="1")
      {
        botonAtender='';
      }
    /*else{
        return "<td class='text-center' width='10%'></td>"
      }*/
       return botonAtender;
    }
  function format ( d ,b_pr) {                 
      var valid=0;            
     var rechazados=0;            
 let html = ''; 
      let g_prelacion = 0; 
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
        if(solicitud.bitacora.length==0)
        {
          solicitud.bitacora.push({nombre:"N/A",id:1,id_estatus_atencion:1,responsables:{permiso:0}});
        }
        var bitacora_end=solicitud.bitacora.length-1;
        if(solicitud.bitacora[bitacora_end].id_estatus_atencion==3){
          status_proceso=solicitud.bitacora[bitacora_end].id_estatus_atencion;
        }
        if(solicitud.bitacora[bitacora_end].id_estatus_atencion==2){
          status_proceso=solicitud.bitacora[bitacora_end].id_estatus_atencion;
        }

        
        var bitacora=solicitud.bitacora;
        @if($atencion=="true")
          solicitud.bitacora.forEach((bitacora,index)=>{ 
           
          bitacora_end=index;
          bitacora=solicitud.bitacora;
        @endif 
        if(bitacora[bitacora_end].info!=null)
            {
            var infoM=$.parseJSON(bitacora[bitacora_end].info);
            var municipioM=searchIndex('municipio',infoM.campos);
            if(typeof (municipioM) !== 'object'){
              Mp=municipioM;
            }else{          
               Mp=conctenaM(municipioM);
            }  
          }
          var clase='';
          var btn_revisar="<a class='btn default btn-sm red-stripe' data-toggle='modal' data-original-title='' title='Revisado' onclick='revisar(\""+solicitud.id+"\",\""+solicitud.grupo_clave+"\",\""+bitacora[bitacora_end].id_estatus_atencion+"\",\""+solicitud.status+"\")'><strong>Revisado</strong> </a>";
          var distrito=searchIndex('distrito',solicitud.info.campos);
          var Atender_btn="<a class='btn default btn-sm yellow-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Detalles' onclick='findAtender(\""+solicitud.id+"\",\""+solicitud.status+"\",\""+solicitud.grupo_clave+"\",\""+solicitud.id_transaccion_motor+"\",\""+solicitud.catalogo+"\",\""+JSON.stringify(solicitud.tickets_id)+"\","+JSON.stringify(solicitud)+")'><strong>Detalles</strong> </a>";
          var dist='0';
          if(typeof(distrito)==='object'){
            dist=distrito.clave;            
          }
          if(dist!='1')
          {
              Atender_btn="&nbsp;<span class='label label-sm label-warning'>Distrito foráneo</span>";
             btn_revisar='';
          }
          if(solicitud.status!=1 && dist=='1')
          {
              Atender_btn="&nbsp;<span class='label label-sm label-warning'>"+solicitud.descripcion+"</span>";
            btn_revisar='';
          }  
          if(solicitud.status=='2' || solicitud.status=='3' && dist=='1'){
            exist+=1;
            ticket_status=solicitud.status;

          }
          if(d.grupo[0].url_prelacion!=null && d.grupo[0].distrito==null /*|| bitacora_end!=index*/)
          {
            Atender_btn="&nbsp;<span class='label label-sm label-warning'>Atendido</span>";
            btn_revisar='';
          } 
          if(bitacora[bitacora_end].responsables.permiso==0 || bitacora[bitacora_end].permiso==0  /*&& index==bitacora_end*/)
          {
             Atender_btn="&nbsp;<span class='label label-sm label-warning'>"+bitacora[bitacora_end].nombre+"</span>";
            btn_revisar='';
          }
          if(bitacora[bitacora_end].id_estatus_atencion!="2")
          {
            btn_revisar='';
          }
          if(bitacora[bitacora_end].responsables.permiso==1  && solicitud.status=='1')
          {
            valid=1;
          }
          if(solicitud.status=='7' || solicitud.status=='8' && dist=='1')
          {
            rechazados=1;
          }
          //console.log(valid);&& index==bitacora_end
          let botonAtender = "<td class='text-center' width='5%'>"+Atender_btn+"</td>";
          var valorCatas=searchIndex('valorCatastral',solicitud.info.campos);
          var lote=searchIndex('lote',solicitud.info.campos);
          var escrituraActaOficio=searchIndex('escrituraActaOficio',solicitud.info.campos);
          
           if(typeof (escrituraActaOficio) === 'object'){
            escrituraActaOficio=conctenaM(escrituraActaOficio);
          }else{          
             escrituraActaOficio=escrituraActaOficio;
          }

          var valorOperacion=searchIndex('valorOperacion',solicitud.info.campos);
          var valorISAI=searchIndex('valorISAI',solicitud.info.campos);
          let tdShowHijas = solicitud.grupo && solicitud.grupo.length > 0 ? "<a onclick='showMore(" + JSON.stringify(solicitud) +", event)' ><i id='iconShowChild-" + solicitud.id  +"' class='fa fa-plus'></a>" : '';
          if(solicitud.status==7 || solicitud.status==8){
            clase='warning';
          }else{
            clase='';
          }

          html += '<tr class="'+clase+'" id="trchild-' + solicitud.id +'" ><td style="width:3%;">' + tdShowHijas +'</td><td>'+solicitud.id_transaccion_motor +'('+ solicitud.id  + ')</td><td>'+ solicitud.id_transaccion  + '</td><td>'+ solicitud.tramite  + '</td><td>'+Mp+'</td><td>'+lote+'</td><td>'+escrituraActaOficio+'</td><td>'+ formatter.format(valorCatas) + '</td> <td >'+formatter.format(valorOperacion)+'</td><td>'+ valorISAI  + '</td><td>'+ solicitud.descripcion  + '</td><td>'+ bitacora[bitacora_end].nombre  + '</td>'+ botonAtender + '</tr>';
         //<td>'+btn_revisar+'</td>  
        @if($atencion=="true")
        })
        @endif 
         solicitud.bitacora.forEach((bitac,index)=>{
         if(bitac.id_estatus_atencion==2 && bitac.responsables.permiso==1){
                g_prelacion=1;
            }          
        })
        /*if(status_proceso==2 || status_proceso==3)
        {
                  }*/
      });
      //console.log(exist);
      var btn_cerrarTicket="<a class='btn default btn-sm green' data-toggle='modal' data-original-title='' title='Finalizar Ticket' class='btn default btn-sm' onclick='findSolicitudesCerrar(\""+d.grupo[0].grupo_clave+"\","+JSON.stringify(d)+","+status_proceso+")'>Finalizar Ticket</a>";
      var url_prelacion="<a href='{{ url()->route('view-file', '') }}/"+d.grupo[0].url_prelacion+"' title='Descargar Archivo' target='_blank'>"+d.grupo[0].url_prelacion+"<i class='fa fa-download blue'></i></a></td>";
      var btn_prelacion="<a href='javascript:;' class='btn btn-sm default btn_prelacion_"+d.grupo[0].grupo_clave+"' onclick='relacion_mult(\""+d.grupo[0].grupo_clave+"\","+JSON.stringify(d)+","+status_proceso+")'><i class='fa fa-file-o'></i> Realizar la prelación de todo el trámite  </a>";
        var select_rechazos='<select class="select-a form-control form-filter input-sm" name="select_'+d.grupo[0].grupo_clave+'" id="select_'+d.grupo[0].grupo_clave+'"><option value="0">-------</option></select>';
        var btn_rechazo="<a class='btn default btn-sm green' data-toggle='modal' data-original-title='' title='Rechazar' class='btn default btn-sm' onclick='rechazarArray(\""+d.grupo[0].grupo_clave+"\","+JSON.stringify(d.tickets_id)+","+status_proceso+","+JSON.stringify(d)+")'>Rechazar</a>";
        
        if(d.grupo[0].url_prelacion!=null && g_prelacion==1)
        { btn_prelacion="";
          select_rechazos="";
          btn_rechazo="";
          btn_cerrarTicket="";
        }
        console.log(status_proceso);
        if(status_proceso!=2)
        {
          btn_prelacion=''; 
          url_prelacion='';
        }else{
           btn_cerrarTicket='';
        }
        if(d.grupo[0].distrito==null){
          select_rechazos="";
          btn_rechazo="";
          btn_prelacion="";
          btn_cerrarTicket='';
        }
        if( valid==0 || rechazados==1 ){
          select_rechazos="";
          btn_rechazo="";
          btn_prelacion="";
         url_prelacion='';
         btn_cerrarTicket='';
        }
        if({{$atencion}})
        {
          btn_cerrarTicket='';
          select_rechazos='<select class="select-a form-control form-filter input-sm" name="select_atencion_'+d.grupo[0].grupo_clave+'" id="select_atencion_'+d.grupo[0].grupo_clave+'"><option value="0">---Estatus Proceso---</option></select>';
          btn_rechazo="<a class='btn default btn-sm green' data-toggle='modal' data-original-title='' title='Revertir Estatus' class='btn default btn-sm' onclick='revertirStatus("+JSON.stringify(d.tickets_id)+","+JSON.stringify(d)+",\"" +ticket_status+"\")'>Revertir Solicitud</a>";
          btn_prelacion='<select class="select-a form-control form-filter input-sm" name="select_status_'+d.grupo[0].grupo_clave+'" id="select_status_'+d.grupo[0].grupo_clave+'"><option value="0">---Estatus Solicitud----</option></select>';
        }
        if(g_prelacion==1 || {{$atencion}}){
          url_prelacion="<a href='{{ url()->route('view-file', '') }}/"+d.grupo[0].url_prelacion+"' title='Descargar Archivo'  target='_blank'>"+d.grupo[0].url_prelacion+"<i class='fa fa-download blue'></i></a></td>";
        }        
        if(d.grupo[0].url_prelacion==null)
        {
          url_prelacion='';
        }
        html += "<tr><th></th><th style='display:none;'></th><th></th><th colspan='4'>"+url_prelacion+"</th><th colspan='2'>"+btn_prelacion+"</th> <th>"+btn_cerrarTicket+"</th><th colspan='3'>"+select_rechazos+"</th><th>"+btn_rechazo+"</th></tr>";
//style='display:none;'
        tbl_head = "<table class='table table-hover' class='sort_table' id='tbl_"+d.grupo_clave+"'><tr><th></th><th>Solicitud</th><th>FSE</th><th>Trámite</th><th>Municipios</th><th># de Lotes</th><th>No. Escritura/ Acta/ Oficio</th> <th>Valor Castatral</th><th>Valor de operacion</th><th>ISAI</th><th>Estatus</th><th>Proceso</th><th></th></tr>"+html;
        return tbl_head;
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
    function prelacion_confirm_all()
    {
      var m_grupo_clave=$("#m_grupo_clave").val();
      var id_proceso=$("#id_proceso").val();
      $(".btn_prelacion_"+m_grupo_clave).css("display", "none");
      var formdata=new FormData();
      formdata.append("id_estatus_atencion", id_proceso);
      var id_="";
      var grupo_clave="";
      count=0;
      
      var response_grp=$.parseJSON($("#obj_grupo").val());
      var response_grp=$.parseJSON(JSON.stringify(response_grp));
       var objectResponse=[];
       //
       $.ajax({
      method: "get",            
      url: "{{ url()->route('wsrp', 'qa') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {
      resp=JSON.stringify(response); 
       if(typeof response_grp=== 'object'){
          for (n in response_grp) {
            var partida="";              
            for(g in response_grp[n].grupo)
            {
             var pagos=[]; 
              
              total=0;
              total=total+parseFloat(response_grp[n].grupo[g].info.costo_final);
              if(typeof response_grp[n].grupo[g].total!=="undefined")
              {
                total=total+parseFloat(response_grp[n].grupo[g].total);
                pagos=response_grp[n].grupo[g].pagos;
              }
              if(typeof(response_grp[n].grupo[g].info.detalle.descuentos)!=="undefined")
              {
                if(response_grp[n].grupo[g].info.detalle.descuentos.length>0){
                  for( desc in response_grp[n].grupo[g].info.detalle.descuentos )
                  {
                    if(typeof(response_grp[n].grupo[g].info.detalle.descuentos[desc].partida_descuento)!=="undefined")
                    {
                      pagos.push({pagos:parseFloat(response_grp[n].grupo[g].info.detalle.descuentos[desc].importe_total),"descripcion":"Derecho-"+response_grp[n].grupo[g].id_transaccion_motor});
                      pagos.push({pagos:parseFloat("-"+response_grp[n].grupo[g].info.detalle.descuentos[desc].importe_subsidio),"descripcion":"Subsidio-"+response_grp[n].grupo[g].id_transaccion_motor});
                      partida=partida + " "+response_grp[n].grupo[g].info.detalle.descuentos[desc].partida_descuento;
                    }else{
                     pagos.push({pagos:parseFloat(response_grp[n].grupo[g].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[g].id_transaccion_motor});
                      partida=partida;
                    }
                  }
                }else{
                  pagos.push({pagos:parseFloat(response_grp[n].grupo[g].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[g].id_transaccion_motor});
                      partida=partida;
                }
              }else{
                 pagos.push({pagos:parseFloat(response_grp[n].grupo[g].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[g].id_transaccion_motor});
                  partida=partida;
              }
              
              Object.assign(response_grp[n].grupo[g],{"pagos":pagos});
              Object.assign(response_grp[n].grupo[g],{"partida":partida});
              id_=response_grp[n].grupo[g].id; 
                  
              grupo_clave=response_grp[n].grupo[g].grupo_clave;
              for(h in response_grp[n].grupo)
              {
                if(response_grp[n].grupo[g].id==response_grp[n].grupo[h].info.complementoDe && response_grp[n].grupo[h].info.complementoDe != null && response_grp[n].grupo[h].id!=response_grp[n].grupo[h].info.complementoDe && response_grp[n].grupo[g].status!="11"){ 
                    total=total+parseFloat(response_grp[n].grupo[h].info.costo_final);
                    Object.assign(response_grp[n].grupo[h],{"total":total});
                    // pagos.push({pagos:parseFloat(response_grp[n].grupo[h].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[g].id_transaccion_motor});
                     
                     if(typeof(response_grp[n].grupo[h].info.detalle.descuentos)!=="undefined")
                      {
                        for( descc in response_grp[n].grupo[h].info.detalle.descuentos )
                        {
                          if(typeof(response_grp[n].grupo[h].info.detalle.descuentos[descc].partida_descuento)!=="undefined")
                          {
                            pagos.push({pagos:parseFloat(response_grp[n].grupo[h].info.detalle.descuentos[descc].importe_total),"descripcion":"Derecho-"+response_grp[n].grupo[h].id_transaccion_motor});
                            pagos.push({pagos:parseFloat("-"+response_grp[n].grupo[h].info.detalle.descuentos[descc].importe_subsidio),"descripcion":"Subsidio-"+response_grp[n].grupo[h].id_transaccion_motor});
                            partida=partida + " "+response_grp[n].grupo[h].info.detalle.descuentos[desc].partida_descuento;
                          }else{
                           pagos.push({pagos:parseFloat(response_grp[n].grupo[h].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[h].id_transaccion_motor});
                            partida=partida;
                          }
                        }
                      }else{
                         pagos.push({pagos:parseFloat(response_grp[n].grupo[h].info.costo_final),"descripcion":"Derecho-"+response_grp[n].grupo[h].id_transaccion_motor});
                          partida=partida;
                      }
                  Object.assign(response_grp[n].grupo[h],{"pagos":pagos});
                  Object.assign(response_grp[n].grupo[h],{"partida":partida});
                }
              }

              Object.assign(response_grp[n].grupo[g].info,{"tramite":response_grp[n].grupo[g].tramite});
            }
          }
        }
          if(typeof response_grp=== 'object'){
          for (n in response_grp) {              
            for(g in response_grp[n].grupo)
            {   count+=1;
              var distrito=searchIndex('distrito',response_grp[n].grupo[g].info.campos); 
              if(typeof(distrito)==='object'){
                if(response_grp[n].grupo[g].status=='1' && distrito.clave=='1' && response_grp[n].grupo[g].padre_id==null)
                {
                   
                formdata.append("tickets_id[]", response_grp[n].grupo[g].id);
                  formdata.append("id[]", id_);
                 
                  document.getElementById("folioPago").value=response_grp[n].grupo[g].id_transaccion_motor;
                  datapr=dataPrelacion(resp,JSON.stringify(response_grp[n].grupo[g]));
                  formdata.append("data[]",JSON.stringify(datapr)); 
                  
                }   
              } 

            }
          }
          
           if(count==0)
          {
            Command: toastr.warning("Sin Registros", "Notifications")
           return;
          } 
          //console.log(response_grp);        
          savePrelacion(1,formdata,grupo_clave,resp);
        }
       
      })       
      .fail(function( msg ) {
         Command: toastr.warning("Error al generar la prelacion", "Notifications")   });
        
        
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
    function rechazarArray(id_transaccion,tickets_id,id_estatus_atencion,data)
    {
      //console.log(tickets_id);
      var estatus_=$("#select_"+id_transaccion).val();
      if(estatus_=='0')
      {
        Command: toastr.warning("Seleccionar Motivo de rechazo", "Notifications") 
        return;
      }
      response=[data];
      //var tickets_id=[];
      var ids=[];
      var grupo_clave="";
      if(typeof response=== 'object'){
        for (n in response) { 
          for(k in response[n].grupo)
          {   
            distrito=searchIndex('distrito',response[n].grupo[h].info.campos);
            if(typeof distrito==="object")
            {
              if(distrito.clave=="1" && response[n].grupo[k].status=="1")
              {
                 ids.push(response[n].grupo[k].id);
              }
            }                                                   
          } 
        }
      }

      if(ids.length>0){
        document.getElementById("lbl_idsolicitudes").textContent=ids;
        document.getElementById("ids").value=JSON.stringify(ids);
         $('#portlet-rechazar').modal('show');
         document.getElementById("idgrupo").value=id_transaccion;
         document.getElementById("tickets_id").value=JSON.stringify(ids);
         document.getElementById("id_proceso").value=id_estatus_atencion;
      }

    }
    function rechazarSolicitudes()
    {
      var id_transaccion=$("#idgrupo").val();
      var id_proceso=$("#id_proceso").val();
      var ids=$.parseJSON($("#ids").val());
      var tick_id=$.parseJSON($("#tickets_id").val());
      var estatus_=$("#select_"+id_transaccion).val();
      var mot=$("#select_"+id_transaccion+" option:selected").text();
      if(estatus_=='0')
      {
        Command: toastr.warning("Seleccionar Motivo de rechazo", "Notifications") 
        return;
      }
      //console.log(ids);
      $.ajax({
      method: "post",            
      url: "{{ url()->route('update-rechazo') }}",
      data: {id:ids,estatus:estatus_,grupo_clave:id_transaccion,mensaje:mot,tickets_id:tick_id,id_estatus_atencion:id_proceso,_token:'{{ csrf_token() }}'}  })
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
          findMotivosSelect([catalogo_id]);
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
              attach=item.attach;
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
                  +"<td><a href='{{ url()->route('listado-download', '') }}/"+item.attach+"' title='Descargar Archivo'>"+attach+" "+icon+"</a></td>"
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
    function cerrarTicket()
    {
      var idT=$("#idTicket").val();
      var id_catalogo_=$("#opTipoSolicitud").val();
      btn_2="cerrar";
      //var btn_2=$("#btn_cerrar_2").val();
      //console.log(btn_2);
     $.ajax({
           method: "POST", 
           url: "{{ url()->route('cerrar-ticket') }}",
           data:{ id:idT ,id_catalogo:id_catalogo_,option:btn_2,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response.solicitante);

           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               findSolicitudes();
               findSol();
               chgopt(id_catalogo_);
               limpiar();
               return;
             }
          //TableManaged7.init7();   
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

  function dataPrelacion(dataP,jsn)
  {
    var tramiteMember=$("#itemsTramites option:selected").text();
    var data={}; 
    if(jsn===null)
    {
      jsn=$("#jsonCode").val();
    }  
    var Resp=$.parseJSON(jsn);
    //console.log(jsn);
    dataP=$.parseJSON(dataP);
    //console.log(dataP);
    var subsidio_=searchIndex('subsidio',Resp.info.campos);
    var hoja_=searchIndex('hojas',Resp.info.campos);
    var municipio_=searchIndex('municipio',Resp.info.campos);
    var nombre_=searchIndex('nombre',Resp.info.campos);
    var apellidoMat_=searchIndex('apellidoMat',Resp.info.campos);
    var apellidoPat_=searchIndex('apellidoPat',Resp.info.campos);
    var sdivisas=searchIndex('divisas',Resp.info.campos);
    var escrituraActaOficio_=searchIndex('escrituraActaOficio',Resp.info.campos);
    var nombreSolicitante=nombre_+" "+apellidoPat_+" "+apellidoMat_;
    var divisas=searchDivisa(sdivisas);
    if(typeof (municipio_) !== 'object')
    {
        municipio_=[{nombre:municipio_}];
    }else{
       Mp=municipio_;
    }
    if(typeof(municipio_.nombre)!=='undefined')
    {
      municipio_=[municipio_];
    }
    if(typeof (escrituraActaOficio_) === 'object'){
      escrituraActaOficio_=conctenaM(escrituraActaOficio_);
    }else{          
       escrituraActaOficio_=escrituraActaOficio_;
    }
    Mp=conctenaM(municipio_);
    Object.assign(data,{solicitanteNombre:Resp.info.solicitantes[0].nombreSolicitante+" "+Resp.info.solicitantes[0].apPat+" "+Resp.info.solicitantes[0].apMat});    
    Object.assign(data,{municipioConc:Mp});    
    Object.assign(data,{municipio:municipio_});    
    Object.assign(data,{escrituraActaOficio:escrituraActaOficio_});    
    Object.assign(data,{lote:searchIndex('lote',Resp.info.campos)});    
    Object.assign(data,{hoja:hoja_});    
    Object.assign(data,{pagos:Resp.pagos});    
    Object.assign(data,{partida:Resp.partida});    
    Object.assign(data,{divisa:divisas});    
    Object.assign(data,{fse:Resp.id_transaccion});    
    if(typeof (subsidio_) !== 'object')
    {
      Object.assign(data,{subsidio:null});
    }else{
      Object.assign(data,{subsidio:subsidio_.nombre});
    }
    if(typeof(dataP.folio)==='undefined')
    {
      Object.assign(data,{folio:null});
      Object.assign(data,{fecha:null});
      Object.assign(data,{hora:null});
    }else{
      Object.assign(data,{folio:dataP.folio});
      Object.assign(data,{fecha:dataP.fecha});
      Object.assign(data,{hora:dataP.hora});
    }
    Object.assign(data,{folioPago:Resp.id_transaccion_motor});
    Object.assign(data,{Municipio:"Monterrey, NL."});
    
    Object.assign(data,{razonSocial:searchIndex('razonSocial',Resp.info.campos)});
    Object.assign(data,{folioTramite:Resp.id});
    Object.assign(data,{hojas:searchIndex('hojas',Resp.info.campos)});
    Object.assign(data,{tramite_id:Resp.info.tramite_id}); 
    Object.assign(data,{tramite:Resp.info.tramite}); 
    Object.assign(data,{valorOperacion:searchIndex('valorOperacion',Resp.info.campos)});
   
    if(typeof(Resp.notary_number)!=="undefined"){
      Object.assign(data,{noNotaria:Resp.notary_number});
      Object.assign(data,{elaboro:Resp.nombre_usuario_tramite+" "+Resp.apellido_pat_tramite+" "+Resp.apellido_mat_tramite});
    }else{
      Object.assign(data,{noNotaria:0});
      Object.assign(data,{elaboro:Resp.info.solicitantes[0].nombreSolicitante+" "+Resp.info.solicitantes[0].apPat+" "+Resp.info.solicitantes[0].apMat});
    }
    Object.assign(data,{recibe:"{{ Auth::user()->name }}"});
    if(typeof(Resp.total)==="undefined")
    {
      if(Resp.info.costo_final=="undefined")
      {
        Object.assign(data,{costo_final:Resp.info.detalle.costo_final});
      }else{
        Object.assign(data,{costo_final:Resp.info.costo_final});
      }
    }else{
      Object.assign(data,{costo_final:Resp.total});
    }
    //console.log(data);
    return data;

  }
  function limpiar()
  {
    $("#checkbox1").prop("checked", false);
    $("#checkbox30").prop("checked", false);
    $(".selectMotivos").css("display", "none");
    document.getElementById("message").value="";
    document.getElementById("message").disabled=false;
    document.getElementById('delFile').click();
    
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
  </script>

@endsection
