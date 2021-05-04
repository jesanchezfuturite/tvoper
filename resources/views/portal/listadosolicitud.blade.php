@extends('layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link href="assets/global/dataTable/dataTables.min.css" rel="stylesheet" type="text/css"/>
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
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group"> 
		                	<label >Estatus</label>          
						    <select class="select2me form-control" name="opEstatus" id="opEstatus" onchange="">	       	
						       <option value="0">------</option>
						       @foreach( $status as $sd)
                       			 <option value="{{$sd['id']}}">{{$sd["descripcion"]}}</option>
                      			@endforeach     
						    </select>  
		                </div>
		            </div>
		            <div class="col-md-2 col-ms-12">
		                <div class="form-group"> 
		                	<label >No. Solicitud</label>          
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
    		<div id="removetable">
          		<table class="table table-hover" cellspacing="0" width="100%"  id="example">
            	<thead>
                <tr>
                    <th></th>
                    <th>ID Grupo</th>
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
          <div class="col-md-3 group-btn1">
            <button type="button"  data-dismiss="modal" class="btn green right btn_cerrar_1" id="btn_cerrar_1"  onclick="cerrarTicket()">Cerrar Ticket</button>
          </div>
        </div>        
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
        <div class="content-detalle">
        <div class="row divDetalles">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos generales</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="detalles">
            <div id="addDetalles">
            </div>
          </div>    
        </div>
        <div class="row divSolicitante">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos del solicitante</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="solicitante">
            <div id="addSolicitante">
            </div>
          </div>    
        </div>
        <div class="row divNotaria">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos de la Notaria</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="notaria">
            <div id="addnotaria">
            </div>
          </div>    
        </div>
      </div>
      <div class="content-mensajes">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Nuevo mensaje</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">             
              <div class="form-group">
                <label>Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Escribe..." id="message"></textarea>
                <span class="help-block">&nbsp;</span>
                <div class='md-checkbox'>
                  <input type='checkbox' id='checkbox1' name="checkMotivos" class='md-check' onchange="changeMotivos()">
                    <label for='checkbox1'>
                    <span></span>
                    <span class='check'></span> <span class='box'>
                    </span> Rechazo. </label>
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
                <span class="help-block">&nbsp;</span>
                <div class='md-checkbox'>
                  <input type='checkbox' id='checkbox30' name="checkbox30" class='md-check'>
                    <label for='checkbox30'>
                    <span></span>
                    <span class='check'></span> <span class='box'>
                    </span>  Mensaje Publico. </label>
                </div>
                
              </div>
            </div>
            <div class="col-md-3">             
              <div class="form-group">
                <span class="help-block">&nbsp;</span>                
                <button type="button" class="btn blue" onclick="saveMessage(0,{})"><i class="fa fa-check"></i> Guardar</button>
                <span class="help-block">&nbsp;</span>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn green btn-file">
                        <span class="fileinput-new">
                        <i class="fa fa-plus"></i>&nbsp; &nbsp;Adjuntar Archivo </span>
                        <span class="fileinput-exists">
                        <i class="fa fa-exchange"></i>&nbsp; &nbsp;Cambiar Archivo </span>
                        <input type="file" name="file" accept="application/pdf" id="file">
                        </span>
                        <div class="col-md-12"><span class="fileinput-filename" style="display:block;text-overflow: ellipsis;width: 140px;overflow: hidden; white-space: nowrap;">
                        </span>&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"style="position: absolute;left: 155px;top: 4px" id="delFile">
                        </a></div>
                        
                </div>
              </div>
            </div>
          </div>        
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Mensajes registrados</strong></h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
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
          <div class="col-md-3 group-btn2">
            <button type="button" data-dismiss="modal" class="btn green btn_cerrar_2" id="btn_cerrar_2" onclick="cerrarTicket()" >Cerrar Ticket</button>
          </div>
        </div>
      </div>   
    </div>
  </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection

@section('scripts')
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="assets/global/dataTable/dataTables.min.js"></script>
  <script src="assets/global/dataTable/jszip.min.js"></script>
  <script src="assets/global/dataTable/vfs_fonts.js"></script>
	<script>
	jQuery(document).ready(function() {
   // TableManaged2.init2();
    $(".btnPrelacion").css("display", "none");
      $(".selectMotivos").css("display", "none");
    });
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
  function prelacion()
  {    
   $.ajax({
      method: "get",            
      url: "{{ url('/wsrp/qa') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {     
        //console.log(response);
        var resp=$.parseJSON(JSON.stringify(response));
        document.getElementById("message").value="Prelacion, Folio: " + resp.folio + "\n Fecha: "+resp.fecha; 
        var data=dataPrelacion(JSON.stringify(response));
        saveMessage(1,data);
        $(".btnPrelacion").css("display", "none");
        })
      .fail(function( msg ) {
         Command: toastr.warning("Error al Guardar", "Notifications")   });
      
  }
  function findSol()
  {
    $.ajax({
      method: "get",            
      url: "{{ url('/find-solicitudes') }}",
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
  function findMotivosSelect()
  {
    var id_catalogo_=$("#opTipoSolicitud").val();
      $.ajax({
          method: "get",            
          url: "{{ url('/get-solicitudes-motivos') }}"+"/"+id_catalogo_,
          data: {_token:'{{ csrf_token() }}'}  })
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
      var formdata={            };
    	if(noSolicitud.length>0){
         Object.assign(formdata,{id_solicitud:noSolicitud});  
    	}else if(opTipoSolicitud !="0" && opEstatus !="0"){
    		Object.assign(formdata,{id_solicitud:noSolicitud}); 
        Object.assign(formdata,{tipo_solicitud:opTipoSolicitud});    
    	}else if(opTipoSolicitud != "0"){ 
        Object.assign(formdata,{tipo_solicitud:opTipoSolicitud});  
    	}else if( opEstatus != "0"){   
        Object.assign(formdata,{estatus:opEstatus}); 
    	}else{
    		Command: toastr.warning("campo Tipo Solitud / Estatus / Numero de Solitud, requerido!", "Notifications");
    		return;
    	}
      Object.assign(formdata,{_token:'{{ csrf_token() }}'});  
    	$.ajax({
           method: "POST", 
           url: "{{ url('/filtrar-solicitudes') }}",
           data: formdata })
        .done(function (response) {
        var objectResponse=[];
            if(typeof response=== 'object')
            {
            for (n in response) {                 
                  objectResponse.push(response[n]); 
              }  
              //console.log(objectResponse);
             response=objectResponse;
            }
            
            findMotivosSelect();
            createTable(response);  
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  	}
    function createTable( dataS){
      //console.log(dataS);
      var table = $('#example').DataTable();
                table.destroy();    

      $('#example').DataTable( {
               "data": dataS,
                "columns": [
                  {
                "data": "id_transaccion",
                "grupo":"grupo",
                "class": 'detectarclick',
                "width": "3%",
                "render": function ( data, type, row, meta , grupo) {
                  
                  return row.grupo.length > 0 ? '<a ><i id="iconShow-' + data  +'" class="fa fa-plus"></a>' : '';
                }
              },
                  { "data":"id_transaccion"},
                  {
                    "data": "id_transaccion",
                    
                    "render": getTemplateAcciones
                  }
              ]
        });
      $('#example tbody').unbind().on('click', 'td.detectarclick', buildTemplateChild );
    }
    function buildTemplateChild(){
      var table = $('#example').DataTable();
          var tr = $(this).parents('tr');
          var row = table.row( tr );
          if(row.data() && row.data().grupo.length > 0){
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
              $("#iconShow-" + row.data().id_transaccion).addClass("fa-plus").removeClass("fa-minus");
            } else {
                $("#iconShow-" + row.data().id_transaccion).removeClass("fa-plus").addClass("fa-minus");
                row.child( "<div style='margin-left:15px; margin-right:100px;'>"  + format(row.data()) + "</div>").show();
                tr.addClass('shown');
            }
        }
    }
    function getTemplateAcciones( data, type, row, meta){
      let botonAtender = "<td class='text-center' width='10%'><a class='btn default btn-xs blue' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender' onclick='findMessage(\""+row.id_transaccion+"\")'> <strong>Asignar ("+row.grupo.length+")</strong> </a></td>";
      console.log(row.grupo[0]);
      if(row.grupo[0].status==1)
        return botonAtender;  
      else{
        return "<td class='text-center' width='10%'></td>"
      }
    }
    function format ( d ) {       
        let html = '<table class="table table-hover">';
        html += "<tr><th></th><th>ID Solicitud</th><th>Titulo</th><th>Estatus</th><th>Fecha Ingreso</th> <th></th></tr>";
        d.grupo.forEach( (solicitud) =>{          
          let botonAtender = "<td class='text-center' width='20%'><a class='btn default btn-xs blue-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender' onclick='findAtender(\""+solicitud.id+"\",\""+solicitud.status+"\")'><strong>Atender &nbsp;&nbsp; </strong> </a></td>";
       
        let tdShowHijas = solicitud.grupo && solicitud.grupo.length > 0 ? "<a onclick='showMore(" + JSON.stringify(solicitud) +", event)' ><i id='iconShowChild-" + solicitud.id_transaccion  +"' class='fa fa-plus'></a>" : '';
        
            html += '<tr id="trchild-' + solicitud.id_transaccion +'" ><td style="width:3%;">' + tdShowHijas +'</td><td>'+ solicitud.id  + '</td><td>'+ solicitud.titulo  + '</td><td>'+ solicitud.descripcion  + '</td><td>'+ solicitud.created_at  + '</td><td>'+ botonAtender + '</td></tr>'
        
        });
        html+='</table>';
        return html;
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
    }
    function findAtender(id,estatus)
    {addInfo();
      document.getElementById("idmodal").textContent=id;
      document.getElementById("idTicket").value=id;
      findMessage(id);
      $.ajax({
           method: "GET", 
           url: "{{ url('/atender-solicitudes') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          document.getElementById("jsonCode").value=JSON.stringify(response);
          var Resp=response;
          var soli=Resp.solicitante;
          var tipo="";
          var obj="";
          for (n in soli) {  
            obj=n;
            tipo=soli[n];    
            if(tipo=="pm"){tipo="Moral";}
            if(tipo=="pf"){tipo="Fisica";}
            if(obj=="tipoPersona"){obj="Tipo Persona";}
            if(obj=="rfc"){obj="RFC";}
            if(obj=="razonSocial"){obj="Razón Social";}
            if (obj!="notary" && obj!="id")
            {
              $("#addSolicitante").append("<div class='col-md-4'><div class='form-group'><label><strong>"+obj+":</strong></label><br><label>"+tipo+"</label></div></div>");            
            }            
          }
          if(typeof(Resp.solicitante.notary)){
            $(".divNotaria").css("display", "block");
            for (not in Resp.solicitante.notary) {  
              if(not=='notary_number' || not=='email' || not=='phone')
              {             
                $("#addnotaria").append("<div class='col-md-4'><div class='form-group'><label><strong>"+not+":</strong></label><br><label>"+Resp.solicitante.notary[not]+"</label></div></div>");
              }
            }
          }
          for (n in Resp.campos) {  
            if(typeof (Resp.campos[n]) !== 'object') {         
              $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+Resp.campos[n]+"</label></div></div>");  
            }          
          }
          if(Resp.continuar_solicitud==0 && Resp.tramite_prelacion!=null && Resp.mensaje_prelacion==null) 
          {
            $(".btnPrelacion").css("display", "block");
          }else{
             $(".btnPrelacion").css("display", "none");
          }

         var btn_1=document.getElementById('btn_cerrar_1');
         var btn_2=document.getElementById('btn_cerrar_2'); 
         
          //console.log(btn_1);
          if(Resp.continuar_solicitud==0)
          {
            btn_1.innerHTML="Cerrar Ticket";
            btn_2.innerHTML="Cerrar Ticket";
            btn_1.value="cerrar";
            btn_2.value="cerrar";             
          }else{
            btn_1.innerHTML="Continuar Solicitud";
            btn_2.innerHTML="Continuar Solicitud";
            btn_1.value="continuar";
            btn_2.value="continuar";
          }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function findMessage(id_)    
    {
      $.ajax({
           method: "GET", 
           url: "{{ url('/listado-mensajes') }}" + "/"+id_,
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
                  +"<td><a href='/listado-download/"+item.attach+"' title='Descargar Archivo'>"+attach+" "+icon+"</a></td>"
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
      var btn_2=$("#btn_cerrar_2").val();
      //console.log(btn_2);
     $.ajax({
           method: "POST", 
           url: "{{ url('/cerrar-ticket') }}",
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
      var check=$("#checkbox30").prop("checked");
      var checkRechazo=$("#checkbox1").prop("checked");
      var msjpublic="1";
      var rechazo=0;
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
        mensaje="Motivo de rechazo: "+mot +mensaje;
      }
      if(mensaje.length==0){
        Command: toastr.warning("Mensaje, Requerido!", "Notifications")
      }else{
        var fileV = $("#file")[0].files[0];                  
        var formdata = new FormData();

        if(file.length>0){ 
          formdata.append("file", fileV);
        }              
        formdata.append("id", id_);      
        formdata.append("mensaje", mensaje);
        formdata.append("mensaje_para", msjpublic);
        formdata.append("prelacion", prelacion_);
        formdata.append("rechazo", checkRechazo);
        formdata.append("data", JSON.stringify(data));
        formdata.append("_token",'{{ csrf_token() }}');
        //console.log(Object.fromEntries(formdata));
        $.ajax({
           method: "POST",
           contentType: false,
            processData: false, 
           url: "{{ url('/guardar-solicitudes') }}",
           data: formdata })
        .done(function (response) {
          //console.log(response.solicitante);
           if(response.Code=="200")
             {
              document.getElementById("message").value="";
              document.getElementById("file").value="";
              limpiar();
              findMessage(id_);
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
    }

  function dataPrelacion(dataP)
  {
  
    var tramiteMember=$("#itemsTramites option:selected").text();
    var data={};
    var jsn=$("#jsonCode").val();
    var Resp=$.parseJSON(jsn);
   //console.log(Resp);
    for (n in Resp.campos) { 
      if(n.toLowerCase()=="lote")
      {
        Object.assign(data,{lote:Resp.campos[n]});
      }
      if(n.toLowerCase()=="subsidio")
      {
        Object.assign(data,{subsidio:Resp.campos[n]});
      } 
    }
    dataP=$.parseJSON(dataP); 
    if(typeof(dataP.folio)=='undefined' || typeof(dataP.folio)==null)
    {
    Object.assign(data,{folio:null});
    Object.assign(data,{fecha:null});
    Object.assign(data,{hora:null});
    }else{
      Object.assign(data,{folio:dataP.folio});
    Object.assign(data,{fecha:dataP.fecha});
    Object.assign(data,{hora:dataP.hora});
    }
    
    Object.assign(data,{razonSocial:Resp.solicitante.razonSocial});
    Object.assign(data,{tramite_id:Resp.tramite_id}); 
    Object.assign(data,{tramite:Resp.tramite}); 
    if(Resp.costo_final=="undefined")
    {
      Object.assign(data,{costo_final:Resp.detalle.costo_final});
    }else{
      Object.assign(data,{costo_final:Resp.costo_final});
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
	</script>
@endsection
