@extends('layout.app')

@section('content')

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
		            <div class="col-md-3 col-ms-12">
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
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group"> 
		                	<label >No. Solicitud</label>          
						    <input type="text" class="form-control" name="noSolicitud" id="noSolicitud" placeholder="Ingrese Numero de Solicitud...">  
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
          		<table class="table table-hover" id="sample_2">
            		<thead>
              			<tr>
              			<th>ID</th>
              			<th>Titulo</th>
              			<th>Estatus</th>
              			<th>Fecha de Ingreso</th>
            			<th>&nbsp;</th>
            			</tr>
          			</thead>
          			<tbody>                   
                         
          			</tbody>
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
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" ></button>
        <h4 class="modal-title">Información de la Solicitud <label id="idmodal">1</label> </h4>
        <div style="text-align: right !important;"><button type="button"  data-dismiss="modal" class="btn green right" style="text-align: right;" onclick="cerrarTicket()">Cerrar Ticket</button></div>
      </div>
      <div class="modal-body" style="height:520px  !important;overflow-y:scroll;overflow-y:auto;">
        <input type="text" name="idTicket" id="idTicket" hidden="true">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4">             
              <div class="form-group">
                <label><strong>Nombre Solicitante:</strong></label><br>                
                <label id="nomsolic"></label>
              </div>
            </div>
            <div class="col-md-4">             
              <div class="form-group">
                <label><strong>Apellido Materno:</strong></label><br>                
                <label id="apMat"></label>
              </div>
            </div>
            <div class="col-md-4">             
              <div class="form-group">
                <label><strong>RFC:</strong></label><br>                
                <label id="rfc"></label>
              </div>
            </div>
          </div>        
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12"> 
              <hr>
            </div>
          </div>        
        </div>        
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-9">             
              <div class="form-group">
                <label>Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Escribe..." id="message"></textarea>
              </div>
            </div>
            <div class="col-md-3">             
              <div class="form-group">
                <span class="help-block">&nbsp;</span>
                <button type="button" class="btn blue" onclick="saveMessage()"><i class="fa fa-check"></i> Guardar</button>
                <br>
                <br>
                <span class="btn green fileinput-button">
                  <i class="fa fa-plus"></i>&nbsp;
                  <span>Adjuntar</span>
                  <input type="file" name="file" id="file">
                </span>
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
                        <th>Mensajes</th>
                        <th>Archivo</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>          
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn green" onclick="cerrarTicket()" >Cerrar Ticket</button>
      </div>   
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
    TableManaged7.init7();
    });

   	function findSolicitudes(){
    	var noSolicitud=$("#noSolicitud").val();
    	var opTipoSolicitud=$("#opTipoSolicitud").val();
    	var opEstatus=$("#opEstatus").val();
    	var formdata = new FormData();

    	if(noSolicitud.length>0){
    		formdata.append("id_solicitud", noSolicitud);  
    	}else if(opTipoSolicitud !="0" && opEstatus !="0"){
    		formdata.append("estatus", opEstatus);    
    		formdata.append("tipo_solicitud", opTipoSolicitud);   
    	}else if(opTipoSolicitud != "0"){
    		formdata.append("tipo_solicitud", opTipoSolicitud);  
    	}else if( opEstatus != "0"){
    		formdata.append("estatus", opEstatus);    
    	}else{
    		Command: toastr.warning("campo Tipo Solitud / Estatus / Numero de Solitud, requerido!", "Notifications");
    		return;
    	}
    	formdata.append("_token", '{{ csrf_token() }}');  
    	$.ajax({
           method: "POST", 
           contentType: false,
            processData: false,
           url: "{{ url('/filtrar-solicitudes') }}",
           data: formdata })
        .done(function (response) {
        	//var Resp=$.parseJSON(response);
            addtable();
            console.log(response);
            //console.log(JSON.stringify(response));
            if(JSON.stringify(response)=='[]')
            	{TableManaged2.init2();  return;}
            var Resp=$.parseJSON(JSON.stringify(response));
            $.each(Resp, function(i, item) {
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.titulo+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+ "<td class='text-center' width='20%'><a class='btn default btn-xs blue-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender' onclick='findAtender(\""+item.id+"\")'> Atender </a></td>"
                	+"</tr>"
                );
            });
        	TableManaged2.init2();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
  	}
  	function addtable(){
    	$("#addtables div").remove();
    	$("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr><th>ID</th><th>Titulo</th><th>Estatus</th><th>Fecha Ingreso</th><th>&nbsp;</th> </tr></thead> <tbody></tbody> </table></div>");
    }
    function tableMsg(){
      $("#addtableMsg div").remove();
      $("#addtableMsg").append("<div class='removeMsg'> <table class='table table-hover' id='sample_7'> <thead><tr><th>Mensajes</th><th>Archivo</th> <th>Fecha</th> </tr></thead> <tbody></tbody> </table></div>");
    }
    function findAtender(id)
    {
      document.getElementById("idmodal").textContent=id;
      document.getElementById("idTicket").value=id;
      findMessage(id);
      $.ajax({
           method: "GET", 
           url: "{{ url('/atender-solicitudes') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response.solicitante);
          var Resp=$.parseJSON(response);
          var soli=Resp.solicitante;
          document.getElementById("nomsolic").textContent=soli.nombreSolicitante;
          document.getElementById("apMat").textContent=soli.apMat;
          document.getElementById("rfc").textContent=soli.rfc;
           
          //TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
     function findMessage(id_)
    {
     // console.log(id_);
      $.ajax({
           method: "GET", 
           url: "{{ url('/listado-mensajes') }}" + "/"+id_,
           data:{_token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response.solicitante);
          tableMsg();
          var resp=$.parseJSON(response);
           $.each(resp, function(i, item) {
              $('#sample_7 tbody').append("<tr>"
                  +"<td>"+item.mensaje+"</td>"
                  +"<td>"+item.attach+"</td>"
                  +"<td>"+item.created_at+"</td>"
                  +"</tr>"
                );
            });
          
          TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function cerrarTicket()
    {
      var idT=$("#idTicket").val();
      $.ajax({
           method: "POST", 
           url: "{{ url('/cerrar-ticket') }}",
           data:{ id:idT ,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response.solicitante);

           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               return;
             }
          //TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function saveMessage()
    {
      var mensaje=$("#message").val();
      var file=$("#file").val();
      var id_=$("#idTicket").val();
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
        formdata.append("_token",'{{ csrf_token() }}');
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
              findMessage(id_);
               Command: toastr.success(response.Message, "Notifications")
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
	</script>
@endsection
