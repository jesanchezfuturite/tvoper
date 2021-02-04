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
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos del Generales</strong></h4>
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
        <div class="row">
          <div class="col-md-12">
            <div class="portlet-body form">
              <div class="form-body">
                <h4 class="form-section"><strong>Datos del Solicitante</strong></h4>
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
                <button type="button" class="btn blue" onclick="saveMessage(0)"><i class="fa fa-check"></i> Guardar</button>
                <span class="help-block">&nbsp;</span>
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
          <span class="help-block">&nbsp;</span>
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
        <div class="row">
          <div class="col-md-9 "></div>
          <div class="col-md-1 ">
            <div class="form-group ">
              <button type="button"  class="btn default btnPrelacion " onclick="prelacion()" >Prelación</button>
            </div>
          </div>
          <div class="col-md-2">
            <button type="button" data-dismiss="modal" class="btn green" onclick="cerrarTicket()" >Cerrar Ticket</button>
          </div>
        </div>
      </div>   
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
	jQuery(document).ready(function() {
    TableManaged2.init2();
    $(".btnPrelacion").css("display", "none");
    });
  function prelacion()
  {    
    $.ajax({
      method: "get",            
      url: "{{ url('/wsrp/qa') }}",
      data: {_token:'{{ csrf_token() }}'}  })
      .done(function (response) {     
        console.log(response);
        var resp=$.parseJSON(JSON.stringify(response));
        document.getElementById("message").value="Prelacion, Folio: " + resp.folio + "\n Fecha: "+resp.fecha;
        saveMessage(1);
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
        console.log(response);
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
            var bton="";
            $.each(Resp, function(i, item) {
              if(item.status==2)
              {
                bton="<td class='text-center' width='20%'></td>";
              }else{
                bton="<td class='text-center' width='20%'><a class='btn default btn-xs blue-stripe' href='#portlet-atender' data-toggle='modal' data-original-title='' title='Atender' onclick='findAtender(\""+item.id+"\")'> Atender </a></td>";
              }
            	$('#sample_2 tbody').append("<tr>"
                	+"<td>"+item.id+"</td>"
                	+"<td>"+item.titulo+"</td>"
                	+"<td>"+item.descripcion+"</td>"
                	+"<td>"+item.created_at+"</td>"
                	+ bton
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
      $("#detalles div").remove();
      $("#detalles").append("<div id='addDetalles'></div>");
      $("#solicitante div").remove();
      $("#solicitante").append("<div id='addSolicitante'></div>");
      $.ajax({
           method: "GET", 
           url: "{{ url('/atender-solicitudes') }}" + "/"+id,
           data:{ _token:'{{ csrf_token() }}'} })
        .done(function (response) {
          console.log(response);
          var Resp=response;
          var soli=Resp.solicitante;
          var tipo="";
          var obj="";
          for (n in soli) {  
            obj=n;
            tipo=soli[n];    
            if(tipo=="pm")
            {tipo="Moral";}
            if(tipo=="pf")
            {tipo="Fisica";}
            if(obj=="tipoPersona"){
              obj="Tipo Persona";
            }if(obj=="rfc"){
              obj="RFC";
            }if(obj=="razonSocial"){
              obj="Razón Social";
            }

              $("#addSolicitante").append("<div class='col-md-4'><div class='form-group'><label><strong>"+obj+":</strong></label><br><label>"+tipo+"</label></div></div>");            
          }
          for (n in Resp.campos) {            
              $("#addDetalles").append("<div class='col-md-4'><div class='form-group'><label><strong>"+n+":</strong></label><br><label>"+Resp.campos[n]+"</label></div></div>");            
          }
          if(Resp.prelacion==null || Resp.prelacion=="null" || Resp.mensaje_prelacion==1) 
          {
            $(".btnPrelacion").css("display", "none");
          }else{
             $(".btnPrelacion").css("display", "block");
          }
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
          var icon="";
          var attach="";
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
              $('#sample_7 tbody').append("<tr>"
                  +"<td>"+item.mensaje+"</td>"
                  +"<td><a href='/listado-download/"+item.attach+"' title='Descargar Archivo'>"+attach+" "+icon+"</a></td>"
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
      $.ajax({
           method: "POST", 
           url: "{{ url('/cerrar-ticket') }}",
           data:{ id:idT ,id_catalogo:id_catalogo_,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
          //console.log(response.solicitante);

           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               findSolicitudes();
               findSol();
               chgopt(id_catalogo_);

               return;
             }
          //TableManaged7.init7();   
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }async function chgopt(id)
  {  
    await sleep(2000);
    $("#opTipoSolicitud").val(id).change();
  } 
  function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
  }
    function saveMessage(prelacion_)
    {
      var mensaje=$("#message").val();
      var file=$("#file").val();
      var id_=$("#idTicket").val();
      var check=$("#checkbox30").prop("checked");
      var msjpublic="1";
      if(check==false){
        var msjpublic="0";
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
              $("#checkbox30").prop("checked", false);
              findMessage(id_);
               Command: toastr.success(response.Message, "Notifications")
               $(".btnPrelacion").css("display", "none");
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
